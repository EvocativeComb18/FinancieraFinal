<?php
// Datos de conexión a la base de datos
define('DB_SERVER', '195.250.27.28');
define('DB_USERNAME', 'droopyst_test');
define('DB_PASSWORD', 'M3nd0z@2020.');
define('DB_NAME', 'droopyst_test01');
define('DB_PORT', 3306); // Puerto opcional, en este caso, el 3306

// Crear conexión
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
