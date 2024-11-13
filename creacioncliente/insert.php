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

// Obtener datos del formulario
$zone = $_POST['zone'];
$client_number = $_POST['client_number'];
$loan_type = $_POST['loan_type'];
$requested_amount = $_POST['requested_amount'];
$loan_term = $_POST['loan_term'];
$rfc = $_POST['rfc'];
$curp = $_POST['curp'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$middle_name = $_POST['middle_name'];
$date_of_birth = $_POST['date_of_birth'];
$marital_status = $_POST['marital_status'];
$gender = $_POST['gender'];
$num_dependents = $_POST['num_dependents'];
$address_line = $_POST['address_line'];
$neighborhood = $_POST['neighborhood'];
$city = $_POST['city'];
$state = $_POST['state'];
$postal_code = $_POST['postal_code'];
$id_type = $_POST['id_type'];
$id_number = $_POST['id_number'];
$birth_place = $_POST['birth_place'];
$nationality = $_POST['nationality'];
$housing_type = $_POST['housing_type'];
$time_at_address_years = $_POST['time_at_address_years'];
$time_at_address_months = $_POST['time_at_address_months'];
$phone_number = $_POST['phone_number'];
$spouse_name = $_POST['spouse_name'];
$child1_name = $_POST['child1_name'];
$child2_name = $_POST['child2_name'];
$child3_name = $_POST['child3_name'];
$child4_name = $_POST['child4_name'];
$form_fill_date = $_POST['form_fill_date'];

// Obtener la firma en formato base64
$signature = $_POST['signature'];
if ($signature) {
    $signatureData = str_replace('data:image/webp;base64,', '', $signature);
    $signatureData = base64_decode($signatureData);

    // Crear un nombre de archivo único y la ruta donde se guardará
    $signatureFolder = 'contratos/signatures';
    if (!file_exists($signatureFolder)) {
        mkdir($signatureFolder, 0777, true); // Crear carpeta si no existe
    }
    $signatureFile = $signatureFolder . '/signature_' . time() . '.webp';

    // Guardar la firma como archivo
    file_put_contents($signatureFile, $signatureData);
} else {
    $signatureFile = null; // Si no hay firma
}

// Insertar datos en la base de datos
$sql = "INSERT INTO loan_information (zone, client_number, loan_type, requested_amount, loan_term, rfc, curp, first_name, last_name, middle_name, date_of_birth, marital_status, gender, num_dependents, address_line, neighborhood, city, state, postal_code, id_type, id_number, birth_place, nationality, housing_type, time_at_address_years, time_at_address_months, phone_number, spouse_name, child1_name, child2_name, child3_name, child4_name, form_fill_date, signature) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssssssssssssssssssssss", $zone, $client_number, $loan_type, $requested_amount, $loan_term, $rfc, $curp, $first_name, $last_name, $middle_name, $date_of_birth, $marital_status, $gender, $num_dependents, $address_line, $neighborhood, $city, $state, $postal_code, $id_type, $id_number, $birth_place, $nationality, $housing_type, $time_at_address_years, $time_at_address_months, $phone_number, $spouse_name, $child1_name, $child2_name, $child3_name, $child4_name, $form_fill_date, $signatureFile);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>



