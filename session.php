<?php 
session_start();
header("Content-Type: application/json");
$_SESSION['initialize'] = rand();
$_SESSION['initialize2'] = rand();
// echo $json = json_encode($_SESSION);
echo json_encode($_SERVER);