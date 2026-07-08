<?php
include 'config/database.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];

            if ($row['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login - Breaksek Store</title>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-500">Sign In</h2>
        <?php if(isset($error)): ?>
            <p class="text-red-500 text-sm mb-4 text-center">Username atau password salah!</p>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-sm mb-2">Username</label>
                <input type="text" name="username" class="w-full p-2 bg-gray-700 rounded border border-gray-600 focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm mb-2">Password</label>
                <input type="password" name="password" class="w-full p-2 bg-gray-700 rounded border border-gray-600 focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" name="login" class="w-full bg-blue-600 hover:bg-blue-700 p-2 rounded font-bold transition">Login</button>
        </form>
        <p class="text-sm text-gray-400 mt-4 text-center">Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Daftar</a></p>
    </div>
</body>
</html>