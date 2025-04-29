<?php
    include "connect.php";

    if (!isset($_GET['id'])) {
        echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
        exit;
    }

    $id = $_GET['id'];

    // Hapus jawaban terkait dengan soal dalam kategori ini
    $deleteJawaban = mysqli_query($conn, "DELETE FROM jawaban WHERE id_soalj IN (SELECT id_soal FROM soal WHERE id_kategoriS='$id')");

    // Hapus soal yang terkait dengan kategori ini
    $deleteSoal = mysqli_query($conn, "DELETE FROM soal WHERE id_kategoriS='$id'");

    // Hapus kategori
    $deleteKategori = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id'");

    if ($deleteKategori) {
        echo "<script>alert('Berhasil Menghapus Kategori'); window.location.href='pageAdmin.php';</script>";
    } else {
        echo "<script>alert('Gagal Menghapus Kategori'); window.history.back();</script>";
    }
?>
