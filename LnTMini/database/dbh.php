<?php

$server_name = "localhost";
$username = "root";
$password = "";
$database = "adminpanel";

$conn = mysqli_connect($server_name, $username, $password);
$dbconfig = mysqli_select_db($conn, $database);



?>