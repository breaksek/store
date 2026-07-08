<?php
session_start();
if ($_SESSION['role'] !== 'admin') { header("Location: ../login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-900 text-white flex">
    <div class="w-64 h-screen bg-gray-800 p-5 space-y-6">
        <h2 class="text-xl font-bold text-blue-500">Admin Panel</h2>
        <nav class="space-y-2">
            <a href="index.php" class="block p-2 bg-blue-600 rounded">Dashboard</a>
            <a href="produk.php" class="block p-2 hover:bg-gray-700 rounded">Management Produk</a>
            <a href="user.php" class="block p-2 hover:bg-gray-700 rounded">Management User</a>
            <a href="../logout.php" class="block p-2 text-red-400 hover:bg-gray-700 rounded">Logout</a>
        </nav>
    </div>
    <div class="flex-1 p-10">
        <h1 class="text-2xl font-bold">Selamat Datang, Admin <?= $_SESSION['username']; ?></h1>
        </div>
</body>
</html>