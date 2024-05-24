<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah sesi sudah dimulai sebelumnya
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
