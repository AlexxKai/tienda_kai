<?php
$servername = "localhost";
$username = "alex";
$password = "1q2w3e";
$dbname = "tienda_kai";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
