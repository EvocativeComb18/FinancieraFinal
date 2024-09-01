<?php
session_start(); // Iniciar la sesión

$servername = "216.238.107.20";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $password = md5($_POST['password']); // Convertir la contraseña a formato MD5

    $sql = "SELECT * FROM registration WHERE nickname = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user; // Guardar información del usuario en la sesión
        header("Location: https://droopystone36.org.uk/t6/dashboard/index.php");
        exit();
    } else {
        // Redirigir de nuevo al formulario con un mensaje de error
        $error = "Usuario o contraseña incorrectos";
        header("Location: https://droopystone36.org.uk/test3/dashboard/pages-login.html?error=" . urlencode($error));
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
