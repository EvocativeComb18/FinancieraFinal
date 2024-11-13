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

// Consulta para obtener todas las notificaciones
// Seleccionar todos los registros en loan_information
$sql = "SELECT * FROM loan_information";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output de datos de cada fila
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Cliente: " . $row["first_name"] . " " . $row["last_name"] . " - Monto Solicitado: " . $row["requested_amount"] . "<br>";
    }
} else {
    echo "No se encontraron registros";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Notificaciones</title>
    <link href="path_to_css/bootstrap.min.css" rel="stylesheet"> <!-- Asegúrate de tener Bootstrap incluido -->
</head>
<body>

<div class="container mt-5">
    <h2>Todas las Notificaciones</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Más Información</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Ver más</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay notificaciones</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/bootstrap.bundle.min.js"></script> <!-- Asegúrate de tener Bootstrap incluido -->
</body>
</html>

<?php
$conn->close();
?>
