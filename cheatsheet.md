# Cheatsheet Demo SQL Injection (SQLi)

> Khusus mini lab lokal (`localhost`). Gunakan database disposable `demo_sqli`; jangan jalankan payload pada sistem atau data sungguhan. Import ulang `schema.sql` untuk mengembalikan data awal.

## Persiapan

1. Jalankan Apache/PHP dan MySQL/MariaDB, lalu import `schema.sql` ke database `demo_sqli`.
2. Pastikan kredensial di `db.php` sesuai konfigurasi lokal.
3. Dari folder proyek, jalankan `php -S localhost:8000`.
4. Buka `http://localhost:8000`.
5. Sebelum demo `UPDATE` atau `DELETE`, import ulang schema bila database pernah diubah. Schema menjatuhkan dan membuat ulang tabel lab.

## 1. Bypass login

- Halaman: `http://localhost:8000/login.php`
- Query rentan: `SELECT * FROM users WHERE username = '$username' AND password = '$password'`
- Masukkan pada **Username** dan kosongkan Password:

```text
admin' OR '1'='1
```

Klik **Masuk Sistem**. Kutip menutup nilai username, lalu kondisi `'1'='1` selalu benar. `AND` dievaluasi lebih dulu daripada `OR`, sehingga password kosong tidak mencegah bagian OR yang benar.

## 2. Menampilkan username

- Halaman: pencarian katalog di `http://localhost:8000`.
- Query rentan memilih empat kolom: `id, name, description, price`.
- Cari dengan payload:

```text
' UNION SELECT 1, username, password, 4 FROM users -- -
```

Username tampil pada nama produk dan password pada deskripsi. Untuk demo username saja, gunakan:

```text
' UNION SELECT 1, username, 'akun lab', 4 FROM users -- -
```

`UNION` menambahkan hasil query tabel `users` ke hasil pencarian produk. Angka `1` dan `4` mengisi kolom lain agar jumlah kolom tetap empat.

## 3. Menampilkan username dan nama database

Pada kotak pencarian yang sama, masukkan:

```text
' UNION SELECT 1, username, database(), 4 FROM users -- -
```

Nama akun muncul pada nama produk dan nama database aktif (`demo_sqli`) muncul pada deskripsi. Fungsi `database()` mengembalikan database yang sedang dipakai koneksi.

## 4. Mengubah password akun

- Buka `http://localhost:8000/user_actions.php` dan pilih **Ubah password**.
- Isi **Username / kondisi WHERE** dengan:

```text
budi.santoso' OR '1'='1' -- -
```

- Isi **Password baru** dengan nilai sederhana, misalnya `password-demo`, lalu klik **Jalankan di lab**.
- Halaman menunjukkan jumlah baris yang terdampak. Karena kondisi OR selalu benar, password seluruh akun berubah. Import ulang `schema.sql` setelah demo.

Query halaman lab berbentuk `UPDATE users SET password = '$new_value' WHERE username = '$username'`. Payload mengubah kondisi `WHERE` dari pencocokan satu username menjadi kondisi yang selalu benar.

Untuk demo mengubah **username**, pilih **Username** pada kolom yang diubah, isi kondisi WHERE dengan payload yang sama, lalu isi nilai baru dengan `akun-demo`. Semua username akan menjadi sama sehingga akun tidak lagi unik; reset schema setelahnya.

## 5. Menghapus akun

- Pastikan schema sudah di-reset sebelum demo ini.
- Di `user_actions.php`, pilih **Hapus akun**.
- Isi **Username / kondisi WHERE** dengan:

```text
budi.santoso' OR '1'='1' -- -
```

- Klik **Jalankan di lab**. Kondisi `WHERE` cocok ke seluruh akun, sehingga semua baris pada tabel `users` terhapus.
- Untuk memulihkan akun, import ulang `schema.sql`.

Query rentannya berbentuk `DELETE FROM users WHERE username = '$username'`. Perubahan input mengubah filter sehingga operasi yang semestinya mengenai satu akun bisa mengenai seluruh tabel.

## Inti pembelajaran

Input pengguna tidak boleh digabung langsung ke string SQL. Aplikasi sungguhan harus memakai prepared statements dan membatasi izin database. `user_actions.php` sengaja rentan dan hanya untuk database latihan lokal yang mudah di-reset.
