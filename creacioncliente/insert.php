<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "216.238.107.20";
$username = "droopyst_test";
$password = "M3nd0z@2020.";
$dbname = "droopyst_test01";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

$sql = "INSERT INTO loan_information (zone, client_number, loan_type, requested_amount, loan_term, rfc, curp, first_name, last_name, middle_name, date_of_birth, marital_status, gender, num_dependents, address_line, neighborhood, city, state, postal_code, id_type, id_number, birth_place, nationality, housing_type, time_at_address_years, time_at_address_months, phone_number, spouse_name, child1_name, child2_name, child3_name, child4_name, form_fill_date) VALUES ('$zone', '$client_number', '$loan_type', '$requested_amount', '$loan_term', '$rfc', '$curp', '$first_name', '$last_name', '$middle_name', '$date_of_birth', '$marital_status', '$gender', '$num_dependents', '$address_line', '$neighborhood', '$city', '$state', '$postal_code', '$id_type', '$id_number', '$birth_place', '$nationality', '$housing_type', '$time_at_address_years', '$time_at_address_months', '$phone_number', '$spouse_name', '$child1_name', '$child2_name', '$child3_name', '$child4_name', '$form_fill_date')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

