# Aplikasi CRUD Mahasiswa (PHP + PDO)

## Deskripsi
Aplikasi backend sederhana untuk melakukan operasi CRUD pada entitas `mahasiswa`. Menyertakan upload foto (jpg/png), validasi dasar, dan penyimpanan path foto di DB.

## Persyaratan
- PHP 8.x
- MySQL / MariaDB
- PDO extension enabled

## Setup
1. Import database:
   - Jalankan `mysql -u root -p < schema.sql` atau impor melalui phpMyAdmin.
2. Sesuaikan `inc/config.php` dengan kredensial DB Anda.
3. Buat folder `uploads/` dan beri permission agar dapat ditulis:
   - `mkdir uploads`
   - `chmod 0755 uploads` (atau `0777` jika dibutuhkan di lokal)
4. Jalankan built-in server PHP:
   - `php -S localhost:8000`
5. Akses aplikasi:
   - `http://localhost:8000/members.php`

## Struktur folder
/mahasiswa-crud/<br>
│── index.php<br> 
│── members.php<br>
│── create.php<br>
│── edit.php<br>
│── save.php<br>
│── update.php<br>
│── delete.php<br>
│── schema.sql<br>
│── uploads/<br>
│── css/style.css<br>
│── inc/<br>
│     └── config.php<br>
│── class/<br>
      └── Database.php<br>


## Catatan
- Validasi file: hanya jpg/jpeg/png, ukuran < 2MB.
- Field `nim` diatur UNIQUE.
- Saat update, jika foto diganti maka file lama akan dihapus.
