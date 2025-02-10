<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="bolsaEmpleo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa de Empleo</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="inicio_menu.php">Inicio</a></li>
                <li><a href="alumnos.php">Alumnos</a></li>
                <li><a href="empresas.php">Empresas</a></li>
                <li><a class="botonBE" href="bolsaEmpleo.php">Bolsa de Empleo</a></li>
                <li><a href="inicio.php">Perfil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="tarjetasOfertas" id="tarjetasOfertas">
            <!-- Las tarjetas de bolsa de empleo se insertarán aquí-->
        </div>

        <div id="modal" class="modal">
            <div class="modalContenido">
                <span id="cerrarModal" class="cerrarModal">&times;</span>
                <h2>Seleccionar Alumno</h2>
                <div id="listaAlumnos"></div>
            </div>
        </div>

    </main>

    <script>
        let rolUsuario = "<?php echo $_SESSION['rol'] ?? ''; ?>";
        console.log("Rol del usuario:", rolUsuario);
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="bolsaEmpleo.js"></script>
</body>

</html>
