<!DOCTYPE html>
<?php
    include 'connect.php';
    require 'sideindex.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Kategori</h1>
        </div>
    </div>

    <div class="row">
        <?php
        // Query kategori
        $query = mysqli_query($conn, "SELECT * FROM kategori");

        // Menampilkan kategori jika ada
        while ($data = mysqli_fetch_array($query)) {
            echo "
            <div class='col-lg-3 col-md-6'>
                <a href='laporan.php?id=" . $data['id_kategori'] . "'>
                    <div class='panel panel-primary' style='background-color: #008f8f; color: white;'>
                        <div class='panel-heading' style='background-color: #008f8f; color: white;'>
                            <div class='row'>
                                <div class='col-xs-3'>
                                    <i class='fa fa-tasks fa-4x'></i>
                                </div>
                                <div class='col-xs-9 text-center'>
                                    <div>" . htmlspecialchars($data['nama_kategori']) . "</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>";
        }
        ?>

        <!-- Tambah Kategori -->
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" style='border-color: #008f8f;'>
                <a href="tambahkategori.php">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-plus fa-4x" style='color: #008f8f;'></i>
                            </div>
                            <div class="col-xs-9 text-center">
                                <span style="font-size: 24px;">Tambah Kategori</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Status Kategori</div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Kategori</center></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM kategori");
                            $no = 1;
                            while ($data = mysqli_fetch_array($query)) {
                                echo '
                                <tr>
                                    <td><center>' . $no++ . '.</center></td>
                                    <td>' . htmlspecialchars($data["nama_kategori"]) . '</td>
                                    <td class="text-center">
                                        <a class="btn" href="editkategori.php?idkategorisend=' . $data['id_kategori'] . '" 
                                        style="background-color: #00a6a6; color: white; border: none;">Ubah</a>
                                        <a class="btn btn-danger" href="hapuskategori.php?id=' . $data['id_kategori'] . '" 
                                        onclick="return confirm(\'Apakah Anda yakin ingin menghapus kategori ini?\')">Hapus</a>
                                    </td>
                                </tr>';
                            }
                            ?>          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
