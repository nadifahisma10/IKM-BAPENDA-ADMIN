<?php 
    include 'connect.php';
    require 'sideindex.php';

    $id_kategorisend = $_GET['idkategorisend'];
?>

<title>Edit Kategori</title>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Kategori</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                                // Ambil data kategori dari database
                                $query2 = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori='$id_kategorisend'");
                                $data2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);

                                // Pastikan data kategori ditemukan
                                if ($data2) {
                                    $namakategori = $data2['nama_kategori'];
                                    $penjelasan = $data2['persyaratan'];
                                    $status = $data2['status'];
                                } else {
                                    echo "<script>alert('Kategori tidak ditemukan!'); window.location.href='pageAdmin.php';</script>";
                                    exit;
                                }
                            ?>

                            <form role="form" method="POST" action="ubahproses.php?idkategorisend=<?php echo $id_kategorisend; ?>">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input class="form-control" name="nama" value="<?php echo $namakategori; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Penjelasan Soal</label>
                                    <textarea class="form-control" rows="3" name="penjelasan" required><?php echo $penjelasan; ?></textarea>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" value="1" <?php echo ($status == 1) ? "checked" : ""; ?>> 
                                        Tampilkan kategori ini di halaman user?
                                    </label>
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
