<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401);
    die(json_encode(["error" => "Acceso no autorizado"]));
}

require 'vendor/autoload.php';

use MongoDB\Client;

$clienteMongo = new Client('mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0');

$coleccionAlumnos = $clienteMongo->trimestral->alumnos;
$coleccionEmpresas = $clienteMongo->trimestral->empresas;

$datos = json_decode(file_get_contents("php://input"), true);
$alumnoId = $datos['alumnoId'] ?? null;
$oferta = $datos['oferta'] ?? null;
$empresaId = $datos['empresaId'] ?? null;

if (!$alumnoId || !$oferta || !$empresaId) {
    http_response_code(400);
    die(json_encode(["error" => "Datos inválidos"]));
}

// Actualizar alumno: cambiar "trabajando" a true y asignar oferta
$coleccionAlumnos->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($alumnoId)],
    ['$set' => ["trabajando" => true, "oferta" => $oferta]]
);

// Eliminar la oferta de la empresa
$coleccionEmpresas->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($empresaId)],
    ['$pull' => ["ofertas" => $oferta]]
);

echo json_encode(["success" => "Alumno contratado y oferta eliminada"]);
?>
