<?php
$server = "localhost";
$username = "db_user";
$password = "db_pw";
$database = "db_name";
$admin_password = "123456";

$connection = mysqli_connect($server, $username, $password, $database);
$connection->set_charset("utf8");
if(!$connection) {
	die("Bağlantı hatası: " . mysqli_connect_error());
}
?>