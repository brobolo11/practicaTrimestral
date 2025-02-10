$(document).ready(function(){    
    $.ajax({
        url: "empresasback.php",
        type: "GET",
        dataType: "json",
        success: function(empresas){
            if(empresas && empresas.length > 0){
                for(let empresa of empresas){
                    for(let oferta of empresa.ofertas){
                        let botonPostular = "";
                        if (typeof rolUsuario !== "undefined" && rolUsuario === "admin") { 
                            botonPostular = `<button class="botonPostular" data-rama="${empresa.rama}" data-oferta="${oferta}" data-empresa="${empresa._id.$oid}">Postular</button>`;
                        }
                        $("#tarjetasOfertas").append(`
                            <div class="oferta" data-id="${empresa._id.$oid}">
                                <h3>${empresa.nombre}</h3>
                                <div class="detallesOferta">
                                    <h4>${oferta} - ${empresa.rama}</h4>
                                    ${botonPostular}
                                </div>
                            </div>
                        `);
                    }
                }
            }
        },
        error: function(){
            alert("Hubo un error al cargar los datos");
        }
    });
    
    // Mostrar modal con alumnos filtrados al hacer clic en postular
    $(document).on("click", ".botonPostular", function(){
        let ramaSeleccionada = $(this).data("rama");
        let ofertaSeleccionada = $(this).data("oferta");
        let empresaId = $(this).data("empresa");
        
        $.ajax({
            url: "alumnosback.php",
            type: "GET",
            dataType: "json",
            success: function(alumnos){
                let alumnosFiltrados = alumnos.filter(alumno => alumno.formacion === ramaSeleccionada && !alumno.trabajando);
                let contenidoAlumnos = "";
                
                if (alumnosFiltrados.length > 0) {
                    contenidoAlumnos += '<div class="contenedorAlumnos">';
                    for (let alumno of alumnosFiltrados) {
                        contenidoAlumnos += `
                            <div class="tarjetaAlumno" data-id="${alumno._id.$oid}">
                                <img src="${alumno.foto}" alt="Foto de ${alumno.nombre}">
                                <h3>${alumno.nombre} ${alumno.apellidos}</h3>
                                <p>Rama: ${alumno.formacion}</p>
                                <button class="botonContratar" data-id="${alumno._id.$oid}" data-oferta="${ofertaSeleccionada}" data-empresa="${empresaId}">Contratar Alumno</button>
                            </div>
                        `;
                    }
                    contenidoAlumnos += '</div>';
                } else {
                    contenidoAlumnos = "<p>No hay alumnos disponibles en esta rama.</p>";
                }
                
                $("#listaAlumnos").html(contenidoAlumnos);
                $("#modal").fadeIn();
            },
            error: function(){
                alert("Error al cargar los alumnos");
            }
        });
    });
    
    // Contratar alumno
    $(document).on("click", ".botonContratar", function(){
        let alumnoId = $(this).data("id");
        let oferta = $(this).data("oferta");
        let empresaId = $(this).data("empresa");
        
        $.ajax({
            url: "contratarAlumno.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ alumnoId: alumnoId, oferta: oferta, empresaId: empresaId }),
            success: function(response){
                alert("Alumno contratado exitosamente.");
                $("#modal").fadeOut();
                location.reload();
            },
            error: function(){
                alert("Error al contratar al alumno");
            }
        });
    });
    
    // Cerrar modal al hacer clic en la x
    $("#cerrarModal").click(function(){
        $("#modal").fadeOut();
    });
});
