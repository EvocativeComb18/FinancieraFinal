<?php
session_start();
$nickname = $_SESSION['user']['nickname'];

$servername = "216.238.107.20";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date_today = date('Y-m-d');

$sql = "SELECT * FROM loan_information WHERE collector_nickname = ? AND due_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nickname, $date_today);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Clientes para Cobrar Hoy</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="center">
        <h1>Clientes para Cobrar Hoy</h1>
        <div class="button_container">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="client_info">
                    <p><strong>Cliente:</strong> <?php echo $row['first_name'] . " " . $row['last_name']; ?></p>
                    <p><strong>Monto Restante:</strong> <?php echo $row['remaining_amount']; ?></p>
                    <p><strong>Pago del Día:</strong> <?php echo $row['payment_amount']; ?></p>
                    <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($row['address_line'] . ', ' . $row['city'] . ', ' . $row['state']); ?>" target="_blank" class="role_button">Ver en Google Maps</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
