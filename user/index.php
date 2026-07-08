<?php
session_start();
include '../config/database.php';

// Validasi jika belum login atau bukan role user
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Mengambil data lengkap user yang sedang login
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Member - Breaksek Store</title>
</head>
<body class="bg-gray-900 text-white flex">

    <div class="w-64 h-screen bg-gray-800 p-5 space-y-6 fixed">
        <h2 class="text-xl font-bold text-blue-500">Member Area</h2>
        <nav class="space-y-2">
            <a href="index.php" class="block p-2 bg-blue-600 rounded">Dashboard</a>
            <a href="profile.php" class="block p-2 hover:bg-gray-700 rounded">Edit Profil</a>
            <a href="../index.php" class="block p-2 hover:bg-gray-700 rounded">Kembali ke Toko</a>
            <a href="../logout.php" class="block p-2 text-red-400 hover:bg-gray-700 rounded">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-10 ml-64">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <h1 class="text-2xl font-bold">Halo, <span class="text-blue-400"><?= $user_data['nama_lengkap']; ?></span>! 👋</h1>
            <p class="text-gray-400 mt-1">Selamat datang di panel Breaksek Store. Kamu terdaftar sebagai member resmi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold uppercase">Total Transaksi</h3>
                <p class="text-3xl font-bold mt-2 text-white">0 <span class="text-sm font-normal text-gray-500">Order</span></p>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <h3 class="text-gray-400 text-sm font-semibold uppercase">Status Akun</h3>
                <p class="text-3xl font-bold mt-2 text-emerald-400">Aktif</p>
            </div>
        </div>
    </div>

</body>
</html>