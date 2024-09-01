<?php
session_start();
header('Content-Type: application/json');

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
echo json_encode($user);
?>
