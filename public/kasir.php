<?php
include "../services/config.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();

if (isset($_GET['q'])) {
    $key = $_GET['q'];

    $result = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_b LIKE '%$key%' OR kd_barang LIKE '%$key%'");
    $data = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

if (isset($_GET['id_cekout'])) {
    $key = $_GET['id_cekout'];

    $result = mysqli_query($conn, "SELECT * FROM tb_barang WHERE id_barang LIKE '%$key%'");
    $data = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}


if (isset($_GET["cekOut"])) {
    // Mengambil input JSON dari fetch
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Log input untuk debugging
    error_log("Input dari fetch: " . $input);

    // Validasi input
    if (!isset($data['products'], $data['total'], $data['discount'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Data tidak lengkap!',
            'DATA MASUK' => $data
        ]);
        exit;
    }

    
    $user = $_SESSION['id_user'];
    $id_beli = mb_convert_encoding("TRS-" . date('dmYHis'), "ISO-8859-1", "UTF-8"); // Format ID pembelian
    $product = $data['products'];
    $subtotal = $data['total'];
    $discount = $data['discount'];
    $total = $subtotal - $discount;
    $tgl_beli = date('Y-m-d H:i:s');

   
    mysqli_begin_transaction($conn);

    try {
        
        $queryBeli = "INSERT INTO `tb_pembelian`(`id_pembelian`, `id_user`, `subtotal`, `diskon`, `total`, `tanggal_beli`) 
                      VALUES ('$id_beli', '$user', $subtotal, $discount, $total, '$tgl_beli')";
        if (!mysqli_query($conn, $queryBeli)) {
            throw new Exception("Gagal insert pembelian: " . mysqli_error($conn));
        }

        
        foreach ($product as $item) {
            $id_produk = mysqli_real_escape_string($conn, $item['id']);
            $qty = (int)$item['jumlah'];

            
            $getData = mysqli_query($conn, "SELECT `stok_b`, `harga_awal_b`, `harga_jual_b` FROM `tb_barang` WHERE `id_barang` = '$id_produk'");
            if (!$getData || mysqli_num_rows($getData) === 0) {
                throw new Exception("Data barang tidak ditemukan untuk ID Barang: $id_produk");
            }

            $dataBarang = mysqli_fetch_assoc($getData);
            $stok_awal = (int)$dataBarang['stok_b'];
            $harga_awal = (int)$dataBarang['harga_awal_b'];
            $harga_jual = (int)$dataBarang['harga_jual_b'];

           
            if ($stok_awal < $qty) {
                throw new Exception("Stok tidak cukup untuk ID Barang: $id_produk (stok tersedia: $stok_awal, diminta: $qty)");
            }

           
            $subtotal_detail = $qty * $harga_jual;

           
            $queryDetail = "INSERT INTO `tb_detailpembelian`(`id_pembelian`, `id_barang`, `harga_awal`, `harga_jual`, `qty`, `subtotal`) 
                            VALUES ('$id_beli', '$id_produk', '$harga_awal', '$harga_jual', '$qty', '$subtotal_detail')";
            if (!mysqli_query($conn, $queryDetail)) {
                throw new Exception("Gagal insert detail pembelian untuk ID Barang: $id_produk: " . mysqli_error($conn));
            }

           
            $stok_baru = $stok_awal - $qty;
            $updateStok = "UPDATE `tb_barang` SET `stok_b` = '$stok_baru' WHERE `id_barang` = '$id_produk'";
            if (!mysqli_query($conn, $updateStok)) {
                throw new Exception("Gagal update stok untuk ID Barang: $id_produk: " . mysqli_error($conn));
            }
        }

        
        mysqli_commit($conn);
        echo json_encode([
            'success' => true,
            'message' => 'Pembelian berhasil disimpan!'
        ]);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Transaksi gagal: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}


