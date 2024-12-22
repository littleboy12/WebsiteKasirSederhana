<?php
include "../services/config.php";
session_start();

$username = $password = "";
$error = [];

if (isset($_SESSION['username'])) {
    header("Location: ../views/view_dashboard.php");

    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sqlCekAccount = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");
    $sqlCekAccountPass = mysqli_query($conn, "SELECT * FROM tb_user WHERE `password` = '$password'");

    if (mysqli_num_rows($sqlCekAccount) > 0) {
        if (mysqli_num_rows($sqlCekAccountPass) > 0) {
            $row = mysqli_fetch_array($sqlCekAccount);
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['level'] = $row['level'];

            header("Location: ../views/view_dashboard.php");

            exit();
        } else {
            $error['errPassword'] = "Password Salah";
        }
    } else {
        $error['errUsername'] = "Username Atau Email Tidak Terdaftar";
    }
}