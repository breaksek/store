<?php
session_start();
include '../config/database.php';

// Validasi jika bukan admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// 1. PROSES UBAH ROLE (Toggle Admin/User)
if (isset($_GET['ubah_role'])) {
    $id_user = $_GET['ubah_role'];
    $role_sekarang = $_GET['role'];
    $role_baru = ($role_sekarang == 'admin') ? 'user' : 'admin';

    $query_role = "UPDATE users SET role = '$role_baru' WHERE id = '$id_user'";
    if (mysqli_query($conn, $query_role)) {
        echo "<script>alert('Role berhasil diubah!'); window.location='user.php';</script>";
    }
}

// 2. PROSES HAPUS USER
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    // Cegah admin menghapus dirinya sendiri saat login
    if ($id_hapus == $_SESSION['user_id']) {
        echo "<script>alert('Kamu tidak bisa menghapus akunmu sendiri yang sedang aktif!'); window.location='user.php';</script>";
    } else {
        $query_hapus = "DELETE FROM users WHERE id = '$id_hapus'";
        if (mysqli_query($conn, $query_hapus)) {
            echo "<script>alert('User berhasil dihapus!'); window.location='user.php';</script>";
        }
    }
}

// Ambil semua data user dari database
$user_query = mysqli_query($conn, "SELECT id, username, nama_lengkap, role, created_at FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Management User - Admin Panel</title>
</head>
<body class="bg-gray-900 text-white flex">

    <div class="w-64 h-screen bg-gray-800 p-5 space-y-6 fixed">
        <h2 class="text-xl font-bold text-blue-500">Admin Panel</h2>
        <nav class="space-y-2">
            <a href="index.php" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
            <a href="produk.php" class="block p-2 hover:bg-gray-700 rounded">Management Produk</a>
            <a href="user.php" class="block p-2 bg-blue-600 rounded">Management User</a>
            <a href="../logout.php" class="block p-2 text-red-400 hover:bg-gray-700 rounded">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-10 ml-64">
        <h1 class="text-3xl font-bold mb-6">Management Anggota & Admin</h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-blue-400">Daftar Pengguna Sistem</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                    <thead class="text-xs text-gray-200 uppercase bg-gray-700">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Username</th>
                            <th class="p-3">Nama Lengkap</th>
                            <th class="p-3">Akses (Role)</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while($user = mysqli_fetch_assoc($user_query)) : ?>
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="p-3"><?= $no++; ?></td>
                            <td class="p-3 font-semibold text-white"><?= $user['username']; ?></td>
                            <td class="p-3"><?= $user['nama_lengkap']; ?></td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-bold <?= ($user['role'] == 'admin') ? 'bg-purple-600 text-white' : 'bg-blue-600 text-white'; ?>">
                                    <?= strtoupper($user['role']); ?>
                                </span>
                            </td>
                            <td class="p-3 text-center space-x-2">
                                <a href="user.php?ubah_role=<?= $user['id']; ?>&role=<?= $user['role']; ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-xs font-bold transition">
                                    Toggle Role
                                </a>
                                <a href="user.php?hapus=<?= $user['id']; ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold transition">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>