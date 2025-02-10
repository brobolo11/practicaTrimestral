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
    <link rel="stylesheet" href="empresas.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empresas</title>
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
                <li><a class="botonEmpresa" href="empresas.php">Empresas</a></li>
                <li><a href="bolsaEmpleo.php">Bolsa de Empleo</a></li>
                <li><a href="inicio.php">Perfil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if($_SESSION['rol'] === 'admin'): ?>
            <button class="boton" id="mostrarFormulario">Añadir Empresa</button>
        <?php endif; ?>

        <!-- Se oculta el formulario si el usuario no es admin -->
        <form id="formularioEmpresa" enctype="multipart/form-data" <?php if($_SESSION['rol'] !== 'admin') echo 'style="display:none;"'; ?>>
            <p class="botonCerrar">x</p>
            <h2>Nueva Empresa</h2>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre de la empresa" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required>

            <label for="rama">Rama:</label>
            <input type="text" id="rama" name="rama" required>

            <label for="personacontacto">Persona de Contacto:</label>
            <input type="text" id="personacontacto" name="personacontacto" required>

            <button type="button" class="boton" id="agregarEmpresa">Agregar</button>
        </form>

        <div class="tarjetasEmpresas" id="tarjetasEmpresas">
            <!-- Tarjetas de empresas -->
        </div>
    </main>

    <script>
        let rolUsuario = "<?php echo $_SESSION['rol'] ?? ''; ?>";
        console.log("Rol del usuario:", rolUsuario);
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="empresas.js"></script>
</body>
</html>
