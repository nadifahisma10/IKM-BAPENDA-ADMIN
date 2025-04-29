<?php
	$servername = "localhost"; 
	$username = "root";
	$password = "";
	$dbname = "web_ikm";
	$port = 3308;

	$conn = new mysqli($servername, $username, $password, $dbname, $port);
	if ($conn->connect_error) {
		die("". $conn->connect_error);
	}
?>