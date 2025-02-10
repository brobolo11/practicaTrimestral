$(document).ready(function () {
    let alumnosCargados = [];

    // Cargar alumnos desde el servidor
    $.ajax({
        url: "alumnosback.php",
        type: "GET",
        dataType: "json",
        success: function (alumnos) {
            alumnosCargados = alumnos; // Guardar los alumnos en memoria
            mostrarAlumnos(alumnosCargados);
        },
        error: function () {
            alert("Hubo un error al cargar los datos");
        }
    });

    // Función para mostrar alumnos en la lista
    function mostrarAlumnos(alumnos) {
        $("#tarjetasUsuarios").empty();
        if (alumnos.length > 0) {
            for (let alumno of alumnos) {
                let adminButtons = "";
                if (rolUsuario === "admin") {
                    adminButtons = `
                        <button class="boton eliminar" data-id="${alumno._id.$oid || alumno._id}">Eliminar</button>
                        <button class="boton modificar" data-id="${alumno._id.$oid || alumno._id}" data-info='${JSON.stringify(alumno)}'>Modificar</button>
                    `;
                }
                $("#tarjetasUsuarios").append(`
                    <div class="tarjeta" data-info='${JSON.stringify(alumno)}'>
                        <div class="fotoUsuario">
                            <img src="${alumno.foto}" alt="Foto de ${alumno.nombre}">
                        </div>
                        <h3>${alumno.nombre}</h3>
                        <p>${alumno.apellidos}</p>
                        <p>${alumno.formacion}</p>
                        <p><strong>Promoción:</strong> ${alumno.promocion}</p>
                        ${adminButtons}
                    </div>
                `);
            }
        } else {
            $("#tarjetasUsuarios").html("<p>No hay alumnos para esta promoción.</p>");
        }
    }

    // Evento de filtrar por promocion
    $("#filtrarPromocion").on("click", function () {
        let filtro = $("#filtroPromocion").val().trim();
        if (filtro === "") {
            mostrarAlumnos(alumnosCargados);
        } else {
            let alumnosFiltrados = alumnosCargados.filter(alumno => alumno.promocion === filtro);
            mostrarAlumnos(alumnosFiltrados);
        }
    });

    // Mostrar formulario de nuevo usuario
    $("#mostrarFormulario").on("click", function () {
        $("#formularioUsuario").fadeIn();
    });

    // Cerrar formulario
    $(".botonCerrar").on("click", function () {
        $("#formularioUsuario").fadeOut();
    });

    // Agregar usuario nuevo 
    $("#agregarUsuario").on("click", function () {
        const nuevoUsuario = {
            foto: $("#foto").val(),
            nombre: $("#nombre").val(),
            apellidos: $("#apellidos").val(),
            dni: $("#dni").val(),
            direccion: $("#direccion").val(),
            tlf: $("#telefono").val(),
            email: $("#email").val(),
            formacion: $("#formacion").val(),
            promocion: "2024/2025",
            cv: $("#cv").val(),
            trabajando: false,
            oferta: "",
        };

        $.ajax({
            url: "agregarUsuario.php",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify(nuevoUsuario),
            success: function (response) {
                alert("Usuario agregado correctamente");
                location.reload();
            },
            error: function (xhr) {
                alert("Error al agregar el usuario: " + (xhr.responseJSON?.error || "Error desconocido"));
            }
        });
    });

    // Eliminar usuario
    $(document).on("click", ".eliminar", function () {
        let id = $(this).attr("data-id");
        if (!id || id === "[object Object]") {
            alert("Error: ID no válido");
            return;
        }
        if (confirm("¿Seguro que deseas eliminar este usuario?")) {
            $.ajax({
                url: `eliminarUsuario.php?id=${encodeURIComponent(id)}`,
                type: "POST",
                success: function () {
                    alert("Usuario eliminado con éxito");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error al eliminar: " + (xhr.responseJSON?.error || "Error desconocido"));
                },
            });
        }
    });

    // Modificar usuario
    $(document).on("click", ".modificar", function () {
        const data = $(this).data("info");
        let id = $(this).attr("data-id");
        if (!id || id === "[object Object]") {
            alert("Error: ID no válido");
            return;
        }
        $("#foto").val(data.foto);
        $("#nombre").val(data.nombre);
        $("#apellidos").val(data.apellidos);
        $("#dni").val(data.dni);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#formacion").val(data.formacion);
        $("#cv").val(data.cv);
        $("#formularioUsuario").fadeIn();
        $("#agregarUsuario").off("click").text("Actualizar Usuario").on("click", function () {
            const objetoActualizado = {
                foto: $("#foto").val(),
                nombre: $("#nombre").val(),
                apellidos: $("#apellidos").val(),
                dni: $("#dni").val(),
                direccion: $("#direccion").val(),
                telefono: $("#telefono").val(),
                email: $("#email").val(),
                formacion: $("#formacion").val(),
                cv: $("#cv").val(),
            };
            $.ajax({
                url: `modificarUsuario.php?id=${encodeURIComponent(id)}`,
                type: "POST",
                dataType: "json",
                contentType: "application/json",
                data: JSON.stringify(objetoActualizado),
                success: function () {
                    alert("Usuario modificado con éxito");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error al modificar: " + (xhr.responseJSON?.error || "Error desconocido"));
                },
            });
        });
    });
});
