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

// Obtener el ID del cliente desde el parámetro URL
$client_id = $_GET['id'];

// Seleccionar detalles específicos del cliente
$sql = "SELECT * FROM loan_information WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "Nombre: " . $row["first_name"] . " " . $row["last_name"] . "<br>";
    echo "RFC: " . $row["rfc"] . "<br>";
    echo "Monto Solicitado: " . $row["requested_amount"] . "<br>";
    echo "Plazo del Préstamo: " . $row["loan_term"] . "<br>";
    echo "Dirección: " . $row["address_line"] . ", " . $row["city"] . ", " . $row["state"] . "<br>";
    echo "Número de Teléfono: " . $row["phone_number"] . "<br>";
} else {
    echo "No se encontraron detalles para el cliente.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Notificación</title>
    <link href="dashboard\assets\vendor\bootstrap\css\bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Detalles de la Notificación</h2>
    <?php if ($notification): ?>
    <ul>
        <li><strong>Tipo:</strong> <?php echo htmlspecialchars($notification['loan_type']); ?></li>
        <li><strong>Cantidad:</strong> <?php echo htmlspecialchars($notification['requested_amount']); ?></li>
        <li><strong>Nombre:</strong> <?php echo htmlspecialchars($notification['first_name'] . ' ' . $notification['last_name']); ?></li>
        <li><strong>Fecha de solicitud:</strong> <?php echo htmlspecialchars($notification['form_fill_date']); ?></li>
        <li><strong>Estado:</strong> <?php echo htmlspecialchars($notification['loan_status']); ?></li>
        
        <?php if ($notification['loan_status'] === 'No Aceptado'): ?>
            <form method="post" action="accept_loan.php">
                <input type="hidden" name="loan_id" value="<?php echo $notification['id']; ?>">
                <button type="submit">Aceptar Préstamo</button>
            </form>
        <?php else: ?>
            <p>Préstamo aceptado</p>
        <?php endif; ?>
    </ul>
<?php else: ?>
    <p>No se encontraron detalles para esta notificación.</p>
<?php endif; ?>


    <a href="notifications.php" class="btn btn-secondary">Volver a todas las notificaciones</a>
</div>

<script src="dashboard\assets\vendor\bootstrap\js\bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
