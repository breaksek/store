<?php 
include 'config/database.php'; 
session_start();

// Ambil semua data kategori game dari database
$query_game = mysqli_query($conn, "SELECT * FROM kategori_game ORDER BY nama_game ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Breaksek Store - Topup Game Terpercaya</title>
</head>
<body class="bg-gray-900 text-white font-sans">

    <nav class="bg-gray-800 p-4 shadow-md flex justify-between items-center px-6 md:px-10">
        <h1 class="text-xl font-bold text-blue-500 tracking-wider">Breaksek Store</h1>
        <div>
            <?php if (isset($_SESSION['login'])) : ?>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <a href="admin/index.php" class="bg-purple-600 px-4 py-2 rounded font-semibold hover:bg-purple-700 transition">Admin Panel</a>
                <?php else : ?>
                    <a href="user/index.php" class="bg-blue-600 px-4 py-2 rounded font-semibold hover:bg-blue-700 transition">Dashboard</a>
                <?php endif; ?>
            <?php else : ?>
                <a href="login.php" class="bg-blue-600 px-4 py-2 rounded font-semibold hover:bg-blue-700 transition">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="text-center my-12 px-4">
        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Top Up Game Favoritmu Di Sini</h2>
        <p class="text-gray-400 mt-2 text-sm md:text-base">Proses cepat, aman, dan instan 24 jam otomatis.</p>
    </div>

    <div class="max-w-md mx-auto px-4 mb-10">
        <input type="text" id="searchGame" onkeyup="filterGames()" placeholder="Cari game favoritmu di sini..." class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition shadow-inner">
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 px-4 pb-16">
        
        <?php if (mysqli_num_rows($query_game) > 0) : ?>
            <?php while($game = mysqli_fetch_assoc($query_game)) : ?>
                <div class="game-card bg-gray-800 p-5 rounded-xl text-center cursor-pointer border border-gray-700" onclick="window.location='beli.php?id=<?= $game['id']; ?>'">
                    <?php 
                    $gambar = !empty($game['logo_game']) ? 'assets/images/' . $game['logo_game'] : 'assets/images/default-game.png'; 
                    ?>
                    <img src="<?= $gambar; ?>" alt="<?= $game['nama_game']; ?>" class="w-20 h-20 mx-auto rounded-xl mb-3 object-cover shadow-md">
                    <h3 class="font-bold text-lg tracking-wide text-white"><?= $game['nama_game']; ?></h3>
                    <p class="text-xs text-gray-400 mt-1">Instant Otomatis</p>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="col-span-2 md:col-span-4 text-center text-gray-500 py-10">
                Belum ada data game yang tersedia di database.
            </div>
        <?php endif; ?>

    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>