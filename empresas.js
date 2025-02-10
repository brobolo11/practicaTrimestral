$(document).ready(function(){
    $.ajax({
        url: "empresasback.php",
        type: "GET",
        dataType: "json",
        success: function(empresas){
            if(empresas && empresas.length > 0){
                for(let empresa of empresas){
                    // Sólo se añaden los botones de eliminar y modificar si el usuario es admin
                    let adminButtons = "";
                    if(rolUsuario === "admin"){
                        adminButtons = `
                            <button class="boton eliminar">Eliminar</button>
                            <button class="boton modificar">Modificar</button>
                        `;
                    }
                    $("#tarjetasEmpresas").append(`
                        <div class="tarjeta" data-id="${empresa._id.$oid}">
                            <h3 class="nombre">${empresa.nombre}</h3>
                            <p class="email">${empresa.email}</p>
                            <p class="telefono">${empresa.tlf}</p>
                            <p class="personacontacto">${empresa.personacontacto}</p>
                            <p class="rama">${empresa.rama}</p>
                            <p class="ofertas">${empresa.ofertas.join(', ')}</p>
                            ${adminButtons}
                        </div>
                    `);
                }
            }

            // Sólo se activan los eventos de formulario y de botones si el usuario es admin
            if(rolUsuario === "admin"){
                // Mostrar formulario para agregar empresa
                $("#mostrarFormulario").on("click", function(){
                    $("#formularioEmpresa").fadeIn();
                    $("#formularioEmpresa").removeAttr("data-id"); // Asegura que no tenga ID
                    $("#formularioEmpresa input").val(""); // Limpiar formulario
                });

                // Cerrar formulario
                $(".botonCerrar").on("click", function(){
                    $("#formularioEmpresa").fadeOut();
                });

                // Agregar o modificar empresa
                $("#agregarEmpresa").on("click", function(){
                    let id = $("#formularioEmpresa").attr("data-id");
                    let objeto = {
                        nombre: $("#nombre").val(),
                        tlf: $("#telefono").val(),
                        email: $("#email").val(),
                        personacontacto: $("#personacontacto").val(),
                        rama: $("#rama").val()
                    };

                    if (id) {
                        // Si hay un ID, modificar empresa
                        $.ajax({
                            url: `modificarEmpresa.php?id=${id}`,
                            type: "POST",
                            contentType: "application/json",
                            dataType: "json",
                            data: JSON.stringify(objeto),
                            success: function(){
                                alert("Empresa modificada correctamente");
                                location.reload();
                            },
                            error: function (xhr) {
                                alert("Error al modificar la empresa: " + (xhr.responseJSON?.error || "Error desconocido"));
                            }
                        });
                    } else {
                        // Si no hay ID, agregar nueva empresa
                        $.ajax({
                            url: "agregarEmpresa.php",
                            type: "POST",
                            contentType: "application/json",
                            dataType: "json",
                            data: JSON.stringify(objeto),
                            success: function(){
                                alert("Empresa agregada correctamente");
                                location.reload();
                            },
                            error: function (xhr) {
                                alert("Error al agregar la empresa: " + (xhr.responseJSON?.error || "Error desconocido"));
                            }
                        });
                    }
                });

                // Eliminar empresa
                $(document).on("click", ".eliminar", function(){
                    let id = $(this).closest(".tarjeta").attr("data-id");
                    if(confirm("¿Seguro que quieres eliminar esta empresa?")) {
                        $.ajax({
                            url: `eliminarEmpresa.php?id=${id}`,
                            type: "GET",
                            success: function(){
                                alert("Empresa eliminada correctamente");
                                location.reload();
                            },
                            error: function(xhr) {
                                alert("Error al eliminar la empresa: " + (xhr.responseJSON?.error || "Error desconocido"));
                            }
                        });
                    }
                });

                // Modificar empresa
                $(document).on("click", ".modificar", function cargarDatosEmpresa(){
                    let tarjeta = $(this).closest(".tarjeta");
                    let id = tarjeta.attr("data-id");
                    $("#nombre").val(tarjeta.find(".nombre").text());
                    $("#telefono").val(tarjeta.find(".telefono").text());
                    $("#email").val(tarjeta.find(".email").text());
                    $("#personacontacto").val(tarjeta.find(".personacontacto").text());
                    $("#rama").val(tarjeta.find(".rama").text());
                    
                    // Guardar el ID en un atributo del formulario
                    $("#formularioEmpresa").attr("data-id", id);
                    $("#formularioEmpresa").fadeIn();
                });
            }
        },
        error: function(){
            alert("Hubo un error al cargar los datos");
        }
    });
});
