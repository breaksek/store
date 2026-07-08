<?php
include 'config/database.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek username kembar
    $cek = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        $query = "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('$username', '$password', '$nama_lengkap', 'user')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registrasi Berhasil! Silahkan Login.'); window.location='login.php';</script>";
        }
    }
}
?>