<?php
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
$sql = "SELECT * FROM loan_information";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Notificaciones</title>
    <link href="<link href="dashboard\assets\vendor\bootstrap\css\bootstrap.min.css" rel="stylesheet"> <!-- Asegúrate de tener Bootstrap incluido -->
    <style>
    /* Fondo general azul */
    body {
        background-color: #007bff; /* Azul */
        color: #000; /* Texto negro */
        font-family: Arial, sans-serif;
    }

    /* Estilos para la tabla */
    table {
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        background-color: #fff; /* Fondo blanco para la tabla */
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd; /* Borde para las divisiones */
        text-align: center;
    }

    /* Encabezado de la tabla */
    th {
        background-color: #004085; /* Azul más oscuro */
        color: #fff; /* Texto blanco */
    }

    /* Título de la página */
    h1 {
        text-align: center;
        color: #fff;
        margin-top: 20px;
    }
    h2 {
        color: #fff; /* Blanco */
        text-align: center; /* Centramos el texto */
        margin-top: 20px; /* Añadimos un margen superior opcional */
    }
</style>


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
                        <td><?php echo htmlspecialchars($row["loan_type"]); ?></td>
                        <td><?php echo htmlspecialchars($row["requested_amount"]); ?></td>
                        <td><?php echo htmlspecialchars($row["first_name"] . " " . $row["last_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["form_fill_date"]); ?></td>
                        <td>
                        <?php if ($notification['loan_status'] === 'No Aceptado'): ?>
    <form method="post" action="accept_loan.php">
        <input type="hidden" name="loan_id" value="<?php echo htmlspecialchars($notification['id']); ?>">
        <button type="submit">Aceptar Préstamo</button>
    </form>
<?php else: ?>
    <p>Préstamo aceptado</p>
<?php endif; ?>

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No se encontraron registros</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="dashboard\assets\vendor\bootstrap\js\bootstrap.bundle.min.js"></script> <!-- Asegúrate de tener Bootstrap incluido -->
</body>
</html>

<?php
$conn->close();
?>
