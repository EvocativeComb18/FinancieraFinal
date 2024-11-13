<?php
$servername = "195.250.27.28";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
