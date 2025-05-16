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

            } else {
                console.error('Error al poner reserva');
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
            } else {
                console.error('Error al quitar reserva');
            }
        });
}

// Función para actualizar el estado de reserva del videojuego
function actualizarEstadoReserva(estado) {
    const estadoReservaContenedor = document.getElementById('estadoReservaContenedor');
    if (estado === 'reservado') {
        estadoReservaContenedor.innerHTML = '<strong class="estadoReservado text-warning">Videojuego Reservado</strong>';
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

                botonProbado.classList.remove('ponerProbado', 'icono-no-probado', 'fa-eye-slash');
                botonProbado.classList.add('quitarProbado', 'icono-probado', 'fa-eye');
                botonProbado.setAttribute('title', 'Quitar probado');
                botonProbado.removeEventListener('click', ponerProbado);
                botonProbado.addEventListener('click', quitarProbado);

                if (textoProbado) {
                    textoProbado.classList.remove('oculto');
                }
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

                botonProbado.classList.remove('quitarProbado', 'icono-probado', 'fa-eye');
                botonProbado.classList.add('ponerProbado', 'icono-no-probado', 'fa-eye-slash');
                botonProbado.setAttribute('title', 'Marcar como probado');
                botonProbado.removeEventListener('click', quitarProbado);
                botonProbado.addEventListener('click', ponerProbado);

                if (textoProbado) {
                    textoProbado.classList.add('oculto');
                }
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
// Añadir comentario
/* const formularioComentario = document.getElementById('formComentario');
if (formularioComentario) {
    formularioComentario.addEventListener('submit', function (e) {
        e.preventDefault();
        const comentario = document.getElementById('comentarioTexto').value.trim();
        const idPelicula = document.querySelector('[data-idPelicula]').getAttribute('data-idPelicula');

        if (!comentario) {
            mostrarMensajeComentario('El comentario no puede estar vacío', 'danger');
            return;
        }

        fetch(`index.php?accion=guardar_comentario&id=${idPelicula}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `comentario=${encodeURIComponent(comentario)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                mostrarMensajeComentario('Comentario guardado correctamente', 'success');
            } else if (data.respuesta === 'comentario_vacio') {
                mostrarMensajeComentario('Debes escribir algo antes de enviar', 'warning');
            } else if (data.respuesta === 'no_sesion') {
                mostrarMensajeComentario('Debes iniciar sesión para comentar', 'warning');
            } else {
                mostrarMensajeComentario('Error al guardar el comentario', 'danger');
            }
        })
        .catch(err => {
            console.error('Error en la solicitud:', err);
            mostrarMensajeComentario('Error de red', 'danger');
        });
    });
} */



/* const formularioComentario = document.getElementById('formComentario');
if (formularioComentario) {
    formularioComentario.addEventListener('submit', function (e) {
        e.preventDefault();

        const comentario = document.getElementById('comentarioTexto');
        const idPelicula = formularioComentario.getAttribute('data-idPelicula');

        if (!comentario) {
            mostrarMensajeComentario('El comentario no puede estar vacío', 'danger');
            return;
        }

        fetch(`index.php?accion=guardar_comentario&id=${idPelicula}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `comentario=${encodeURIComponent(comentario)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                mostrarMensajeComentario('Comentario guardado correctamente', 'success');

                // Ocultar el formulario
                formularioComentario.remove();

                // Insertar nuevo comentario
                const comentariosContainer = document.querySelector('.comment-section');
                const nuevoComentario = document.createElement('div');
                nuevoComentario.classList.add('comment-box', 'mb-3');
                nuevoComentario.innerHTML = `
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-user"></i>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">${data.email}</h6>
                                <span class="comment-time">${data.fecha}</span>
                            </div>
                            <p class="mb-2">${data.comentario.replace(/\n/g, "<br>")}</p>
                            <div class="comment-actions">
                                <a href="#" class="editar-comentario text-primary">Editar</a>
                                <a href="#" class="eliminar-comentario text-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                `;

                // Animación de aparición
                nuevoComentario.style.opacity = 0;
                comentariosContainer.prepend(nuevoComentario);
                setTimeout(() => {
                    nuevoComentario.style.transition = 'opacity 0.6s';
                    nuevoComentario.style.opacity = 1;
                }, 10);

                // Reasignar eventos de edición y eliminación
                asignarEventosComentarios();
            } else if (data.respuesta === 'comentario_vacio') {
                mostrarMensajeComentario('Debes escribir algo antes de enviar', 'warning');
            } else if (data.respuesta === 'no_sesion') {
                mostrarMensajeComentario('Debes iniciar sesión para comentar', 'warning');
            } else {
                mostrarMensajeComentario('Error al guardar el comentario', 'danger');
            }
        })
        .catch(err => {
            console.error('Error en la solicitud:', err);
            mostrarMensajeComentario('Error de red', 'danger');
        });
    });
} */



// Editar comentario
/* document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.editar-comentario').forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            e.preventDefault();

            const comentarioBox = this.closest('.comment-box');
            const textoOriginal = comentarioBox.querySelector('p');
            const idPelicula = document.getElementById('formComentario')?.dataset.idpelicula;

            // Evitar múltiples formularios
            if (comentarioBox.querySelector('form')) return;

            const textoComentario = textoOriginal.textContent.trim();

            const formHTML = `
                <form class="form-editar-comentario" action="index.php?accion=editar_comentario" method="post">
                    <input type="hidden" name="idPelicula" value="${idPelicula}">
                    <textarea name="comentario" class="form-control mb-2">${textoComentario}</textarea>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        <button type="button" class="btn btn-secondary btn-sm cancelar-edicion">Cancelar</button>
                    </div>
                </form>
            `;

            // Ocultar el texto original y reemplazarlo por el formulario
            textoOriginal.style.display = 'none';
            comentarioBox.insertAdjacentHTML('beforeend', formHTML);

            // Cancelar edición
            comentarioBox.querySelector('.cancelar-edicion').addEventListener('click', () => {
                comentarioBox.querySelector('.form-editar-comentario').remove();
                textoOriginal.style.display = '';
            });

            // Manejar envío por AJAX
            comentarioBox.querySelector('.form-editar-comentario').addEventListener('submit', function (e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.exito) {
                            textoOriginal.textContent = data.comentario_actualizado;
                            comentarioBox.querySelector('.comment-time').textContent = data.fecha_comentario;
                            form.remove();
                            textoOriginal.style.display = '';
                        } else {
                            alert('Error al guardar el comentario.');
                        }
                    });
            });
        });
    });
}); */





/* document.addEventListener("DOMContentLoaded", function () {
    const formComentario = document.getElementById('formComentario');
    const commentSection = document.querySelector('.comment-section');
    const idPelicula = document.querySelector('[data-idPelicula]').getAttribute('data-idPelicula');

    if (formComentario) {
        formComentario.addEventListener('submit', function (e) {
            e.preventDefault();
            const comentario = document.getElementById('comentarioTexto').value;

            fetch('index.php?accion=guardar_comentario', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: idPelicula, comentario })
            })
            .then(response => response.json())
            .then(data => {
                if (data.respuesta === 'ok') {
                    const nuevoComentario = document.createElement('div');
                    nuevoComentario.classList.add('comment-box', 'mb-3');
                    nuevoComentario.innerHTML = `
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-user"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">${data.email}</h6>
                                    <span class="comment-time">${data.fecha_comentario}</span>
                                </div>
                                <p class="mb-2">${data.comentario.replace(/\n/g, '<br>')}</p>
                                <div class="comment-actions">
                                    <a href="#" class="editar-comentario">Editar</a>
                                </div>
                            </div>
                        </div>`;
                    commentSection.appendChild(nuevoComentario);
                    formComentario.remove(); // Ocultamos el formulario tras comentar
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    document.addEventListener('click', function (e) {
        // EDITAR COMENTARIO
        if (e.target.classList.contains('editar-comentario')) {
            e.preventDefault();

            const comentarioBox = e.target.closest('.comment-box');
            const textoParrafo = comentarioBox.querySelector('p');
            const textoActual = textoParrafo.textContent;

            const textarea = document.createElement('textarea');
            textarea.classList.add('form-control', 'comment-input');
            textarea.rows = 3;
            textarea.value = textoActual;

            const btnGuardar = document.createElement('button');
            btnGuardar.textContent = 'Guardar';
            btnGuardar.classList.add('btn', 'btn-comment', 'text-white', 'mt-2');

            // LIMPIAR acciones anteriores (botones)
            const acciones = comentarioBox.querySelector('.comment-actions');
            if (acciones) acciones.remove();

            // Reemplazar el <p> por el <textarea>
            textoParrafo.replaceWith(textarea);
            comentarioBox.querySelector('.flex-grow-1').appendChild(btnGuardar);

            const idPelicula = document.querySelector('[data-idPelicula]').getAttribute('data-idPelicula');

            btnGuardar.addEventListener('click', function () {
                const comentarioEditado = textarea.value;
            
                fetch('index.php?accion=editar_comentario&id=' + idPelicula, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ comentario: comentarioEditado })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.respuesta === 'ok') {
                        const nuevoParrafo = document.createElement('p');
                        nuevoParrafo.classList.add('mb-2');
                        nuevoParrafo.innerHTML = data.comentario.replace(/\n/g, '<br>');
            
                        textarea.replaceWith(nuevoParrafo);
                        comentarioBox.querySelector('.comment-time').textContent = data.fecha;
            
                        // ELIMINAR botón guardar si sigue ahí
                        btnGuardar.remove();

                        // AÑADIR de nuevo las acciones (Editar + Eliminar)
                        const nuevaAccion = document.createElement('div');
                        nuevaAccion.classList.add('comment-actions');
                        nuevaAccion.innerHTML = `
                            <a href="#" class="editar-comentario text-primary">Editar</a>
                            <a href="#" class="eliminar-comentario text-danger">Eliminar</a>`;
                        comentarioBox.querySelector('.flex-grow-1').appendChild(nuevaAccion);
                    }
                })
                .catch(error => console.error('Error al actualizar:', error));
            });
            
        }

        // ELIMINAR COMENTARIO
        if (e.target.classList.contains('eliminar-comentario')) {
            e.preventDefault();
    
            if (!confirm('¿Seguro que quieres eliminar tu comentario?')) return;
    
            const comentarioBox = e.target.closest('.comment-box');
            const idPelicula = document.querySelector('[data-idPelicula]').getAttribute('data-idPelicula');
    
            fetch('index.php?accion=eliminar_comentario&id=' + idPelicula)
                .then(response => response.json())
                .then(data => {
                    if (data.respuesta === 'ok') {
                        comentarioBox.remove();
    
                        // Mostrar el formulario de nuevo para comentar
                        location.reload(); // O podrías volver a mostrar dinámicamente el formComentario

                        // VOLVER A MOSTRAR el formulario de nuevo para comentar
                        const nuevoForm = document.createElement('form');
                        nuevoForm.id = 'formComentario';
                        nuevoForm.setAttribute('data-idPelicula', idPelicula);
                        nuevoForm.innerHTML = `
                            <?php if (Sesion::existeSesion() && !$comentarioUsuarioActual): ?>
                                <div class="d-flex gap-3">
                                    <i class="fa-solid fa-user"></i>
                                    <span class="emailUsuario"><?= Sesion::getUsuario()->getEmail(); ?></span>
                                    <div class="flex-grow-1">
                                        <textarea id="comentarioTexto" class="form-control comment-input" rows="3" placeholder="Escribe un comentario..."></textarea>
                                        <div class="mt-3 text-end">
                                            <button type="submit" class="btn btn-comment text-white">Publicar Comentario</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        `;
                        document.querySelector('.comment-section').appendChild(nuevoForm);
    
                        // Reasignar el event listener al nuevo formulario
                        nuevoForm.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const comentario = document.getElementById('comentarioTexto').value.trim();
    
                            if (!comentario) {
                                alert('El comentario no puede estar vacío');
                                return;
                            }
    
                            fetch('index.php?accion=guardar_comentario&id=' + idPelicula, {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: 'comentario=' + encodeURIComponent(comentario)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.respuesta === 'ok') {
                                    location.reload(); // o reinsertar dinámicamente como en insertar
                                }
                            });
                        });
                    }
                })
                .catch(error => console.error('Error al eliminar:', error));
        }

    });
}); */








/* document.querySelectorAll('.editar-comentario').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const comentarioBox = this.closest('.comment-box');
        const comentarioTexto = comentarioBox.querySelector('p');
        const textoOriginal = comentarioTexto.textContent.trim();

        // Evitar que se duplique si ya está editando
        if (comentarioBox.querySelector('textarea')) return;

        // Crear textarea con el contenido actual
        const textarea = document.createElement('textarea');
        textarea.className = 'form-control mb-2';
        textarea.rows = 3;
        textarea.value = textoOriginal;

        // Crear botones
        const btnGuardar = document.createElement('button');
        btnGuardar.textContent = 'Guardar';
        btnGuardar.className = 'btn btn-sm btn-primary me-2';

        const btnCancelar = document.createElement('button');
        btnCancelar.textContent = 'Cancelar';
        btnCancelar.className = 'btn btn-sm btn-secondary';

        const botones = document.createElement('div');
        botones.className = 'mt-2';
        botones.appendChild(btnGuardar);
        botones.appendChild(btnCancelar);

        // Reemplazar el texto del comentario por el textarea y botones
        comentarioTexto.style.display = 'none';
        comentarioTexto.parentNode.insertBefore(textarea, comentarioTexto);
        comentarioTexto.parentNode.insertBefore(botones, comentarioTexto.nextSibling);

        // Cancelar: restaurar comentario original
        btnCancelar.addEventListener('click', () => {
            textarea.remove();
            botones.remove();
            comentarioTexto.style.display = '';
        });

        // Guardar cambios
        btnGuardar.addEventListener('click', () => {
            const nuevoComentario = textarea.value.trim();
            if (!nuevoComentario) {
                mostrarMensajeComentario('No puedes dejar el comentario vacío', 'warning');
                return;
            }

            const idPelicula = document.querySelector('[data-idPelicula]').getAttribute('data-idPelicula');

            fetch(`index.php?accion=editar_comentario&id=${idPelicula}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `comentario=${encodeURIComponent(nuevoComentario)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.respuesta === 'ok') {
                    comentarioTexto.textContent = data.comentario;
                    comentarioBox.querySelector('.comment-time').textContent = data.fecha;
                    mostrarMensajeComentario('Comentario editado correctamente', 'success');
                } else if (data.respuesta === 'comentario_vacio') {
                    mostrarMensajeComentario('No puedes dejar el comentario vacío', 'warning');
                } else if (data.respuesta === 'no_sesion') {
                    mostrarMensajeComentario('Debes iniciar sesión para editar comentarios', 'warning');
                } else {
                    mostrarMensajeComentario('Error al editar el comentario', 'danger');
                }
                // Restaurar vista
                textarea.remove();
                botones.remove();
                comentarioTexto.style.display = '';
            })
            .catch(err => {
                console.error('Error en la solicitud:', err);
                mostrarMensajeComentario('Error de red', 'danger');
            });
        });
    });
}); */




/* function mostrarMensajeComentario(mensaje, tipo) {
    const contenedor = document.getElementById('estadoComentarioContenedor');
    if (!contenedor) return;

    contenedor.innerHTML = `<div class="alert alert-${tipo}">${mensaje}</div>`;
    setTimeout(() => contenedor.innerHTML = '', 3000);
} */




// ESTE ES EL QUE GUARDA Y EDITA CON AJAX CORRECTAMENTE(pero falta la funcion en DAO y controlador)
/* document.addEventListener("DOMContentLoaded", function () {
    const formComentario = document.getElementById('formComentario');
    if (formComentario) {
        formComentario.addEventListener('submit', function (e) {
            e.preventDefault();
            const idPelicula = this.getAttribute('data-idPelicula');
            const comentario = document.getElementById('comentarioTexto').value;

            fetch('index.php?accion=guardar_comentario', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: idPelicula, comentario })
            })
            .then(response => response.json())
            .then(data => {
                if (data.respuesta === 'ok') {
                    console.log('Comentario guardado');

                    const nuevoComentario = document.createElement('div');
                    nuevoComentario.classList.add('comment-box', 'mb-3');
                    nuevoComentario.innerHTML = `
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-user"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">${data.email}</h6>
                                    <span class="comment-time">${data.fecha_comentario}</span>
                                </div>
                                <p class="mb-2">${data.comentario.replace(/\n/g, '<br>')}</p>
                                <div class="comment-actions">
                                    <a href="#" class="editar-comentario">Editar</a>
                                </div>
                            </div>
                        </div>`;
                    document.querySelector('.comment-section').appendChild(nuevoComentario);

                    // Ocultamos el formulario
                    formComentario.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('editar-comentario')) {
            e.preventDefault();
            const comentarioBox = e.target.closest('.comment-box');
            const textoParrafo = comentarioBox.querySelector('p');
            const textoActual = textoParrafo.textContent;

            const textarea = document.createElement('textarea');
            textarea.classList.add('form-control', 'comment-input');
            textarea.rows = 3;
            textarea.value = textoActual;

            const btnGuardar = document.createElement('button');
            btnGuardar.textContent = 'Guardar';
            btnGuardar.classList.add('btn', 'btn-comment', 'text-white', 'mt-2');

            comentarioBox.querySelector('.comment-actions').replaceChildren();
            textoParrafo.replaceWith(textarea);
            comentarioBox.querySelector('.flex-grow-1').appendChild(btnGuardar);

            btnGuardar.addEventListener('click', function () {
                const comentarioEditado = textarea.value;
                const idPelicula = document.getElementById('formComentario')?.getAttribute('data-idPelicula') ||
                                   document.querySelector('[data-idPelicula]')?.getAttribute('data-idPelicula');

                fetch('index.php?accion=guardar_comentario', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: idPelicula, comentario: comentarioEditado })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.respuesta === 'ok') {
                        const nuevoParrafo = document.createElement('p');
                        nuevoParrafo.classList.add('mb-2');
                        nuevoParrafo.innerHTML = data.comentario.replace(/\n/g, '<br>');

                        textarea.replaceWith(nuevoParrafo);
                        comentarioBox.querySelector('.comment-time').textContent = data.fecha_comentario;

                        const nuevaAccion = document.createElement('div');
                        nuevaAccion.classList.add('comment-actions');
                        nuevaAccion.innerHTML = '<a href="#" class="editar-comentario">Editar</a>';
                        comentarioBox.querySelector('.flex-grow-1').appendChild(nuevaAccion);
                    }
                })
                .catch(error => console.error('Error al actualizar:', error));
            });
        }
    });
}); */






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

                    // Eliminar el formulario y el contenedor donde se encuentra
                    formComentario.remove();
                    contenedorForm.remove();

                    // Si hay comentarios, eliminar el mensaje de "sin comentarios"
                    if (sinComentarios) {
                        sinComentarios.remove();
                    }

                    // Crear comentario dinámicamente
                    const nuevoComentario = document.createElement('div');
                    nuevoComentario.classList.add('comment-box', 'mb-3');
                    nuevoComentario.innerHTML = `
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-user"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">${data.email}</h6>
                                    <span class="comment-time">${data.fecha}</span>
                                </div>
                                <p class="mb-2">${data.comentario.replace(/\n/g, "<br>")}</p>
                                <div class="comment-actions">
                                    <a href="#" class="editar-comentario text-primary">Editar</a>
                                    <a href="#" class="eliminar-comentario text-danger">Eliminar</a>
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
                } else {
                    mostrarMensajeComentario('Error al guardar el comentario', 'danger');
                }
            })
            .catch(() => mostrarMensajeComentario('Error de red', 'danger'));
        });
    }

    // Acciones de editar y eliminar comentario
    function asignarEventosComentarios() {
        // Editar comentario
        document.querySelectorAll('.editar-comentario').forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();
                const comentarioBox = this.closest('.comment-box');
                const p = comentarioBox.querySelector('p');
                const textoOriginal = p.textContent;

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
                        <a href="#" class="editar-comentario text-primary">Editar</a>
                        <a href="#" class="eliminar-comentario text-danger">Eliminar</a>`;
                    comentarioBox.querySelector('.flex-grow-1').appendChild(nuevaAccion);

                    asignarEventosComentarios();
                });

                // Guardar edición
                btnGuardar.addEventListener('click', function () {
                    const comentarioEditado = textarea.value.trim();
                    if (!comentarioEditado) return;

                    fetch(`index.php?accion=editar_comentario&id=${idPelicula}`, {
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

                            textarea.replaceWith(nuevoParrafo);
                            comentarioBox.querySelector('.comment-time').textContent = data.fecha;
                            btnGuardar.remove();
                            btnCancelar.remove();

                            const nuevaAccion = document.createElement('div');
                            nuevaAccion.classList.add('comment-actions');
                            nuevaAccion.innerHTML = `
                                <a href="#" class="editar-comentario text-primary">Editar</a>
                                <a href="#" class="eliminar-comentario text-danger">Eliminar</a>`;
                            comentarioBox.querySelector('.flex-grow-1').appendChild(nuevaAccion);

                            asignarEventosComentarios();
                        }
                    });
                });
            });
        });

        // Eliminar comentario
        document.querySelectorAll('.eliminar-comentario').forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();

                if (!confirm('¿Seguro que quieres eliminar tu comentario?')) return;

                const comentarioBox = e.target.closest('.comment-box');
                const idVideojuego = document.querySelector('[data-idVideojuego]').getAttribute('data-idVideojuego');

                fetch('index.php?accion=eliminar_comentario&id=' + idVideojuego)
                    .then(response => response.json())
                    .then(data => {
                        if (data.respuesta === 'ok') {
                            mostrarMensajeComentario('Comentario eliminado correctamente', 'success');

                            // Eliminar el comentario del DOM
                            comentarioBox.remove();

                            // Mostrar de nuevo el formulario de comentar
                            if (!document.getElementById('formComentario')) {
                                const nuevoForm = document.createElement('form');
                                nuevoForm.id = 'formComentario';
                                nuevoForm.setAttribute('data-idVideojuego', idVideojuego);
                                nuevoForm.classList.add('mb-4'); // añadimos clase al form
                                nuevoForm.innerHTML = `
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-user"></i>
                                        <span class="emailUsuario">${usuarioEmail}</span>
                                        <div class="flex-grow-1">
                                            <textarea id="comentarioTexto" class="form-control comment-input" rows="3" placeholder="Escribe un comentario..."></textarea>
                                            <div class="mt-3 text-end">
                                                <button type="submit" class="btn btn-comment text-white">Publicar Comentario</button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                

                                commentSection.appendChild(nuevoForm);

                                nuevoForm.addEventListener('submit', function (e) {
                                    e.preventDefault();
                                    const comentario = document.getElementById('comentarioTexto').value.trim();
                                    if (!comentario) return;

                                    fetch(`index.php?accion=guardar_comentario&id=${idVideojuego}`, {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                        body: `comentario=${encodeURIComponent(comentario)}`
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.respuesta === 'ok') {
                                            mostrarMensajeComentario('Comentario guardado correctamente', 'success');

                                            // Eliminar el formulario directamente (nuevoForm)
                                            nuevoForm.remove();

                                            // También podrías eliminar su contenedor si existe
                                            const contenedorInsertar = document.getElementById('insertarComentario');
                                            if (contenedorInsertar) contenedorInsertar.innerHTML = '';

                                            // Si hay comentarios, eliminar el mensaje de "sin comentarios"
                                            const sinComentarios = document.querySelector('.sin-comentarios');
                                            if (sinComentarios) {
                                                sinComentarios.remove();
                                            }

                                            // Crear comentario dinámicamente
                                            const nuevoComentario = document.createElement('div');
                                            nuevoComentario.classList.add('comment-box', 'mb-3');
                                            nuevoComentario.innerHTML = `
                                                <div class="d-flex gap-3">
                                                    <i class="fa-solid fa-user"></i>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <h6 class="mb-0">${data.email}</h6>
                                                            <span class="comment-time">${data.fecha}</span>
                                                        </div>
                                                        <p class="mb-2">${data.comentario.replace(/\n/g, "<br>")}</p>
                                                        <div class="comment-actions">
                                                            <a href="#" class="editar-comentario text-primary">Editar</a>
                                                            <a href="#" class="eliminar-comentario text-danger">Eliminar</a>
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

                                            // Reasignar eventos a los nuevos botones
                                            asignarEventosComentarios();
                                        } else {
                                            mostrarMensajeComentario('Error al guardar el comentario', 'danger');
                                        }
                                    

                                    });
                                });
                                
                            }

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
                                mensaje.textContent = 'No hay comentarios aún. Sé el primero en comentar en este videojuego.';

                                contenedorComentarios.appendChild(mensaje);
                            }

                            
                        }
                    });

                            // Mostrar el formulario de nuevo para comentar
                            /* location.reload(); */ // O podríamos volver a mostrar dinámicamente el formComentario

                            
                        
                    /* .catch(error => console.error('Error al eliminar:', error)); */
                    
            });
        });
    }

    asignarEventosComentarios(); // Inicial
});

function mostrarMensajeComentario(texto, tipo) {
    const msg = document.createElement('div');
    msg.className = `alert alert-${tipo} mt-2`;
    msg.innerText = texto;
    /* document.querySelector('.comment-section').prepend(msg); */
    document.getElementById('listaComentarios').prepend(msg);
    setTimeout(() => msg.remove(), 3000);
}


