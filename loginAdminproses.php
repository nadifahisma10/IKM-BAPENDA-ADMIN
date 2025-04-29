<?php
session_start();

// Tangkap data dari form login
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validasi username dan password yang benar
$valid_username = "bapenda";
$valid_password = "12345678";

if ($username === $valid_username && $password === $valid_password) {
    // Simpan sesi login
    $_SESSION['username'] = $username;
    
    // Redirect ke halaman dashboard (gantilah dengan halaman yang sesuai)
    header("Location: pageAdmin.php");
    exit();
} else {
    // Redirect kembali ke halaman login dengan pesan error
    $error_message = "Username atau password salah!";
    header("Location: login.php?error=" . urlencode($error_message));
    exit();
}
?>
