<?php
    include 'connect.php';

    // Pastikan ID ada
    if (!isset($_GET['idkategorisend']) || empty($_GET['idkategorisend'])) {
        echo "<script>alert('ID kategori tidak valid!'); window.location.href='PageAdmin.php';</script>";
        exit;
    }

    $id_kategorisend = mysqli_real_escape_string($conn, $_GET['idkategorisend']);
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama']);
    $persyaratan = mysqli_real_escape_string($conn, $_POST['penjelasan']);
    $status = isset($_POST['status']) ? 1 : 0;

    // Query update
    $query = "UPDATE kategori SET 
                nama_kategori = '$nama_kategori', 
                persyaratan = '$persyaratan', 
                status = $status 
              WHERE id_kategori = '$id_kategorisend'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Edit Kategori Berhasil.'); window.location.href='PageAdmin.php';</script>";
    } else {
        echo "<script>alert('Edit Kategori Gagal!'); window.location.href='editkategori.php?idkategorisend=$id_kategorisend';</script>";
    }
?>
