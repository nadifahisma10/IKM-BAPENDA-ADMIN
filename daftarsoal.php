<!DOCTYPE html> 
<?php 
    require 'side.php';
    include 'connect.php';
    $id = $_GET['id'];
?>
<div id="page-wrapper">
    <div class="row">
        <?php
            $query1 = "SELECT * FROM kategori WHERE id_kategori = $id";
            $sql = mysqli_query($conn, $query1);

            if ($sql && mysqli_num_rows($sql) > 0) {
                $data1 = mysqli_fetch_assoc($sql);
                echo "<h1 class='page-header'> Daftar Soal {$data1['nama_kategori']}</h1>";
            } else {
                echo "<h1 class='page-header'>Kategori Tidak Ditemukan</h1>";
            }
        ?>
    </div>

    <a href="tambahsoal.php?id=<?php echo $id; ?>">
        <button type="submit" style='background-color: #008f8f; color: white;' class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Soal
        </button> 
    </a>
    <br><br>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Daftar Soal
                </div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Soal</center></th>
                                <th><center>A</center></th>
                                <th><center>B</center></th>
                                <th><center>C</center></th>
                                <th><center>D</center></th>
                                <th><center>Ket.</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = mysqli_query($conn, 
                                    "SELECT * FROM soal 
                                    JOIN jawaban ON id_soal = id_soalj 
                                    WHERE id_kategoriS = '$id'"
                                );

                                $no = 1;
                                if ($query && mysqli_num_rows($query) > 0) {
                                    while ($data = mysqli_fetch_assoc($query)) { 
                                        echo '
                                        <tr>
                                            <td><center>'.$no++.'.</center></td>
                                            <td>'.$data["soal"].'</td>
                                            <td>'.$data["jawaban1"].'</td>
                                            <td>'.$data["jawaban2"].'</td>
                                            <td>'.$data["jawaban3"].'</td>
                                            <td>'.$data["jawaban4"].'</td>
                                            <td>
                                                <center> 
                                                    <a class="btn" href="editsoal.php?id='.$data['id_soal'].'" 
                                                    style="background-color: #00a6a6; color: white; border: none;">Ubah</a>
                                                    <a class="btn btn-danger" href="hapussoal.php?id='.$data['id_soal'].'">Hapus</a>
                                                </center>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="7"><center>Belum ada soal</center></td></tr>';
                                }
                            ?>          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
