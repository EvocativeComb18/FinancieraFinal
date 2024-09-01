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

$sql = "SELECT loan_type, requested_amount, first_name, last_name, middle_name, date_of_birth, phone_number, form_fill_date FROM loan_information ORDER BY form_fill_date DESC";
$result = $conn->query($sql);

$notifications = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notifications[] = array(
            "type" => "primary", // o cualquier tipo que desees para esta notificación
            "title" => "Nueva Solicitud",
            "message" => "Tipo: " . $row['loan_type'] . ", Cantidad: " . $row['requested_amount'] . ", Nombre: " . $row['first_name'] . " " . $row['last_name'],
            "time" => $row['form_fill_date']
        );
    }
} else {
    $notifications[] = array(
        "type" => "primary",
        "title" => "Sin Solicitudes",
        "message" => "No hay nuevas solicitudes de crédito",
        "time" => ""
    );
}

$conn->close();

echo json_encode($notifications);
?>