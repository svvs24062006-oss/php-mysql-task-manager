<?php
$host = "YOUR_MYSQL_HOST_NAME";
$user = "YOUR_MYSQL_USER_NAME";
$pass = "YOUR_MYSQL_PASSWORD";
$dbname = "YOUR_MYSQL_DB_NAME";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
