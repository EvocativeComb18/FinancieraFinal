<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "216.238.107.20";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}
/*
// Obtener datos de la tabla de solicitudes de crédito
$sql = "SELECT full_name, phone, credit_amount, credit_status FROM credit_applications";
$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
*/
// Obtener el conteo de clientes
$sql_count = "SELECT COUNT(*) as total_clients FROM loan_information ";
$result_count = $conn->query($sql_count);

$total_clients = 0;
if ($result_count->num_rows > 0) {
    $total_clients = $result_count->fetch_assoc()['total_clients'];
}

$conn->close();

echo json_encode(["data" => $data, "total_clients" => $total_clients]);
?>
