<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$clienteMongo = new Client('mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0');

$coleccion = $clienteMongo -> trimestral -> empresas;

$objeto = json_decode(file_get_contents("php://input"), true);

if (!isset($objeto['nombre'], $objeto['tlf'], $objeto['email'], $objeto['personacontacto'], $objeto['rama'])) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$resultado = $coleccion->insertOne([
    'nombre' => $objeto['nombre'],
    'tlf' => $objeto['tlf'],
    'email' => $objeto['email'],
    'rama' => $objeto['rama'],
    'personacontacto' => $objeto['personacontacto']
]);

http_response_code(200);
echo json_encode(["success" => true, "message" => "Empresa agregada correctamente"]);

?>