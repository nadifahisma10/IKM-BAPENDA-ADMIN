<?php
    include "connect.php";

    if (!isset($_GET['id'])) {
        echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
        exit;
    }

    $id = $_GET['id'];

    // Ambil id_kategoriS dari tabel soal
    $query1 = mysqli_query($conn, "SELECT id_kategoriS FROM soal WHERE id_soal='$id'");
    $hasil1 = mysqli_fetch_array($query1, MYSQLI_ASSOC);
    $idk = $hasil1['id_kategoriS'] ?? '';

    // Ambil id_kategori dari tabel kategori
    $query2 = mysqli_query($conn, "SELECT id_kategori FROM kategori WHERE id_kategori='$idk'");
    $hasil2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
    $id_kategori = $hasil2['id_kategori'] ?? '';

    // Hapus jawaban yang terkait terlebih dahulu
    $deleteJawaban = mysqli_query($conn, "DELETE FROM jawaban WHERE id_soalj='$id'");

    // Hapus soal setelah jawaban dihapus
    $deleteSoal = mysqli_query($conn, "DELETE FROM soal WHERE id_soal='$id'");

    if ($deleteSoal) {
        echo "<script>alert('Berhasil Menghapus Soal'); window.location.href='daftarsoal.php?id=$id_kategori';</script>";
    } else {
        echo "<script>alert('Gagal Menghapus Soal'); window.history.back();</script>";
    }

    include 'footer.php';
?>
