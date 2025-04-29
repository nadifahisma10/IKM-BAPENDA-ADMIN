<?php
    include 'connect.php';

    $id = $_GET['id'];
    $soal = $_POST['soal'];
    $jwbA = $_POST['jwbA'];
    $jwbB = $_POST['jwbB'];
    $jwbC = $_POST['jwbC'];
    $jwbD = $_POST['jwbD'];

    // Masukkan data soal ke tabel soal
    $sqlsoal = mysqli_query($conn, "INSERT INTO soal(soal, id_kategoriS) VALUES ('$soal', '$id')");

    if ($sqlsoal) {
        // Ambil ID soal yang baru dimasukkan
        $idj = mysqli_insert_id($conn);

        // Masukkan jawaban ke tabel jawaban
        $sqljawaban = mysqli_query($conn, "INSERT INTO jawaban(jawaban1, jawaban2, jawaban3, jawaban4, id_soalj) VALUES ('$jwbA', '$jwbB', '$jwbC', '$jwbD', '$idj')");

        if ($sqljawaban) {
            echo "<script>alert('Tambah Soal Berhasil');</script>";
            echo "<script>document.location.href='daftarsoal.php?id=$id';</script>";
        } else {
            echo "<script>alert('Gagal Menambahkan Jawaban');</script>";
            echo "<script>document.location.href='tambahsoal.php?id=$id';</script>";
        }
    } else {
        echo "<script>alert('Gagal Menambahkan Soal');</script>";
        echo "<script>document.location.href='tambahsoal.php?id=$id';</script>";
    }
?>
