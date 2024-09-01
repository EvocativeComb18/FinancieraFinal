<?php
$servername = "216.238.107.20";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, full_name, mobile_number, worker_id, nickname FROM registration"; // Asegúrate de que estos nombres de columna sean correctos
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode([]);
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>

