<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Proses Update Profil
if (isset($_POST['update_profile'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $password_baru = $_POST['password_baru'];

    if (!empty($password_baru)) {
        // Jika password diisi, enkripsi password baru
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $query_update = "UPDATE users SET nama_lengkap='$nama_lengkap', password='$password_hash' WHERE id='$user_id'";
    } else {
        // Jika password dikosongkan, update nama saja
        $query_update = "UPDATE users SET nama_lengkap='$nama_lengkap' WHERE id='$user_id'";
    }

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='profile.php';</script>";
    }
}

// Ambil data user saat ini untuk ditampilkan di input field
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Profil - Breaksek Store</title>
</head>
<body class="bg-gray-900 text-white flex">

    <div class="w-64 h-screen bg-gray-800 p-5 space-y-6 fixed">
        <h2 class="text-xl font-bold text-blue-500">Member Area</h2>
        <nav class="space-y-2">
            <a href="index.php" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
            <a href="profile.php" class="block p-2 bg-blue-600 rounded">Edit Profil</a>
            <a href="../index.php" class="block p-2 hover:bg-gray-700 rounded">Kembali ke Toko</a>
            <a href="../logout.php" class="block p-2 text-red-400 hover:bg-gray-700 rounded">Logout</a>
        </nav>
    </div>

    <div class="flex-1 p-10 ml-64">
        <h1 class="text-3xl font-bold mb-6">Pengaturan Profil</h1>

        <div class="max-w-xl bg-gray-800 p-8 rounded-lg shadow-lg">
            <form action="" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Username (Tidak dapat diubah)</label>
                    <input type="text" value="<?= $user_data['username']; ?>" class="w-full p-2 bg-gray-700 rounded border border-gray-600 text-gray-400 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm text-gray-200 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= $user_data['nama_lengkap']; ?>" class="w-full p-2 bg-gray-700 rounded border border-gray-600 focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-200 mb-1">Password Baru</label>
                    <input type="password" name="password_baru" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full p-2 bg-gray-700 rounded border border-gray-600 focus:outline-none focus:border-blue-500">
                </div>
                
                <div class="pt-2">
                    <button type="submit" name="update_profile" class="w-full bg-emerald-600 hover:bg-emerald-700 p-2 rounded font-bold transition">Perbarui Profil</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>