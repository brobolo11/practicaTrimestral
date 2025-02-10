<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="inicio.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a class="botonInicio" href="inicio_menu.php">Inicio</a></li>
                <li><a href="alumnos.php">Alumnos</a></li>
                <li><a href="empresas.php">Empresas</a></li>
                <li><a href="bolsaEmpleo.php">Bolsa de Empleo</a></li>
                <li><a href="inicio.php" class="btn-perfil">Perfil</a></li>
            </ul>
        </nav>
    </header>

    <div class="contenidoPrincipal">
        <h1>Bienvenido a tu panel de usuario, <?php echo $_SESSION['username']; ?></h1>
        <p>Desde aquí puedes gestionar a tus alumnos, empresas y promociones.</p>
        <div class="contenedores">
            <div class="contenedor">
                <img src="images/alumnos.webp" alt="Alumnos">
                <h3>Alumnos</h3>
                <p>Gestiona la información y datos de tus alumnos.</p>
                <a href="alumnos.php" class="enlace">Ir a Alumnos</a>
            </div>
            <div class="contenedor">
                <img src="images/empresas.webp" alt="Empresas">
                <h3>Empresas</h3>
                <p>Administra las empresas asociadas con facilidad.</p>
                <a href="empresas.php" class="enlace">Ir a Empresas</a>
            </div>
            <div class="contenedor">
                <img src="images/bolsaEmpleo.webp" alt="bolsaEmpleo">
                <h3>Bolsa de Empleo</h3>
                <p>Configura y visualiza la bolsa de empleo.</p>
                <a href="bolsaEmpleo.php" class="enlace">Ir a Bolsa de empleo</a>
            </div>
        </div>
    </div>
</body>
</html>