<?php include "../layout/header.php";

// require_once "../public/kasir.php";
?>

<style>
    .card-container {
        max-height: 300px;
        /* Limit to 5 rows with scrolling */
        overflow-y: auto;
    }

    .table-container {
        max-height: 200px;
        /* Limit to 5 rows with scrolling */
        overflow-y: auto;
    }

    .table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }   
</style>

<main class="mt-4">
    <div class="p-4 card bg-white shadow-lg">
        <div class="row">
            <!-- Section Daftar Barang -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Daftar Barang</h5>
                    </div>
                    <div class="card-bod card-container">
                        <table class="table table-hover">
                            <tbody id="buyProduct">
                                <!-- Data Produk akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section CheckOut -->
            <div class="col-lg-6 mb-4 ">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">CheckOut</h5>
                    </div>
                    <div class="card-body card-container">
                        <table class="table border-0">
                            <tbody id="CoProduct">
                                <!-- Data Checkout akan ditampilkan di sini -->
                            </tbody>
                        </table>

                        <!-- Summary Section -->
                        <table class="table border-0">
                            <tr>
                                <td>
                                    <h6><b>Diskon (%)</b></h6>
                                </td>
                                <td>
                                    <input type="number" name="diskon" id="diskon" class="form-control w-50" placeholder="0">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6><b>Sub-Total</b></h6>
                                </td>
                                <td><b id="totalCo">Rp. 0</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6><b>Diskon</b></h6>
                                </td>
                                <td><b id="totalDiskon">Rp. 0</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6><b>Total</b></h6>
                                </td>
                                <td><b id="totalBayar">Rp. 0</b></td>
                            </tr>
                        </table>

                
                        <button class="btn btn-success btn-block" onclick="checkout()">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 card p-4 bg-white shadow">
        <input type="text" class="form-control w-50 mx-auto mb-4" id="search" placeholder="Cari Barang" onkeyup="searchData()">

        <div class="table-responsive table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Beli</th>
                    </tr>
                </thead>
                <tbody id="result">
                    
                </tbody>
            </table>
        </div>
    </div>
</main>



<?php include "../layout/footer.php" ?>
<script src="../public/js/search_kasir.js"></script>