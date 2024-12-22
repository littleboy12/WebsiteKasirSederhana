<?php include "../layout/header.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./view_login.php");

    exit();
}

?>

<main class="mt-4">
    <div class="mt-4 card p-4 bg-white shadow">
        <input type="text" class="form-control w-25 mb-4" id="search" placeholder="Cari Nama Kasir" onkeyup="searchData()">

        <div class="table-responsive table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Kasir</th>
                        <th>Subtotal</th>
                        <th>Diskon</th>
                        <th>Total</th>
                        <th>Tanggal</th>
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
            <table class="table" style="border: transparent;" id="data">
                <tr>
                    <td class="w-25">Nama Kasir</td>
                    <td id="nama">nama</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td id="tanggal"></td>
                </tr>
            </table>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Barang</th>
                        <th>Harga Jual</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="resultDetail">

                </tbody>
            </table>
            <table class="table" style="border: transparent;" id="total">
                <tr>
                    <td class="w-25">Subtotal</td>
                    <td id="subtotal">Rp 0</td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td id="diskon">Rp 0</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td id="total">Rp 0</td>
                </tr>
            </table>
            <button class="btn btn-sm btn-danger" id="close">Tutup</button>
        </div>
    </div>
</div>


<?php include "../layout/footer.php" ?>
<script src="../public/js/penjualan.js"></script>
<!-- <script src="../public/js/search_kasir.js"></script> -->