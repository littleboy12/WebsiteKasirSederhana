
function searchData() {
    console.log("searchData() dipanggil");

    const query = document.getElementById('search').value.trim();
    console.log("Query pencarian:", query);

    if (!query) {
        console.log("Input pencarian kosong.");
        const result = document.getElementById("result");
        result.innerHTML = '<tr><td colspan="3">Masukkan kata kunci untuk mencari.</td></tr>';
        return;
    }

    fetch(`../public/kasir.php?q=${encodeURIComponent(query)}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            console.log("Data diterima:", data);

            const result = document.getElementById("result");
            result.innerHTML = '';

            if (data.length === 0) {
                result.innerHTML = '<tr><td colspan="3">Tidak ada hasil ditemukan.</td></tr>';
                return;
            }

            let nom = 1;
            data.forEach(product => {
                result.innerHTML += `
                <tr>
                    <td>${nom}</td>
                    <td>${product.kd_barang}</td>
                    <td>${product.nama_b}</td>
                    <td>${product.harga_jual_b}</td>
                    <td><input type="button" value="Beli" class="btn btn-primary" onclick = "cekout(${product.id_barang})"></td>
                </tr>`;
                nom++;
            });
        })
        .catch(error => {
            console.error("Error saat memuat data:", error);

            const result = document.getElementById("result");
            result.innerHTML = '<tr><td colspan="3">Terjadi kesalahan saat mengambil data.</td></tr>';
        });
}

document.getElementById('search').addEventListener('keyup', searchData);

let totalGlobal = 0
let totalDiskon = 0
var productBuy = [];

function cekout(id) {
    console.log("barang yang di ambil adalah = " + id);

    fetch(`../public/kasir.php?id_cekout=${encodeURIComponent(id)}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            const result = document.getElementById('buyProduct')
            const cekout = document.getElementById('CoProduct')

            if (data.length === 0) {
                alert("Barang yang dipilih belum ada di database.");
                return;
            }


            data.forEach(buyProduct => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="align-middle" style="width: 150px">${buyProduct.nama_b}</td>
                    <td class="align-middle">${buyProduct.harga_jual_b}</td>
                    <td class="align-middle"><input type="number" name="jumlah" value="1" class="form-control form-sm jumlah" id="jumlah"></td>
                    <td class="align-middle"><button class="cancel-btn btn btn-danger btn-sm">Batal</button></td>
                `;
                const co = document.createElement('tr');
                co.innerHTML = `
                    <td class="align-middle" style="width: 150px">${buyProduct.nama_b}</td>
                    <td class="align-middle">${buyProduct.harga_jual_b}</td>
                    <td class="align-middle jumlah"></td>
                    <td class="align-middle total"></td>
                `;
            
                const jumlah = row.querySelector('.jumlah');
                let totalHarga = parseInt(jumlah.value) * parseInt(buyProduct.harga_jual_b);
                co.querySelector('.total').textContent = totalHarga;
                co.querySelector('.jumlah').textContent = jumlah.value;
            
                result.appendChild(row);
                cekout.appendChild(co);
                totalGlobal += totalHarga;
                updateTotalGlobal();
                updateTotalBayar();
            
                
                UpdateBuyProduct(buyProduct, parseInt(jumlah.value));
            
               
                row.querySelector('.cancel-btn').addEventListener('click', () => {
                    const currentTotal = parseInt(co.querySelector('.total').textContent) || 0;
                    totalGlobal -= currentTotal;
                    updateTotalGlobal();
                    updateTotalBayar();
            
                    row.remove();
                    co.remove();
            
                   
                    UpdateBuyProduct(buyProduct, 0);
                    console.log("ARRAY",productBuy);
                    
                });
            
            
                jumlah.addEventListener('keyup', () => {
                    const inputVal = jumlah.value.trim();
                    const jumlahVal = inputVal === '' || isNaN(parseInt(inputVal)) ? 0 : parseInt(inputVal);
            
                   
                    const prevTotal = totalHarga;
                    totalHarga = jumlahVal * parseInt(buyProduct.harga_jual_b);
                    totalGlobal = totalGlobal - prevTotal + totalHarga;
            
                    co.querySelector('.total').textContent = totalHarga;
                    co.querySelector('.jumlah').textContent = jumlahVal;
                    updateTotalGlobal();
                    updateTotalBayar();
            
                    
                    UpdateBuyProduct(buyProduct, jumlahVal);
                });
            
                document.getElementById('diskon').addEventListener('keyup', () => {
                    const diskonInp = document.getElementById('diskon');
                    const diskonVal = diskonInp.value.trim();
                    const diskon = diskonVal === '' || isNaN(parseInt(diskonVal)) ? 0 : parseInt(diskonVal);
            
                    if (diskon > 100 || diskon < 0) {
                        alert("Diskon Tidak valid");
                        diskonInp.value = 0;
                        totalDiskon = 0
                        updateDiskon();
                        updateTotalBayar();
                        return;
                    }
            
                    totalDiskon = (totalGlobal * diskon) / 100;
                    updateDiskon();
                    updateTotalBayar();
                });
            });            
        })
        .catch(error => {
            const result = document.getElementById("result");
            result.innerHTML = '<tr><td colspan="3">Terjadi kesalahan saat mengambil data.</td></tr>';
        });
}


function updateTotalBayar() {
    const totalNew = document.getElementById('totalBayar');
    console.log("Total Semua : ", + totalGlobal - totalDiskon);
    
    totalNew.textContent = `Rp ${totalGlobal - totalDiskon}` ;

}

function updateDiskon() {
    const totalNew = document.getElementById('totalDiskon');
    console.log("Total Semua : ", + totalDiskon);
    
    totalNew.textContent = `Rp ${totalDiskon}` ;

}

function updateTotalGlobal() {
    const totalNew = document.getElementById('totalCo');
    console.log("Total Semua : ", + totalGlobal);
    
    totalNew.textContent = `Rp ${totalGlobal}` ;

}

function UpdateBuyProduct(buyProduct, jumlahVal) {
    const existingProductIndex = productBuy.findIndex(product => product.id === buyProduct.id_barang);

    if (jumlahVal > 0) {
        if (existingProductIndex !== -1) {
            productBuy[existingProductIndex].jumlah = jumlahVal;
        } else {
            productBuy.push({
                id: buyProduct.id_barang,
                nama: buyProduct.nama_b,
                harga: buyProduct.harga_jual_b,
                jumlah: jumlahVal
            })
        }
    } else if (existingProductIndex !== -1) {
        productBuy.splice(existingProductIndex, 1)
    }

    console.log("Data Yang Di Beli ", productBuy);
    
}

function checkout() {
    console.log(productBuy);
    console.log("Memulai proses checkout...");

    if (productBuy.length === 0) {
        alert("Tidak ada produk yang dibeli!");
        return;
    }

    console.log("Mengirim data ke server:", {
        products: productBuy,
        total: totalGlobal,
        discount: totalDiskon
    });

    fetch('../public/kasir.php?cekOut', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            products: productBuy,
            total: totalGlobal,
            discount: totalDiskon
        })
    })
        .then(response => {
            console.log("Status response:", response.status);
            console.log("Headers response:", response.headers);
            return response.json();
        })
        .then(result => {
            console.log("Response JSON:", result);
            if (result.success) {
                alert("Success")
                printNota();
                totalDiskon = 0
                totalGlobal = 0
                productBuy = [];

                document.getElementById('buyProduct').innerHTML = '';
                document.getElementById('CoProduct').innerHTML = '';
                document.getElementById('diskon').value = '';
                updateTotalGlobal();
                updateTotalBayar();
                updateDiskon();
            }
        })
        .catch(error => {
            console.error("Kesalahan fetch:", error);
        });
}

function printNota() {
    if (productBuy.length === 0) {
        alert("Tidak ada produk yang dibeli untuk dicetak!");
        return;
    }

    let notaContent = `
        <html>
        <head>
            <title>Nota Pembelian</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .total { font-weight: bold; }
            </style>
        </head>
        <body>
            <h2>Nota Pembelian</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>`;

    productBuy.forEach(product => {
        notaContent += `
            <tr>
                <td>${product.nama}</td>
                <td>Rp ${product.harga}</td>
                <td>${product.jumlah}</td>
            </tr>`;
    });

    notaContent += `
                </tbody>
            </table>
            <p>Total: Rp ${totalGlobal}</p>
            <p>Diskon: Rp ${totalDiskon}</p>
            <p>Total Bayar: Rp ${totalGlobal - totalDiskon}</p>
            <p>Terima kasih atas kunjungan Anda!</p>
        </body>
        </html>`;

    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write(notaContent);
    printWindow.document.close(); 
    printWindow.print(); 
}