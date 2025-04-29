<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengamankan input pengguna untuk mencegah SQL Injection
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['penjelasan']);

    // Cek apakah kategori sudah ada
    $check_query = "SELECT id_kategori FROM kategori WHERE nama_kategori = '$nama_kategori'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Kategori sudah terdaftar!'); window.location.href='tambahkategori.php';</script>";
        exit();
    }

    // Insert data ke database
    $insert_query = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES ('$nama_kategori', '$deskripsi')";
    if (mysqli_query($conn, $insert_query)) {
        // Ambil ID kategori yang baru ditambahkan
        $idk = mysqli_insert_id($conn);
        echo "<script>alert('Tambah Kategori Berhasil'); window.location.href='tambahsoalbaru.php?id=$idk';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan kategori!'); window.location.href='tambahkategori.php';</script>";
    }
}
?>
