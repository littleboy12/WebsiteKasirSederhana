console.log('ini BARANG');
getDataGlobal();

function getDataGlobal(id_barang) {
    fetch ('../public/barang.php')
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Data diterima:", data);
        if (id_barang !== undefined) {
            console.log(id_barang.toString());
            
            const item = data.find(row => String(row.id_barang) === id_barang.toString());
            if (item) {
                console.log("Detail Sesuai Id:", item);
                detailBarang(item);
            } else {
                console.log("Data tidak ditemukan!");
            }
            return;   
        } else {
            displayBarang(data, currentPage);
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

    fetch (`../public/barang.php?q=${encodeURIComponent(query)}`)
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Data diterima:", data);
        displayBarang(data, currentPage);
        setPagination(data);
        return data;
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

const rowsPerPage = 10;
let currentPage = 1;
const dataBarang = [];

function displayBarang(data, page) {
    console.log('Data Array',data);
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedData = data.slice(start, end);
    
    const result = document.getElementById('result');
    result.innerHTML = '';
    if (paginatedData.length === 0) {
        result.innerHTML = '<tr><td colspan="9">Tidak ada data ditemukan.</td></tr>';
        return;
    }
    let nom = 1;

    paginatedData.forEach(row => {
        const product =  
        `<tr>
            <td>${nom}</td>
            <td>${row.kd_barang}</td>
            <td>${row.nama_b}</td>
            <td>Rp ${row.harga_jual_b}</td>
            <td>${row.stok_b}</td>
            <td>
                <button class="btn btn-sm btn-success" id="show" onclick="showDetail(${row.id_barang})">Detail</button>
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
        li.className = "page-item " + (i === currentPage ? "active" : "");
        li.innerHTML = `<a href="#" class="page-link" data-page="${i}">${i}</a>`;
        pagination.appendChild(li);

        // Event listener untuk setiap tombol halaman
        li.addEventListener("click", function (e) {
            e.preventDefault();
            currentPage = i;
            displayBarang(data, currentPage);
            setPagination(data);
        });
    }
}

function showDetail(id_barang) {
    const alertShow = document.getElementById('detailAlert');
    const close = document.getElementById('close');

    alertShow.classList.remove('d-none')
    close.addEventListener('click', function () {
        alertShow.classList.add('d-none')
    });
    getDataGlobal(id_barang)
}

function detailBarang(data) {
    const detailBarang = document.getElementById('resultDetail');
    detailBarang.innerHTML = `
        <tr>
            <td>${data.kd_barang}</td>
            <td>${data.nama_b}</td>
            <td>Rp ${data.harga_awal_b}</td>
            <td>Rp ${data.harga_jual_b}</td>
            <td>${data.stok_b}</td>
            <td>${data.stok_min_b}</td>
            <td>${data.unit_b}</td>
        </tr>`;

    const alert = document.getElementById('alertStok')
    if (Number(data.stok_b) < Number(data.stok_min_b)) {
        alert.classList.add('alert-danger');
        alert.innerHTML = `Stok barang ${data.nama_b} Kurang, Segera Restok`
    } else {
        alert.classList.add('d-none');
    }
}