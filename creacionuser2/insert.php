<?php
// Mostrar errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Obtener los datos del formulario
$full_name = $_POST['full_name'];
$date_of_birth = $_POST['date_of_birth'];
$email = $_POST['email'];
$mobile_number = $_POST['mobile_number'];
$gender = $_POST['gender'];
$id_type = $_POST['id_type'];
$issued_authority = $_POST['issued_authority'];
$issued_state = $_POST['issued_state'];
$issued_date = $_POST['issued_date'];
$expiry_date = $_POST['expiry_date'];
$address_type = $_POST['address_type'];
$nationality = $_POST['nationality'];
$state = $_POST['state'];
$district = $_POST['district'];
$father_name = $_POST['father_name'];
$password = md5($_POST['password']); // Encriptar contraseña con MD5
$mother_name = $_POST['mother_name'];

// Verificar que id_type 1 no exista más de una vez
$check_admin_query = "SELECT COUNT(*) as admin_count FROM registration WHERE id_type = 1";
$result = $conn->query($check_admin_query);
$row = $result->fetch_assoc();

if ($row['admin_count'] >= 1 && $id_type == 1) {
    die("Error: Solo puede existir un usuario con id_type 1.");
}

// Insertar datos en la tabla
$sql = "INSERT INTO registration (full_name, date_of_birth, email, mobile_number, gender, id_type, issued_authority, issued_state, issued_date, expiry_date, address_type, nationality, state, district, father_name, mother_name, password) VALUES ('$full_name', '$date_of_birth', '$email', '$mobile_number', '$gender', '$id_type', '$issued_authority', '$issued_state', '$issued_date', '$expiry_date', '$address_type', '$nationality', '$state', '$district', '$father_name', '$mother_name', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Datos insertados correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

