<?php 
include "../services/config.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $key = $_GET['q'];
    
    $query = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_b LIKE '%$key%' OR kd_barang LIKE '%$key%'");
    $data = [];


    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
} else {
    $query = mysqli_query($conn, "SELECT * FROM tb_barang");
    $data = [];


    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

?>