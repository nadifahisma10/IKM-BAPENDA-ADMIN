<?php
    include 'connect.php';

    // Pastikan ID tersedia
    if (!isset($_GET['id']) || empty($_POST['soal'])) {
        echo "<script>alert('Data tidak lengkap!'); window.history.back();</script>";
        exit;
    }

    $id_soalsend = $_GET['id'];

    // Escape input untuk menghindari SQL Injection
    $soal = mysqli_real_escape_string($conn, $_POST['soal']);
    $jwbA = mysqli_real_escape_string($conn, $_POST['jwbA']);
    $jwbB = mysqli_real_escape_string($conn, $_POST['jwbB']);
    $jwbC = mysqli_real_escape_string($conn, $_POST['jwbC']);
    $jwbD = mysqli_real_escape_string($conn, $_POST['jwbD']);

    // Update tabel soal
    $query1 = "UPDATE soal SET soal = '$soal' WHERE id_soal = '$id_soalsend'";
    $hasil1 = mysqli_query($conn, $query1);

    // Update tabel jawaban
    $query2 = "UPDATE jawaban SET 
               jawaban1 = '$jwbA', 
               jawaban2 = '$jwbB', 
               jawaban3 = '$jwbC', 
               jawaban4 = '$jwbD' 
               WHERE id_soalj = '$id_soalsend'";
    $hasil2 = mysqli_query($conn, $query2);

    // Ambil id_kategori untuk redirect
    $query3 = "SELECT id_kategoriS FROM soal WHERE id_soal='$id_soalsend'";
    $result = mysqli_query($conn, $query3);
    $data = mysqli_fetch_array($result);
    $id_kategorisend = $data['id_kategoriS'] ?? '';

    if ($hasil1 && $hasil2) {
        echo "<script>alert('Edit Soal Berhasil.'); window.location.href='daftarsoal.php?id=$id_kategorisend';</script>";
    } else {
        echo "<script>alert('Edit Soal Gagal!'); window.location.href='editsoal.php?id=$id_soalsend';</script>";
    }

    include 'footer.php';
?>
