<?php
$servername = "216.238.107.20";
$username = "droopyst_fegmc1";
$password = "M3nd0z@2020.";
$dbname = "droopyst_fegmc";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, full_name, mobile_number, date_of_birth FROM registration"; 
$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>
