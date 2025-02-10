<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$clienteMongo = new Client('mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0');

$coleccion = $clienteMongo -> trimestral -> alumnos;

$objeto = json_decode(file_get_contents("php://input"), true);

if (!isset($objeto['foto'], $objeto['nombre'], $objeto['apellidos'], $objeto['dni'], $objeto['direccion'], $objeto['tlf'], $objeto['email'], $objeto['formacion'], $objeto['promocion'], $objeto['cv'], $objeto['trabajando'], $objeto['oferta'])) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$resultado = $coleccion->insertOne([
    'foto' => $objeto['foto'],
    'nombre' => $objeto['nombre'],
    'apellidos' => $objeto['apellidos'],
    'dni' => $objeto['dni'],
    'direccion' => $objeto['direccion'],
    'tlf' => $objeto['tlf'],
    'email' => $objeto['email'],
    'formacion' => $objeto['formacion'],
    'promocion' => $objeto['promocion'],
    'cv' => $objeto['cv'],
    'trabajando' => $objeto['trabajando'],
    'oferta' => $objeto['oferta']
]);

http_response_code(200);
echo json_encode(["success" => true, "message" => "Usuario agregado correctamente"]);

?>