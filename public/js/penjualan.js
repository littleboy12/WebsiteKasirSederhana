getDataGlobal();
function getDataGlobal(id_pembelian) {
    fetch('../public/penjualan.php')
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Data diterima:", data);
        if (id_pembelian !== undefined) {
            console.log(id_pembelian.toString());
            
            const item = data.find(row => String(row.id_pembelian) === id_pembelian.toString());
            if (item) {
                console.log("Detail Sesuai Id:", item);
                getData(item);
            } else {
                console.log("Data tidak ditemukan!");
            }
            return;   
        } else {;
            displayData(data, currentPage);
            setPagination(data);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });    
}

function searchData() {
    const query = document.getElementById('search').value.trim();

    if (!query) {
        getDataGlobal();
        return;
    }

    fetch (`../public/penjualan.php?q=${encodeURIComponent(query)}`)
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Data diterima:", data);
        displayData(data, currentPage);
        setPagination(data);
    })
    .catch((error) => {
        console.error('Error:', error);

        const result = document.getElementById("result");
        result.innerHTML = '<tr><td colspan="8">Terjadi kesalahan saat mengambil data.</td></tr>';
    });
}

const rowsPerPage = 10;
let currentPage = 1;

function displayData(data, page) {
    console.log('Data Array',data);
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedData = data.slice(start, end);
    
    const result = document.getElementById('result');
    result.innerHTML = '';
    
    if (paginatedData.length === 0) {
        result.innerHTML = '<tr><td colspan="8">Tidak ada data ditemukan.</td></tr>';
        return;
    }

    let nom = 1;
    paginatedData.forEach(row => {
        const product =  
        `<tr>
            <td>${nom}</td>
            <td>${row.id_pembelian}</td>
            <td>${row.nama}</td>
            <td>Rp ${row.subtotal}</td>
            <td>Rp ${row.diskon}</td>
            <td>${row.total}</td>
            <td>${row.tanggal_beli}</td>
            <td>
                <button class="btn btn-sm btn-success" onclick="showDetail('${row.id_pembelian}')">Detail</button>
            </td>
        </tr>`
        nom++;

        result.insertAdjacentHTML("beforeend", product);
    });
}

function setPagination(data) {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = ""; // Clear previous pagination

    const pageCount = Math.ceil(data.length / rowsPerPage);

    for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement("li");
        li.className = "page-item ";
        li.innerHTML = `<a href="#" class="page-link" data-page="${i}">${i}</a>`;
        pagination.appendChild(li);

        // Event listener untuk setiap tombol halaman
        li.addEventListener("click", function (e) {
            e.preventDefault();
            currentPage = i;
            displayData(data, currentPage);
            setPagination(data);
        });
    }
}

function getDataDetail(data) {
    fetch(`../public/penjualan.php?id_pembelian=${encodeURIComponent(data)}`)
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Data diterima:", data);
        displayDataDetail(data);
        // setPagination(data);
    })
    .catch((error) => {
        console.error('Error:', error);

        // const result = document.getElementById("result");
        // result.innerHTML = '<tr><td colspan="8">Terjadi kesalahan saat mengambil data.</td></tr>';
    });
}

function displayDataDetail(data) {
    const result = document.getElementById('resultDetail');
    result.innerHTML = '';
    
    if (data.length === 0) {
        result.innerHTML = '<tr><td colspan="4">Tidak ada data ditemukan.</td></tr>';
        return;
    }

    data.forEach(row => {
        const product =  
        `<tr>
            <td>${row.nama_b}</td>
            <td>Rp ${row.harga_jual}</td>
            <td>${row.qty}</td>
            <td>Rp ${row.subtotalBarang}</td>
        </tr>`

        result.insertAdjacentHTML("beforeend", product);
    });
    
}

function getData(data) {
    const dataPenjualan = document.getElementById('data');
    const total = document.getElementById('total');

    dataPenjualan.innerHTML = `
        <tr>
            <td class="w-25">Nama Kasir</td>
            <td>${data.nama}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>${data.tanggal_beli}</td>
        </tr>`
    
    total.innerHTML = `
         <tr>
            <td class="w-25">Subtotal</td>
            <td>Rp ${data.subtotal}</td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td>Rp ${data.diskon}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>Rp ${data.total}</td>
        </tr>`
}

function showDetail(id_pembelian) {
    const alertShow = document.getElementById('detailAlert');
    const close = document.getElementById('close');

    alertShow.classList.remove('d-none')
    close.addEventListener('click', function () {
        alertShow.classList.add('d-none')
    });
    getDataDetail(id_pembelian);
    getDataGlobal(id_pembelian);
}