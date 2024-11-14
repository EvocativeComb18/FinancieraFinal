<?php
// Configuración de la conexión
$servername = "195.250.27.28";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se ha enviado el 'loan_id'
if (isset($_POST['loan_id'])) {
    $loan_id = $_POST['loan_id'];

    // Actualizar el estado del préstamo a "Aceptado"
    $sql = "UPDATE loan_information SET loan_status = 'Aceptado' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $loan_id);

    if ($stmt->execute()) {
        echo "Préstamo aceptado con éxito.";
    } else {
        echo "Error al actualizar el estado: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID del préstamo no proporcionado.";
}

// Cerrar conexión
$conn->close();

// Redirigir de vuelta a la página de notificaciones
header("Location: notifications.php");
exit;
?>
