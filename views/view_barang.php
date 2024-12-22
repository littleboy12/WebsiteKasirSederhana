<?php include "../layout/header.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./view_login.php");

    exit();
}

?>

<main class="mt-4">
    <div class="mt-4 card p-4 bg-white shadow">
        <input type="text" class="form-control w-25 mb-4" id="search" placeholder="Cari Barang" onkeyup="searchData()">

        <div class="table-responsive table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="result">

                </tbody>
            </table>
            <nav>
                <ul id="pagination" class="pagination"></ul>
            </nav>
        </div>
    </div>
</main>
<div id="detailAlert" class="position-fixed translate-middle top-50 start-50 w-100 h-100 d-none" style="background-color: rgba(0, 0, 0, 0.466);">
    <div class="card position-fixed top-50 start-50 w-75 translate-middle bg-light">
        <div class="card-header">
            <h3>DETAIL BARANG</h3>
        </div>
        <div class="card-body">
        <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Awal</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Stok Min</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody id="resultDetail">

                </tbody>
            </table>
            <div id="alertStok" class="alert h-25 alert-sm">
                
            </div>
            <button class="btn btn-sm btn-danger" id="close">Tutup</button>
        </div>
    </div>
</div>


<?php include "../layout/footer.php" ?>
<script src="../public/js/barang.js"></script>
<!-- <script src="../public/js/search_kasir.js"></script> -->