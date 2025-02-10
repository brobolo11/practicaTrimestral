<?php
session_start(); // Iniciar sesión
require 'vendor/autoload.php';

use MongoDB\Client;

$uri = 'mongodb+srv://bfanvei:Lolitofernandez10@cluster0.3swo1.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0';

try {
    $client = new Client($uri);
    $database = $client->selectDatabase('trimestral');
    $collection = $database->selectCollection('login');

    // Crear usuario inicial si no existe
    $usuarioExistente = $collection->findOne(['nombre' => 'bruno']);
    if (!$usuarioExistente) {
        $collection->insertOne([
            'nombre' => 'bruno',
            'contrasena' => '1234',
            'rol' => 'admin'
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        if ($nombre && $contrasena) {
            $usuario = $collection->findOne([
                'nombre' => $nombre,
                'contrasena' => $contrasena
            ]);

            if ($usuario) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];
                header('Location: inicio.php');
                exit();
            } else {
                header('Location: index.html?error=credenciales');
                exit();
            }
        } else {
            header('Location: index.html?error=campos_vacios');
            exit();
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'Error de conexión con la base de datos';
    header('Location: index.html');
    exit();
}
?>