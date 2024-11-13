<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$servername = "195.250.27.28";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nombre_cliente = $_POST['nombre_cliente'];
$monto = $_POST['monto'];
$fecha = $_POST['fecha'];
$firma_cliente = $_POST['firma_cliente'];
$firma_aval = isset($_POST['firma_aval']) ? $_POST['firma_aval'] : null;

// Decodificar la firma del cliente
$firma_cliente = str_replace('data:image/webp;base64,', '', $firma_cliente);
$firma_cliente = base64_decode($firma_cliente);

// Decodificar la firma del aval (si existe)
if ($firma_aval) {
    $firma_aval = str_replace('data:image/webp;base64,', '', $firma_aval);
    $firma_aval = base64_decode($firma_aval);
}

// Insertar los datos en la base de datos
$sql = "INSERT INTO pagares (nombre_cliente, monto, fecha, tipo_pagare, firma_cliente, firma_aval) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$tipo_pagare = $firma_aval ? 'con_aval' : 'normal';
$stmt->bind_param("sdssss", $nombre_cliente, $monto, $fecha, $tipo_pagare, $firma_cliente, $firma_aval);

if ($stmt->execute()) {
    echo "Pagaré guardado exitosamente.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
