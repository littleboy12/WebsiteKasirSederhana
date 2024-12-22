<?php
include "../services/config.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $d = $_GET['q'];
     
    $query = mysqli_query($conn, "SELECT * FROM tb_pembelian INNER JOIN tb_user ON tb_pembelian.id_user = tb_user.id_user WHERE tb_user.nama LIKE '%$d%'");
    $data = [];
    
    
    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
} else if (isset($_GET["id_pembelian"])) {
    $key = $_GET['id_pembelian'];
    
    $query = mysqli_query($conn, "SELECT tb_detailpembelian.qty, tb_detailpembelian.harga_jual, tb_detailpembelian.subtotal AS subtotalBarang, tb_barang.nama_b, tb_pembelian.subtotal AS subtotalBeli, tb_pembelian.diskon, tb_pembelian.total, tb_pembelian.tanggal_beli, tb_user.nama FROM tb_detailpembelian INNER JOIN tb_pembelian ON tb_detailpembelian.id_pembelian = tb_pembelian.id_pembelian INNER JOIN tb_barang  ON tb_detailpembelian.id_barang = tb_barang.id_barang INNER JOIN tb_user ON tb_pembelian.id_user = tb_user.id_user WHERE tb_detailpembelian.id_pembelian = '$key'");

    $data = [];
    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
} else {
    $query = mysqli_query($conn, "SELECT * FROM tb_pembelian INNER JOIN tb_user ON tb_pembelian.id_user = tb_user.id_user");
    $data = [];
    
    
    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
}


