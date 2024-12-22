<?php include "../layout/header.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./view_login.php");

    exit();
}

?>

<h1>Selamat Datang <?= $_SESSION['nama'];?><?= $_SESSION['level'] !== 'admin' ? '' : " - Admin"?></h1>

<?php include "../layout/footer.php" ?>