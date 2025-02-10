<?php
require 'vendor/autoload.php';
use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$clienteMongo = new Client('mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0');
$coleccion = $clienteMongo->trimestral->empresas;

$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (!$id || !preg_match('/^[a-f\d]{24}$/i', $id) || !$data) {
    http_response_code(400);
    echo json_encode(["error" => "Datos o ID no proporcionados correctamente"]);
    exit();
}

try {
    $resultado = $coleccion->updateOne(
        ['_id' => new ObjectId($id)],
        ['$set' => $data]
    );

    if ($resultado->getModifiedCount() === 1) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Empresa modificada con éxito"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Empresa no encontrada o datos sin cambios"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al modificar la empresa: " . $e->getMessage()]);
}
?>