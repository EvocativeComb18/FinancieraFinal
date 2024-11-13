<?php
require_once 'db_connection.php'; // Asegúrate de conectar correctamente a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loan_id'])) {
    $loan_id = intval($_POST['loan_id']);

    // Actualiza el estado a "Aceptado"
    $stmt = $pdo->prepare("UPDATE loan_information SET loan_status = 'Aceptado' WHERE id = ?");
    $stmt->execute([$loan_id]);

    // Aquí puedes agregar código para enviar la notificación a la aplicación Android

    // Redirige de vuelta a la página de notificaciones
    header("Location: notifications.php");
    exit();
}
?>
