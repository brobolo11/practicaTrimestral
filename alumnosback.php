<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401);
    die('Acceso no autorizado');
}

require 'vendor/autoload.php';

use MongoDB\Client;

$clienteMongo = new Client('mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0');

$coleccion = $clienteMongo -> trimestral -> alumnos;

$data = $coleccion -> find();

$datosAlumnos = iterator_to_array($data);

header("Content-Type: application/json");

echo json_encode($datosAlumnos);

?>