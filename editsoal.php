<!DOCTYPE html> 
<?php 
    include 'connect.php';
    require 'sideindex.php'; 

    $id = $_GET['id'];

    // Mengambil data soal berdasarkan ID
    $query1 = mysqli_query($conn, "SELECT * FROM soal WHERE id_soal='$id'");
    $data1 = mysqli_fetch_array($query1);

    if (!$data1) {
        die("Soal tidak ditemukan!");
    }

    $idkategoriS = $data1['id_kategoriS'];
?>
<title>Edit Soal</title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Soal</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php 
                        // Mengambil nama kategori
                        $query2 = mysqli_query($conn, "SELECT nama_kategori FROM kategori WHERE id_kategori='$idkategoriS'");
                        $data2 = mysqli_fetch_array($query2);
                        echo "Edit Soal Bagian Kategori: " . ($data2 ? $data2['nama_kategori'] : "Tidak Diketahui");
                    ?>
                </div>

                <?php 
                    // Mengambil data soal dan jawaban
                    $query3 = mysqli_query($conn, "SELECT soal, jawaban1, jawaban2, jawaban3, jawaban4 FROM soal 
                                                   LEFT JOIN jawaban ON soal.id_soal = jawaban.id_soalj 
                                                   WHERE soal.id_soal='$id'");
                    $data3 = mysqli_fetch_array($query3);

                    // Cek apakah soal ditemukan
                    if ($data3) {
                        $soal = $data3['soal'];
                        $jawA = $data3['jawaban1'] ?? "";
                        $jawB = $data3['jawaban2'] ?? "";
                        $jawC = $data3['jawaban3'] ?? "";
                        $jawD = $data3['jawaban4'] ?? "";
                    } else {
                        die("Data soal tidak ditemukan!");
                    }
                ?>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method="POST" action="editsoalproses.php?id=<?php echo $id; ?>">
                                <div class="form-group">
                                    <label>Soal</label>
                                    <input class="form-control" name="soal" value="<?php echo htmlspecialchars($soal); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Jawaban A</label>
                                    <input class="form-control" name="jwbA" value="<?php echo htmlspecialchars($jawA); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jawaban B</label>
                                    <input class="form-control" name="jwbB" value="<?php echo htmlspecialchars($jawB); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jawaban C</label>
                                    <input class="form-control" name="jwbC" value="<?php echo htmlspecialchars($jawC); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jawaban D</label>
                                    <input class="form-control" name="jwbD" value="<?php echo htmlspecialchars($jawD); ?>">
                                </div>
                                
                                <button type="submit" style='background-color: #008f8f; color: white;' class="btn btn-primary">Ubah</button>                                  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
