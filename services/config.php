<?php 

$conn = mysqli_connect("localhost","root","","db_poskonter");


if (mysqli_connect_errno()) {
    printf("Gagal", mysqli_connect_error());
}
?>