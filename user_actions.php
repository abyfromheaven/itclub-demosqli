<?php
require_once 'db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $field = $_POST['field'] ?? 'password';
    $username = $_POST['username'] ?? '';
    $new_value = $_POST['new_value'] ?? '';

    // INTENTIONALLY VULNERABLE: this isolated page is for the local SQLi lab.
    if ($action === 'update') {
        // Keep the column choice constrained; the WHERE value remains injectable.
        $column = $field === 'username' ? 'username' : 'password';
        $query = "UPDATE users SET $column = '$new_value' WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $message = 'UPDATE dijalankan. Baris terdampak: ' . mysqli_affected_rows($conn);
        } else {
            $error = 'Query UPDATE gagal: ' . mysqli_error($conn);
        }
    } elseif ($action === 'delete') {
        $query = "DELETE FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $message = 'DELETE dijalankan. Baris terhapus: ' . mysqli_affected_rows($conn);
        } else {
            $error = 'Query DELETE gagal: ' . mysqli_error($conn);
        }
    } else {
        $error = 'Pilih aksi yang tersedia.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan UPDATE & DELETE SQLi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-100 min-h-screen p-6 text-slate-800">
    <main class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
        <h1 class="text-2xl font-bold mb-2">Latihan UPDATE &amp; DELETE SQLi</h1>
        <p class="text-sm text-slate-600 mb-6">Halaman lab lokal untuk demonstrasi query rentan pada tabel users.</p>

        <?php if ($message): ?>
            <div class="bg-green-50 text-green-800 border border-green-200 rounded-lg p-3 mb-4"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-800 border border-red-200 rounded-lg p-3 mb-4"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <label class="block text-sm font-semibold">Aksi
                <select name="action" class="mt-1 w-full border rounded-lg p-3">
                    <option value="update">Ubah password</option>
                    <option value="delete">Hapus akun</option>
                </select>
            </label>
            <label class="block text-sm font-semibold">Username / kondisi WHERE
                <input name="username" class="mt-1 w-full border rounded-lg p-3" placeholder="contoh: budi.santoso" required>
            </label>
            <label class="block text-sm font-semibold">Kolom yang diubah (khusus UPDATE)
                <select name="field" class="mt-1 w-full border rounded-lg p-3">
                    <option value="password">Password</option>
                    <option value="username">Username</option>
                </select>
            </label>
            <label class="block text-sm font-semibold">Nilai baru (khusus aksi UPDATE)
                <input name="new_value" class="mt-1 w-full border rounded-lg p-3" placeholder="contoh: password-baru">
            </label>
            <button class="bg-blue-700 text-white rounded-lg px-5 py-3 font-semibold">Jalankan di lab</button>
        </form>

        <div class="mt-6 rounded-lg bg-amber-50 border border-amber-200 p-4 text-sm text-amber-900">
            Gunakan hanya pada database demo yang bisa di-reset. Payload kondisi selalu benar dapat mengubah atau menghapus semua akun.
        </div>
        <a href="index.php" class="inline-block mt-5 text-blue-700 underline">Kembali ke katalog</a>
    </main>
</body>
</html>
