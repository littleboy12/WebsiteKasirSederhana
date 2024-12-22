# Website Pendaftaran Seminar

## Pembuat
- **NAMA   : ALDI TULUS P**
- **NIM    : 2200018097**
- **KELAS  : C**
  
- **NAMA   : M ALVIN KHOIRUL RIZKI**
- **NIM    : -**
- **KELAS  : C**

## Teknologi yang Digunakan
- **Frontend**:
  - HTML
  - CSS
  - JavaScript
  
- **Backend**:
  - PHP 
  - MySQL

- **Library dan Framework**:
  - Bootstrap
  
## Instalasi

### Persyaratan Sistem
- Web server - phpMyAdmin
- PHP (versi 7.4 atau lebih tinggi)
- MySQL
- Text editor

### Langkah-langkah Instalasi
1. **Clone repository**:
    ```bash
    git clone https://github.com/littleboy12/pendaftaranSeminar.git
    ```

2. **Pindahkan file ke direktori root server**:
   - Pindahkan folder project ke dalam folder `htdocs` (untuk XAMPP) atau folder root server lainnya.

3. **Buat database di MySQL**:
   - Masuk ke phpMyAdmin atau menggunakan command line untuk membuat database:
     ```sql
     CREATE DATABASE db_poskonter;
     ```

4. **Impor file database**:
   - Gunakan file SQL yang ada di folder `db` untuk mengimpor tabel-tabel yang diperlukan ke dalam database `db_poskonter`.

5. **Konfigurasi koneksi database**:
   - Edit file `config.php` dan sesuaikan dengan detail koneksi database (host, username, password, dan nama database).

6. **Akses aplikasi**:
   - Buka browser dan akses URL berikut:
     ```
     http://localhost/nama-folder/
     ```
## Kontribusi
Jika Anda ingin berkontribusi pada project ini, Anda dapat mengikuti langkah-langkah berikut:
1. Fork repository ini.
2. Buat branch baru (`git checkout -b fitur-baru`).
3. Lakukan perubahan dan commit (`git commit -am 'Menambahkan fitur baru'`).
4. Push branch ke repository Anda (`git push origin fitur-baru`).
5. Buat pull request untuk review.
