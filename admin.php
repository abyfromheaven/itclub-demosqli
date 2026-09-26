<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$role = $_SESSION['role'] ?? 'User';
$email = $_SESSION['email'] ?? '-';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Klien & Admin | PT. Nusantara Teknologi Solusi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased min-h-screen flex flex-col">
    <!-- Top Navbar -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 text-white p-2.5 rounded-xl font-bold text-xl">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <div>
                    <span class="text-xl font-extrabold text-slate-900 block">Nusantara Tech</span>
                    <span class="text-xs text-slate-500 font-medium">Enterprise Portal</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-slate-900"><?= htmlspecialchars($user, ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="text-xs text-blue-600 font-semibold"><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></div>
                </div>
                <a href="logout.php" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-semibold transition inline-flex items-center space-x-2">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Dashboard Body -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-900 to-slate-900 rounded-3xl p-8 text-white shadow-xl mb-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <span class="bg-blue-500/30 text-blue-300 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-blue-400/30">Session Active</span>
                <h1 class="text-3xl font-extrabold mt-3 mb-2">Selamat Datang, <?= htmlspecialchars($user, ENT_QUOTES, 'UTF-8') ?>!</h1>
                <p class="text-slate-300 text-sm max-w-xl">
                    Anda berhasil masuk ke dalam sistem portal PT. Nusantara Teknologi Solusi sebagai <span class="font-bold text-white"><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></span>.
                </p>
            </div>
            <div class="mt-6 md:mt-0 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 text-center min-w-[240px]">
                <div class="text-xs text-slate-300 mb-1">Email Terdaftar</div>
                <div class="font-bold text-sm text-white"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-50 text-blue-600 p-3 rounded-xl text-lg">
                        <i class="fa-solid fa-server"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Operational</span>
                </div>
                <h3 class="text-slate-500 text-sm font-medium">Status Server Cloud</h3>
                <div class="text-2xl font-bold text-slate-900 mt-1">99.98% Uptime</div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-indigo-50 text-indigo-600 p-3 rounded-xl text-lg">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Secure</span>
                </div>
                <h3 class="text-slate-500 text-sm font-medium">Firewall & Security</h3>
                <div class="text-2xl font-bold text-slate-900 mt-1">Active Protection</div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-emerald-50 text-emerald-600 p-3 rounded-xl text-lg">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">Billing</span>
                </div>
                <h3 class="text-slate-500 text-sm font-medium">Status Langganan</h3>
                <div class="text-2xl font-bold text-slate-900 mt-1">Active Enterprise</div>
            </div>
        </div>

        <!-- Quick Info Box -->
        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Pengumuman & Informasi Sistem</h2>
            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                Pemeliharaan server berkala dijadwalkan pada akhir pekan minggu ini pukul 01:00 - 04:00 WIB. Pastikan seluruh pekerjaan backup data telah diselesaikan sebelum waktu tersebut.
            </p>
            <div class="flex items-center space-x-2 text-xs text-slate-500">
                <i class="fa-solid fa-circle-info text-blue-600"></i>
                <span>Jika mengalami kendala teknis, hubungi tim support internal PT. Nusantara Teknologi Solusi.</span>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; 2026 PT. Nusantara Teknologi Solusi. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
