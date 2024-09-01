<?php
session_start();
header('Content-Type: application/json');

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

if (isset($_SESSION['user_nickname'])) {
    $nickname = $_SESSION['user_nickname'];
    $sql = "SELECT full_name, id_type, nickname FROM registration WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(null);
    }
    $stmt->close();
} else {
    echo json_encode(null);
}

$conn->close();
?>

