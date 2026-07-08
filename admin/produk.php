<?php
session_start();
include '../config/database.php';

// Validasi jika bukan admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// 1. PROSES TAMBAH PRODUK
if (isset($_POST['tambah_produk'])) {
    $id_game = $_POST['id_game'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];

    $query_tambah = "INSERT INTO produk (id_game, nama_produk, harga) VALUES ('$id_game', '$nama_produk', '$harga')";
    if (mysqli_query($conn, $query_tambah)) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location='produk.php';</script>";
    }
}

// 2. PROSES HAPUS PRODUK
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $query_hapus = "DELETE FROM produk WHERE id = '$id_hapus'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location='produk.php';</script>";
    }
}

// Ambil data kategori game untuk dropdown form
$kategori_query = mysqli_query($conn, "SELECT * FROM kategori_game");

// Ambil data produk digabung (JOIN) dengan nama game-nya
$produk_query = mysqli_query($conn, "SELECT produk.*, kategori_game.nama_game FROM produk JOIN kategori_game ON produk.id_game = kategori_game.id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Management Produk - Admin Panel</title>
</head>
<body class="bg-gray-900 text-white flex">

    <div class="w-64 h-screen bg-gray-800 p-5 space-y-6 fixed">
        <h2 class="text-xl font-bold text-blue-500">Admin Panel</h2>
        <nav class="space-y-2">
            <a href="index.php" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
            <a href="produk.php" class="block p-2 bg-blue-600 rounded">Management Produk</a>
            <a href="user.php" class="block p-2 hover:bg-gray-700 rounded">Management User</a>
            <a href="../logout.php" class="block p-2 text-red-400 hover:bg-gray-700 rounded">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-10 ml-64">
        <h1 class="text-3xl font-bold mb-6">Management Produk Diamond</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg h-fit">
                <h2 class="text-xl font-bold mb-4 text-blue-400">Tambah Produk Baru</h2>
                <form action="" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm mb-1">Pilih Game</label>
                        <select name="id_game" class="w-full p-2 bg-gray-700 rounded border border-gray-600 text-white focus:outline-none focus:border-blue-500" required>
                            <option value="">-- Pilih Game --</option>
                            <?php while($game = mysqli_fetch_assoc($kategori_query)) : ?>
                                <option value="<?= $game['id']; ?>"><?= $game['nama_game']; ?></option>
                            <?php endwith; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Nama Produk / Item</label>
                        <input type="text" name="nama_produk" placeholder="Contoh: 140 Diamonds" class="w-full p-2 bg-gray-700 rounded border border-gray-600 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" placeholder="Contoh: 40000" class="w-full p-2 bg-gray-700 rounded border border-gray-600 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <button type="submit" name="tambah_produk" class="w-full bg-blue-600 hover:bg-blue-700 p-2 rounded font-bold transition">Simpan Produk</button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-blue-400">Daftar Produk Aktif</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-400">
                        <thead class="text-xs text-gray-200 uppercase bg-gray-700">
                            <tr>
                                <th class="p-3">No</th>
                                <th class="p-3">Game</th>
                                <th class="p-3">Nama Produk</th>
                                <th class="p-3">Harga</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($produk_query)) : ?>
                            <tr class="border-b border-gray-700 hover:bg-gray-750">
                                <td class="p-3"><?= $no++; ?></td>
                                <td class="p-3 font-semibold text-white"><?= $row['nama_game']; ?></td>
                                <td class="p-3"><?= $row['nama_produk']; ?></td>
                                <td class="p-3 text-emerald-400">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td class="p-3 text-center">
                                    <a href="produk.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold transition">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>
</html>