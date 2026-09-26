<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // VULNERABLE SQL QUERY (The Classic Login Bypass)
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        header('Location: admin.php');
        exit;
    } else {
        $error = "Username atau password salah. Silakan coba kembali.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal Klien & Administrator | PT. Nusantara Teknologi Solusi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden p-8">
        <div class="text-center mb-8">
            <a href="index.php" class="inline-block bg-blue-600 text-white p-3 rounded-2xl font-bold text-2xl shadow-lg mb-4">
                <i class="fa-solid fa-cube"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Portal Klien & Admin</h1>
            <p class="text-sm text-slate-500 mt-1">PT. Nusantara Teknologi Solusi</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center space-x-2">
                <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username / Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input 
                        type="text" 
                        name="username" 
                        required 
                        placeholder="Masukkan username..." 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:bg-white transition"
                    >
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Masukkan password..." 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:bg-white transition"
                    >
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition shadow-md text-sm">
                Masuk Sistem
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-100 pt-6">
            <a href="index.php" class="text-sm text-slate-600 hover:text-blue-600 font-medium inline-flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</body>
</html>
