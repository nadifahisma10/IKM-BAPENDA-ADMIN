<!DOCTYPE html>
<html lang="en">
<?php 
    include 'connect.php'; // Pastikan koneksi hanya dimuat sekali

    // Mengambil id_kategori dari parameter URL
    $id = $_GET['id'];
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="./vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>

</head>

<body>

    <div id="wrapper" >

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" style='background-color: #008f8f;'>
            <?php
                // Mengambil nama kategori dari database
                $query1 = "SELECT nama_kategori FROM kategori WHERE id_kategori = $id";
                $sql = mysqli_query($conn, $query1);

                // Periksa apakah data kategori ditemukan
                if ($sql && mysqli_num_rows($sql) > 0) {
                    $data1 = mysqli_fetch_assoc($sql);
                    echo "<a class='navbar-brand' style='background-color: #008f8f; color: white;'> {$data1['nama_kategori']}</a>";
                } else {
                    echo "<a class='navbar-brand' >Kategori Tidak Ditemukan</a>";
                }
            ?>      
        
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="pageAdmin.php"><i class="fa fa-dashboard fa-fw" style='color: #008f8f;'></i> Kategori</a>
                        </li>
                        <li>
                            <a href='laporan.php?id=<?php echo $id;?>'><i class="fa fa-bar-chart-o fa-fw" style='color: #008f8f;'></i> Laporan</a>
                        </li>
                        <li>
                            <a href='daftarsoal.php?id=<?php echo $id;?>'><i class="fa fa-table fa-fw" style='color: #008f8f;'></i> Daftar Soal</a>
                        </li>
                        <li>
                            <a href="logoutProses.php"><i class="fa fa-edit fa-fw" style='color: #008f8f;'></i> Keluar</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="./vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="./vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="./dist/js/sb-admin-2.js"></script>

</body>

</html>
