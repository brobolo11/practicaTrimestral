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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="alumnos.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="inicio_menu.php">Inicio</a></li>
                <li><a class="botonAlumno" href="./alumnos.php">Alumnos</a></li>
                <li><a href="empresas.php">Empresas</a></li>
                <li><a href="bolsaEmpleo.php">Bolsa de Empleo</a></li>
                <li><a href="inicio.php">Perfil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Si la persona que inicia sesion tiene el rol de admin pues enseña el boton -->
        <?php if($_SESSION['rol'] === 'admin'): ?>
            <button class="boton" id="mostrarFormulario">Añadir Usuario</button>
        <?php endif; ?>

        <!-- Se oculta el formulario si el usuario no es admin -->
        <form id="formularioUsuario" enctype="multipart/form-data" <?php if($_SESSION['rol'] !== 'admin') echo 'style="display:none;"'; ?>>
            <p class="botonCerrar">x</p>
            <h2>Nuevo Usuario</h2>
            <label for="foto">Foto:</label>
            <input type="text" id="foto" name="foto" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del usuario" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos del usuario" required>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" placeholder="DNI (con letra)" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required>

            <label for="formacion">Formación:</label>
            <select name="formacion" id="formacion">
                <option value="TCAE">TCAE</option>
                <option value="Gestión">Gestión</option>
                <option value="Informática">Informática</option>
            </select>

            <label for="cv">CV (PDF):</label>
            <input type="text" id="cv" name="cv" required>

            <button type="button" class="boton" id="agregarUsuario">Agregar</button>
        </form>

        <div class="filtroPromocion">
            <input type="text" id="filtroPromocion" placeholder="Ej: 2024/2025">
            <button class="boton" id="filtrarPromocion">Filtrar</button>
        </div>


        <section class="tarjetasUsuarios" id="tarjetasUsuarios">
            <!-- Las tarjetas de usuario se insertarán aquí -->
        </section>
    </main>

    <div id="modalUsuario" class="modal">
        <div class="modalContenido">
            <span class="cerrarModal">&times;</span>
            <img id="modalFoto" src="" alt="Foto del usuario">
            <h3 id="modalNombre"></h3>
            <p><strong>Apellidos:</strong> <span id="modalApellidos"></span></p>
            <p><strong>DNI:</strong> <span id="modalDNI"></span></p>
            <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
            <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Formación:</strong> <span id="modalFormacion"></span></p>
            <p><strong>CV:</strong> <a id="modalCV" href="#" target="_blank">Descargar CV</a></p>
        </div>
    </div>

    <script>
        let rolUsuario = "<?php echo $_SESSION['rol'] ?? ''; ?>";
        console.log("Rol del usuario:", rolUsuario);
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="alumnos.js"></script>
    
</body>
</html>
