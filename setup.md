# 🛠️ Panduan Setup Mini Lab SQLi (Windows & Linux)

Panduan ini menjelaskan cara menyiapkan mini lab demo SQL Injection pada platform **Windows (XAMPP & Laragon)** dan **Linux** tanpa memerlukan PHP CLI, cukup menggunakan web server lokal yang sudah ada.

---

## 📂 Struktur Folder Proyek
Letakkan seluruh folder `demo-sqli` ke dalam direktori web root server lokal Anda.

---

## 🪟 1. Setup di Windows (XAMPP)

1. **Pindahkan Folder:**
   - Salin folder `demo-sqli` ke: `C:\xampp\htdocs\demo-sqli`
2. **Jalankan Services:**
   - Buka aplikasi **XAMPP Control Panel**.
   - Klik **Start** pada **Apache** dan **MySQL**.
3. **Buat & Import Database:**
   - Buka browser dan akses: `http://localhost/phpmyadmin/`
   - Klik menu **New** di sidebar kiri, beri nama database: `demo_sqli`
   - Pilih database `demo_sqli`, klik tab **Import**, lalu pilih file `schema.sql` dari folder proyek, dan klik **Go**.
4. **Konfigurasi Database (`db.php`):**
   - Secara default, XAMPP menggunakan username `root` tanpa password. Jika sesuai, biarkan `db.php` seperti semula:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = '';
     $dbname = 'demo_sqli';
     ```
5. **Akses Website:**
   - Buka browser dan ketik: `http://localhost/demo-sqli/`

---

## 🍃 2. Setup di Windows (Laragon)

1. **Pindahkan Folder:**
   - Salin folder `demo-sqli` ke root folder Laragon Anda (biasanya di `C:\laragon\www\demo-sqli`).
2. **Jalankan Services:**
   - Buka aplikasi **Laragon**, klik **Start All**.
3. **Buat & Import Database:**
   - Buka phpMyAdmin (atau gunakan Navicat/HeidiSQL bawaan Laragon).
   - Buat database baru bernama `demo_sqli`.
   - Import file `schema.sql` ke dalam database `demo_sqli`.
4. **Konfigurasi Database (`db.php`):**
   - Laragon default menggunakan username `root` dan password kosong (`''`). Pastikan `db.php` sudah sesuai.
5. **Akses Website:**
   - Laragon otomatis membuat virtual host. Cukup buka browser dan ketik: `http://demo-sqli.test` (atau akses via `http://localhost/demo-sqli/`).

---

## 🐧 3. Setup di Linux (Ubuntu / Debian / Mint)

1. **Pindahkan Folder:**
   - Pindahkan folder `demo-sqli` ke direktori web server Apache:
     ```bash
     sudo cp -r demo-sqli /var/www/html/
     ```
2. **Pastikan Apache & MySQL/MariaDB Aktif:**
   ```bash
   sudo systemctl start apache2
   sudo systemctl start mysql
   ```
3. **Buat & Import Database via Terminal:**
   - Masuk ke MySQL:
     ```bash
     sudo mysql
     ```
   - Buat database dan import schema:
     ```sql
     CREATE DATABASE demo_sqli;
     USE demo_sqli;
     SOURCE /var/www/html/demo-sqli/schema.sql;
     EXIT;
     ```
   *(Atau Anda bisa menggunakan phpMyAdmin jika terinstall di Linux).*
4. **Konfigurasi Database (`db.php`):**
   - Jika Anda mengatur password pada root MySQL Linux Anda, sesuaikan file `/var/www/html/demo-sqli/db.php`:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = 'password_mysql_anda';
     $dbname = 'demo_sqli';
     ```
5. **Akses Website:**
   - Buka browser dan akses: `http://localhost/demo-sqli/`

---

## ⚙️ Penyesuaian `db.php` (Ringkas)
Jika Anda perlu mengganti konfigurasi kredensial database (username/password), cukup edit file `db.php` di baris berikut:
```php
$host = 'localhost';
$user = 'root';     // Ganti jika username MySQL berbeda
$pass = '';         // Ganti jika MySQL menggunakan password
$dbname = 'demo_sqli';
```
Selesai! Website siap digunakan untuk demo SQL Injection di kelas RPL.
