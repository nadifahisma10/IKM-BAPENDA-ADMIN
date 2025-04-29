<?php
    include 'connect.php';
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <!-- Bootstrap Core CSS -->
    <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="./vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <center>
                <div class="login-panel panel panel-default">
                    <img src="img/Pringsewu.png" height="180" width="140">
                    <div class="panel-body">
                        <form role="form" method='POST' action='loginAdminproses.php'>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" minlength="6" required>
                                </div>
                                <button type="submit" value="Login" style='background-color: #008f8f; color: white;' class="btn biru">Login</button>
                            </fieldset>
                        </form>
                        <!-- Menampilkan pesan error jika ada -->
                        <?php
                        if (isset($_GET['error'])) {
                            echo "<p style='color: red; text-align: center; margin-top: 10px;'>" . htmlspecialchars($_GET['error']) . "</p>";
                        }
                        ?>
                    </div>
                </div>
            </center>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="./vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="./vendor/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="./dist/js/sb-admin-2.js"></script>
</body>
