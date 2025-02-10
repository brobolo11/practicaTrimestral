<?php
require 'vendor/autoload.php';
use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$clienteMongo = new Client('mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0');
$coleccion = $clienteMongo->trimestral->alumnos;

$id = $_GET['id'] ?? null;

if (!$id || !preg_match('/^[a-f\d]{24}$/i', $id)) {
    http_response_code(400);
    echo json_encode(["error" => "ID no válido"]);
    exit();
}

try {
    $resultado = $coleccion->deleteOne(['_id' => new ObjectId($id)]);
    if ($resultado->getDeletedCount() === 1) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Usuario eliminado con éxito"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al eliminar el usuario: " . $e->getMessage()]);
}
?>
