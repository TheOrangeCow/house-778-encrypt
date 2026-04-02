<?php

session_start();

header('Access-Control-Allow-Origin: https://house-778.theorangecow.org');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

echo json_encode(['username' => $_SESSION['username']]);
?>
