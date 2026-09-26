<?php
require_once 'db.php';

$search = $_GET['search'] ?? '';
$products = [];
$error = '';

if ($search !== '') {
    // VULNERABLE SQL QUERY (Intentional SQLi for educational demo)
    $query = "SELECT id, name, description, price FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    } else {
        $error = "Terjadi kesalahan pada kueri database.";
    }
} else {
    $query = "SELECT id, name, description, price FROM products";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Nusantara Teknologi Solusi | Enterprise Solutions & Cloud Services</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 text-white p-2.5 rounded-xl font-bold text-xl tracking-wider">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 block">Nusantara Tech</span>
                    <span class="text-xs text-slate-500 font-medium tracking-wide">Enterprise Solutions</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-600">
                <a href="index.php" class="text-blue-600 font-semibold">Katalog Produk</a>
                <a href="#solusi" class="hover:text-blue-600 transition">Solusi</a>
                <a href="#tentang" class="hover:text-blue-600 transition">Tentang Kami</a>
                <a href="#kontak" class="hover:text-blue-600 transition">Kontak</a>
            </nav>
            <div>
                <a href="login.php" class="inline-flex items-center space-x-2 bg-slate-900 hover:bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition shadow-sm">
                    <i class="fa-solid fa-user-lock"></i>
                    <span>Portal Klien / Admin</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 text-white py-20 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <span class="bg-blue-500/20 text-blue-400 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-widest border border-blue-500/30">Inovasi Digital Terdepan</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight mt-6 mb-4 leading-tight">
                Transformasi Digital untuk Perusahaan Modern
            </h1>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-10">
                Menyediakan infrastruktur cloud enterprise, sistem ERP terintegrasi, dan keamanan siber berlapis untuk mendukung pertumbuhan bisnis Anda.
            </p>

            <!-- Search Form (Vulnerable to SQLi) -->
            <form action="index.php" method="GET" class="max-w-2xl mx-auto flex items-center bg-white p-2 rounded-2xl shadow-xl">
                <div class="pl-4 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" 
                    placeholder="Cari produk, layanan, atau kategori..." 
                    class="w-full px-4 py-3 text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none text-sm"
                >
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-7 py-3 rounded-xl font-semibold text-sm transition shrink-0">
                    Cari Solusi
                </button>
            </form>
        </div>
    </section>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Katalog Layanan & Produk</h2>
                <p class="text-sm text-slate-500 mt-1">Daftar solusi teknologi yang siap diimplementasikan untuk korporasi.</p>
            </div>
            <?php if ($search !== ''): ?>
                <a href="index.php" class="text-sm text-blue-600 hover:underline font-medium">Reset Pencarian</a>
            <?php endif; ?>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-sm">
                <div class="text-slate-300 text-5xl mb-4">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-800">Tidak ada produk ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($products as $p): ?>
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    ID: <?= htmlspecialchars($p['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                </span>
                                <span class="text-blue-600 font-bold text-lg">
                                    <?php if (is_numeric($p['price'] ?? 0)): ?>
                                        Rp <?= number_format($p['price'], 0, ',', '.') ?>
                                    <?php else: ?>
                                        <?= htmlspecialchars($p['price'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">
                                <?= htmlspecialchars($p['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                <?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-medium"><i class="fa-solid fa-shield-check text-green-600 mr-1"></i> Verified Solution</span>
                            <button onclick="alert('Fitur konsultasi memerlukan login klien.')" class="text-blue-600 hover:text-blue-700 text-sm font-semibold inline-flex items-center space-x-1">
                                <span>Detail</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; 2026 PT. Nusantara Teknologi Solusi. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
