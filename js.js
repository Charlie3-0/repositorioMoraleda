/* Funciones para poner y quitar la reserva con AJAX */
let reservaOn = document.querySelector('.quitarReserva');
    if(reservaOn!= null){
        reservaOn.addEventListener('click', quitarReserva);
    }

let reservaOff = document.querySelector('.ponerReserva');
    if(reservaOff!= null){
        reservaOff.addEventListener('click', ponerReserva);
    }
        
function ponerReserva() {
    let idVideojuego = this.getAttribute('data-idVideojuego');
    fetch('index.php?accion=poner_reserva&id=' + idVideojuego)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.respuesta === 'ok') {
                console.log('Reserva puesta con éxito');
                actualizarEstadoReserva('reservado');
                let botonReserva = document.getElementById('botonReserva');
                botonReserva.removeEventListener('click', ponerReserva);
                botonReserva.addEventListener('click', quitarReserva);
                botonReserva.innerHTML = "Quitar Reserva";

                Swal.fire({
                    title: '¡Reserva realizada con éxito!',
                    icon: 'success',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });

            } else {
                console.error('Error al poner reserva');

                Swal.fire({
                    title: 'Error al poner la reserva',
                    icon: 'error',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        });
}

function quitarReserva() {
    let idVideojuego = this.getAttribute('data-idVideojuego');
    fetch('index.php?accion=quitar_reserva&id=' + idVideojuego)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.respuesta === 'ok') {
                console.log('Reserva quitada con éxito');
                actualizarEstadoReserva('no_reservado');
                let botonReserva = document.getElementById('botonReserva');
                botonReserva.removeEventListener('click', quitarReserva);
                botonReserva.addEventListener('click', ponerReserva);
                botonReserva.innerHTML = "Poner Reserva";

                Swal.fire({
                    title: 'Reserva eliminada con éxito',
                    icon: 'success',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });

            } else {
                console.error('Error al quitar reserva');

                Swal.fire({
                    title: 'Error al quitar la reserva',
                    icon: 'error',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        });
}

// Función para actualizar el estado de reserva del videojuego
function actualizarEstadoReserva(estado) {
    const estadoReservaContenedor = document.getElementById('estadoReservaContenedor');
    if (estado === 'reservado') {
        estadoReservaContenedor.innerHTML = '<strong class="estadoReservado">Videojuego Reservado</strong>';
    } else {
        estadoReservaContenedor.innerHTML = '';
    }
}





/* Funciones para marcar y quitar videojuego_probado con AJAX asignando icono */
let probadoOn = document.querySelector('.quitarProbado');
if (probadoOn != null) {
    probadoOn.addEventListener('click', quitarProbado);
}

let probadoOff = document.querySelector('.ponerProbado');
if (probadoOff != null) {
    probadoOff.addEventListener('click', ponerProbado);
}

function ponerProbado() {
    let idVideojuego = this.getAttribute('data-idVideojuego');
    fetch('index.php?accion=poner_videojuego_probado&id=' + idVideojuego)
        .then(response => response.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                console.log('Probado puesto con éxito');
                actualizarEstadoProbado('probado');

                let botonProbado = document.getElementById('botonProbado');
                let textoProbado = document.querySelector('.texto-probado');

                botonProbado.classList.add('icono-animado');
                setTimeout(() => botonProbado.classList.remove('icono-animado'), 300);

                botonProbado.classList.remove('ponerProbado', 'icono-no-probado', 'fa-circle-xmark');
                botonProbado.classList.add('quitarProbado', 'icono-probado', 'fa-gamepad');
                botonProbado.setAttribute('title', 'Quitar probado');
                botonProbado.removeEventListener('click', ponerProbado);
                botonProbado.addEventListener('click', quitarProbado);

                if (textoProbado) {
                    textoProbado.classList.remove('oculto');
                }

                Swal.fire({
                    title: '¡Videojuego probado!',
                    icon: 'success',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });

            } else {
                console.error('Error al marcar videojuego como probado');
            }
        })
        .catch(error => console.error('Error en la solicitud:', error));
}

function quitarProbado() {
    let idVideojuego = this.getAttribute('data-idVideojuego');
    fetch('index.php?accion=quitar_videojuego_probado&id=' + idVideojuego)
        .then(response => response.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                console.log('Probado quitado con éxito');
                actualizarEstadoProbado('no_probado');

                let botonProbado = document.getElementById('botonProbado');
                let textoProbado = document.querySelector('.texto-probado');

                botonProbado.classList.add('icono-animado');
                setTimeout(() => botonProbado.classList.remove('icono-animado'), 300);

                botonProbado.classList.remove('quitarProbado', 'icono-probado', 'fa-gamepad');
                botonProbado.classList.add('ponerProbado', 'icono-no-probado', 'fa-circle-xmark');
                botonProbado.setAttribute('title', 'Marcar como probado');
                botonProbado.removeEventListener('click', quitarProbado);
                botonProbado.addEventListener('click', ponerProbado);

                if (textoProbado) {
                    textoProbado.classList.add('oculto');
                }

                Swal.fire({
                    title: 'Videojuego no probado',
                    icon: 'info',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });

            } else {
                console.error('Error al quitar estado de probado');
            }
        })
        .catch(error => console.error('Error en la solicitud:', error));
}

// Función para actualizar el estado de probado de videojuego_probado
function actualizarEstadoProbado(estado) {
    const estadoProbadoContenedor = document.getElementById('estadoProbadoContenedor');
    if (estado === 'probado') {
        estadoProbadoContenedor.innerHTML = '<strong class="estadoProbado text-success">Videojuego Probado</strong>';
    } else {
        estadoProbadoContenedor.innerHTML = '';
    }
}

    

    
// Script para las puntuaciones
document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
    star.addEventListener('click', function() {
        this.style.transform = 'scale(1.2)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 200);
    });
});


document.querySelectorAll('.star-rating input[type="radio"]').forEach(input => {
    input.addEventListener('change', function () {
        const puntuacion = this.value;
        const idVideojuego = this.getAttribute('data-idVideojuego');

        fetch(`index.php?accion=guardar_puntuacion&id=${idVideojuego}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `puntuacion=${puntuacion}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                console.log('Puntuación guardada con éxito');
                actualizarEstadoPuntuacion(puntuacion);

                // Mostrar mensaje de éxito con SweetAlert
                Swal.fire({
                    title: '¡Puntuación guardada!',
                    icon: 'success',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });

                if (data.nuevaMedia) {
                    const mediaElemento = document.getElementById('mediaPuntuacion');
                    if (mediaElemento) {
                        mediaElemento.innerHTML = `<strong>Media: ${data.nuevaMedia}/10</strong>`;
                    }

                    const votosElemento = document.getElementById('numeroVotos');
                    if (votosElemento && data.votos !== undefined) {
                        votosElemento.innerHTML = `<i class="bi bi-people-fill"></i> ${data.votos} voto${data.votos != 1 ? 's' : ''}`;
                    }

                    actualizarMediaVisual(data.nuevaMedia); // Aquí se actualizan las estrellas visuales
                }
            } else {
                console.error('Error al guardar puntuación:', data.respuesta);

                // Mostrar mensaje de error con SweetAlert
                Swal.fire({
                    title: 'Error al guardar la puntuación',
                    icon: 'error',
                    toast: true,
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        })
        .catch(err => console.error('Error en la solicitud:', err));
    });
});

function actualizarEstadoPuntuacion(puntuacion) {
    const contenedor = document.getElementById('estadoPuntuacionContenedor');
    if (contenedor) {
        contenedor.innerHTML = `<strong class="estadoPuntuacion text-warning">Tu puntuación: ${puntuacion}/10</strong>`;
    }
}


// Mostrar puntuación al hacer hover sobre estrellas
const estrellas = document.querySelectorAll('.star-rating input[type="radio"]');
const tooltip = document.createElement('div');
tooltip.style.position = 'absolute';
tooltip.style.padding = '4px 8px';
tooltip.style.backgroundColor = '#000';
tooltip.style.color = '#fff';
tooltip.style.borderRadius = '4px';
tooltip.style.fontSize = '0.8rem';
tooltip.style.display = 'none';
tooltip.style.zIndex = 1000;
document.body.appendChild(tooltip);

estrellas.forEach(estrella => {
    const label = estrella.nextElementSibling;

    label.addEventListener('mouseenter', (e) => {
        tooltip.innerText = estrella.value + '/10';
        tooltip.style.display = 'block';
    });

    label.addEventListener('mousemove', (e) => {
        tooltip.style.top = (e.pageY - 40) + 'px';
        tooltip.style.left = (e.pageX + 10) + 'px';
    });

    label.addEventListener('mouseleave', () => {
        tooltip.style.display = 'none';
    });
});


// Mostrar media visual del videojuego
function actualizarMediaVisual(media) {
    const contenedorEstrellas = document.getElementById('mediaVisualEstrellas');
    if (!contenedorEstrellas) return;

    contenedorEstrellas.innerHTML = '';

    for (let i = 10; i >= 1; i--) {
        let clase = 'bi-star text-secondary';
        if (media >= i) {
            clase = 'bi-star-fill text-secondary';
        } else if (media >= i - 0.5) {
            clase = 'bi-star-half text-secondary';
        }
        const estrella = document.createElement('i');
        estrella.className = `bi ${clase}`;
        estrella.style.marginRight = '6px'; // Espacio entre estrellas
        contenedorEstrellas.appendChild(estrella);
    }
}



// Script para los comentarios
document.addEventListener("DOMContentLoaded", function () {
    const formComentario = document.getElementById('formComentario');
    const contenedorForm = document.getElementById('insertarComentario');
    const sinComentarios = document.querySelector('.sin-comentarios');
    /* const commentSection = document.querySelector('.comment-section'); */
    const commentSection = document.getElementById('listaComentarios');
    const idVideojuego = document.querySelector('[data-idVideojuego]').getAttribute('data-idVideojuego');

    // Añadir comentario
    if (formComentario) {
        formComentario.addEventListener('submit', function (e) {
            e.preventDefault();
            const comentarioInput = document.getElementById('comentarioTexto');
            const comentario = comentarioInput.value.trim();

            if (!comentario) {
                mostrarMensajeComentario('El comentario no puede estar vacío', 'warning');
                return;
            }

            fetch(`index.php?accion=guardar_comentario&id=${idVideojuego}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `comentario=${encodeURIComponent(comentario)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.respuesta === 'ok') {
                    mostrarMensajeComentario('Comentario guardado correctamente', 'success');

                    // Limpiar el textarea del comentario
                    comentarioInput.value = '';

                    // Si hay comentarios, eliminar el mensaje de "sin comentarios"
                    if (sinComentarios) {
                        sinComentarios.remove();
                    }

                    // Determinar el icono según el rol
                    let iconoRol = '';
                    if (data.rol === 'A') {
                        iconoRol = '<i class="fa-solid fa-shield-halved text-warning"></i>'; // Admin
                    } else {
                        iconoRol = '<i class="fa-solid fa-user text-primary"></i>'; // Usuario normal
                    }

                    // Crear comentario dinámicamente
                    const nuevoComentario = document.createElement('div');
                    nuevoComentario.classList.add('comment-box', 'mb-3');
                    nuevoComentario.setAttribute('data-idComentario', data.idComentario); // para referencia general
                    
            /*      Antes se usaba esto para el texto del comentario dentro del nuevoComentario
                    <!--    <p class="mb-2">${data.comentario.replace(/\n/g, "<br>")}</p>   --> */

                    nuevoComentario.innerHTML = `
                        <div class="d-flex gap-3">
                            ${iconoRol}
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">${data.email}</h6>
                                    <span class="comment-time" data-fecha="${data.fecha}">
                                        ${formatearTiempoRelativo(data.fecha)}
                                    </span>
                                </div>
                                    <p class="mb-2" data-texto="${data.comentario}">${data.comentario.replace(/\n/g, "<br>")}</p>
                                <div class="comment-actions">
                                    <a href="#" class="editar-comentario text-primary" data-id="${data.idComentario}">Editar</a>
                                    <a href="#" class="eliminar-comentario text-danger" data-id="${data.idComentario}">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    `;

                    nuevoComentario.style.opacity = 0;
                    commentSection.prepend(nuevoComentario);
                    setTimeout(() => {
                        nuevoComentario.style.transition = 'opacity 0.5s';
                        nuevoComentario.style.opacity = 1;
                    }, 10);

                    asignarEventosComentarios();

                    actualizarTiemposRelativos();

                } else {
                    mostrarMensajeComentario('Error al guardar el comentario', 'error');
                }
            })
            .catch(() => mostrarMensajeComentario('Error de red', 'error'));
        });
    }

    // Acciones de editar y eliminar comentario
    function asignarEventosComentarios() {
        // Editar comentario
        document.querySelectorAll('.editar-comentario').forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();
                const comentarioBox = this.closest('.comment-box');
                const idComentario = comentarioBox.dataset.idcomentario;
                const p = comentarioBox.querySelector('p');
            //    const textoOriginal = p.textContent;
            //    const textoOriginal = p.innerHTML.replace(/<br\s*\/?>/gi, '\n');
                const textoOriginal = p.dataset.texto;



                const textarea = document.createElement('textarea');
                textarea.classList.add('form-control', 'comment-input');
                textarea.rows = 3;
                textarea.value = textoOriginal;

                const btnGuardar = document.createElement('button');
                btnGuardar.textContent = 'Guardar';
                btnGuardar.classList.add('btn', 'btn-primary', 'mt-2', 'me-2');

                const btnCancelar = document.createElement('button');
                btnCancelar.textContent = 'Cancelar';
                btnCancelar.classList.add('btn', 'btn-secondary', 'mt-2');

                const acciones = comentarioBox.querySelector('.comment-actions');
                if (acciones) acciones.remove();

                p.replaceWith(textarea);
                comentarioBox.querySelector('.flex-grow-1').appendChild(btnGuardar);
                comentarioBox.querySelector('.flex-grow-1').appendChild(btnCancelar);

                // Cancelar edición
                btnCancelar.addEventListener('click', function () {
                    textarea.replaceWith(p);
                    btnGuardar.remove();
                    btnCancelar.remove();

                    const nuevaAccion = document.createElement('div');
                    nuevaAccion.classList.add('comment-actions');
                    nuevaAccion.innerHTML = `
                        <a href="#" class="editar-comentario text-primary" data-id="${idComentario}">Editar</a>
                        <a href="#" class="eliminar-comentario text-danger" data-id="${idComentario}">Eliminar</a>`;
                    comentarioBox.querySelector('.flex-grow-1').appendChild(nuevaAccion);

                    asignarEventosComentarios();
                });

                // Guardar edición
                btnGuardar.addEventListener('click', function () {
                    const comentarioEditado = textarea.value.trim();
                    if (!comentarioEditado) return;

                    fetch(`index.php?accion=editar_comentario&id=${idComentario}`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `comentario=${encodeURIComponent(comentarioEditado)}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.respuesta === 'ok') {
                            const nuevoParrafo = document.createElement('p');
                            nuevoParrafo.classList.add('mb-2');
                            nuevoParrafo.innerHTML = data.comentario.replace(/\n/g, "<br>");
                            nuevoParrafo.dataset.texto = data.comentario; // <-- ACTUALIZAMOS AQUÍ para que funcione el editar

                            textarea.replaceWith(nuevoParrafo);
                        //    comentarioBox.querySelector('.comment-time').textContent = data.fecha;
                            const spanTiempo = comentarioBox.querySelector('.comment-time');
                            spanTiempo.dataset.fecha = data.fecha;
                            spanTiempo.textContent = formatearTiempoRelativo(data.fecha);

                            btnGuardar.remove();
                            btnCancelar.remove();

                            const nuevaAccion = document.createElement('div');
                            nuevaAccion.classList.add('comment-actions');
                            nuevaAccion.innerHTML = `
                                <a href="#" class="editar-comentario text-primary" data-id="${idComentario}">Editar</a>
                                <a href="#" class="eliminar-comentario text-danger" data-id="${idComentario}">Eliminar</a>`;
                            comentarioBox.querySelector('.flex-grow-1').appendChild(nuevaAccion);

                            mostrarMensajeComentario('Comentario editado correctamente', 'success');

                            /* // Crear y añadir el mensaje de edición correcta de comentario
                            const mensaje = document.createElement('div');
                            mensaje.className = 'alert alert-success mt-2';
                            mensaje.innerText = 'Comentario editado correctamente';
                            // Insertar justo debajo del comentario editado
                            comentarioBox.appendChild(mensaje);
                            // Eliminar después de 3 segundos
                            setTimeout(() => mensaje.remove(), 3000); */

                            asignarEventosComentarios();

                            actualizarTiemposRelativos();

                        }
                    });
                });
            });
        });

        // Eliminar comentario
        document.querySelectorAll('.eliminar-comentario').forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();

                /* if (!confirm('¿Seguro que quieres eliminar el comentario?')) return; */

                const comentarioBox = e.target.closest('.comment-box');
                const idVideojuego = document.querySelector('[data-idVideojuego]').getAttribute('data-idVideojuego');
                const idComentario = comentarioBox.getAttribute('data-idComentario');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará el comentario permanentemente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lógica para eliminar el comentario aquí...
                        fetch('index.php?accion=eliminar_comentario&id=' + idComentario)
                            .then(response => response.json())
                            .then(data => {
                                if (data.respuesta === 'ok') {
                                    mostrarMensajeComentario('Comentario eliminado correctamente', 'success');

                                    // Eliminar el comentario del DOM
                                    comentarioBox.remove();

                                    // Comprobar si ya no hay más comentarios visibles
                                    const comentariosRestantes = document.querySelectorAll('#listaComentarios .comment-box');
                                    if (comentariosRestantes.length === 0) {
                                        // Eliminar mensaje viejo si existía
                                        const mensajeExistente = document.querySelector('#listaComentarios .sin-comentarios');
                                        if (mensajeExistente) mensajeExistente.remove();

                                        // Si no existe el contenedor de comentarios, lo creamos
                                        let contenedorComentarios = document.getElementById('listaComentarios');
                                        if (!contenedorComentarios) {
                                            contenedorComentarios = document.createElement('div');
                                            contenedorComentarios.classList.add('comment-section');
                                            contenedorComentarios.id = 'listaComentarios';

                                            // Insertamos debajo del contenedor del formulario
                                            const contenedorFormulario = document.getElementById('insertarComentario');
                                            contenedorFormulario.insertAdjacentElement('afterend', contenedorComentarios);
                                        }

                                        // Crear y añadir el mensaje
                                        const mensaje = document.createElement('p');
                                        mensaje.classList.add('sin-comentarios');
                                        mensaje.textContent = 'No hay comentarios aún. Sé el primero en comentar.';

                                        contenedorComentarios.appendChild(mensaje);
                                    }


                                } else {
                                    mostrarMensajeComentario(data.mensaje || 'No tienes permiso para eliminar este comentario', 'error');
                                }
                            });
                    }
                });
                
                    
            });
        });
    }

    asignarEventosComentarios(); // Inicial
});

/* function mostrarMensajeComentario(texto, tipo) {
    const msg = document.createElement('div');
    msg.className = `alert alert-${tipo} mt-2`;
    msg.innerText = texto;
    // document.querySelector('.comment-section').prepend(msg);
    document.getElementById('listaComentarios').prepend(msg);
    setTimeout(() => msg.remove(), 3000);
} */

function mostrarMensajeComentario(texto, tipo) {
    Swal.fire({
        icon: tipo === 'success' ? 'success' : tipo === 'warning' ? 'warning' : tipo === 'error' ? 'error' : 'info',
        title: texto,
        timer: 2500,
        showConfirmButton: false,
        toast: true,
        /* position: 'top' */
    });
}


// Función para formatear la fecha en tiempo relativo
function formatearTiempoRelativo(fechaISO) {
    const fecha = new Date(fechaISO);
    const ahora = new Date();
    const segundos = Math.floor((ahora - fecha) / 1000);

    const intervalos = {
        año: 31536000,
        mes: 2592000,
        día: 86400,
        hora: 3600,
        minuto: 60,
        segundo: 1,
    };

    const plurales = {
        año: 'años',
        mes: 'meses',
        día: 'días',
        hora: 'horas',
        minuto: 'minutos',
        segundo: 'segundos',
    };

    for (let [unidad, valor] of Object.entries(intervalos)) {
        const cantidad = Math.floor(segundos / valor);
        if (cantidad >= 1) {
            const etiqueta = cantidad > 1 ? plurales[unidad] : unidad;
            return `hace ${cantidad} ${etiqueta}`;
        }
    }

    return "justo ahora";
}

// Actualizar el tiempo relativo cada segundo o menos
setInterval(() => {
    document.querySelectorAll('.comment-time[data-fecha]').forEach(span => {
        const fecha = span.getAttribute('data-fecha');
        span.textContent = formatearTiempoRelativo(fecha);
    });
}, 10);

// Actualizar inmediatamente al cargar la página
function actualizarTiemposRelativos() {
    document.querySelectorAll('.comment-time[data-fecha]').forEach(span => {
        const fecha = span.getAttribute('data-fecha');
        span.textContent = formatearTiempoRelativo(fecha);
    });
}


// Script para buscar videojuegos
document.addEventListener('DOMContentLoaded', () => {
    const buscador = document.getElementById('buscador-videojuegos');
    const sugerencias = document.getElementById('sugerencias-videojuegos');

    buscador.addEventListener('input', () => {
        const query = buscador.value.trim();
        if (query.length === 0) {
            sugerencias.innerHTML = '';
            return;
        }

        fetch(`index.php?accion=buscar_videojuegos_ajax&query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                sugerencias.innerHTML = '';
                data.forEach(juego => {
                    const item = document.createElement('li');
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = juego.titulo;
                    item.style.cursor = 'pointer'; // Aplicamos cursor dinámicamente
                    item.addEventListener('click', () => {
                        window.location.href = `index.php?accion=ver_videojuego&id=${juego.id}`;
                    });
                    sugerencias.appendChild(item);
                });
            });
    });

    // Cerrar sugerencias si se hace clic fuera
    document.addEventListener('click', (e) => {
        if (!sugerencias.contains(e.target) && e.target !== buscador) {
            sugerencias.innerHTML = '';
        }
    });
});
