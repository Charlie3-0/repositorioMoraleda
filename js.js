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
    let idPelicula = this.getAttribute('data-idPelicula');
    fetch('index.php?accion=poner_reserva&id=' + idPelicula)
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
    let idPelicula = this.getAttribute('data-idPelicula');
    fetch('index.php?accion=quitar_reserva&id=' + idPelicula)
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

// Función para actualizar el estado de reserva de la pelicula
function actualizarEstadoReserva(estado) {
    const estadoReservaContenedor = document.getElementById('estadoReservaContenedor');
    if (estado === 'reservado') {
        estadoReservaContenedor.innerHTML = '<strong class="estadoReservado text-warning">Pelicula Reservada</strong>';
    } else {
        estadoReservaContenedor.innerHTML = '';
    }
}





/* Funciones para marcar y quitar película vista con AJAX asignando icono */
let vistaOn = document.querySelector('.quitarVista');
if (vistaOn != null) {
    vistaOn.addEventListener('click', quitarVista);
}

let vistaOff = document.querySelector('.ponerVista');
if (vistaOff != null) {
    vistaOff.addEventListener('click', ponerVista);
}

function ponerVista() {
    let idPelicula = this.getAttribute('data-idPelicula');
    fetch('index.php?accion=poner_pelicula_vista&id=' + idPelicula)
        .then(response => response.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                console.log('Vista puesta con éxito');
                actualizarEstadoVista('vista');

                let botonVista = document.getElementById('botonVista');
                let textoVista = document.querySelector('.texto-visto');

                botonVista.classList.add('icono-animado');
                setTimeout(() => botonVista.classList.remove('icono-animado'), 300);

                botonVista.classList.remove('ponerVista', 'icono-no-visto', 'fa-eye-slash');
                botonVista.classList.add('quitarVista', 'icono-visto', 'fa-eye');
                botonVista.setAttribute('title', 'Quitar vista');
                botonVista.removeEventListener('click', ponerVista);
                botonVista.addEventListener('click', quitarVista);

                if (textoVista) {
                    textoVista.classList.remove('oculto');
                }
            } else {
                console.error('Error al marcar película como vista');
            }
        })
        .catch(error => console.error('Error en la solicitud:', error));
}

function quitarVista() {
    let idPelicula = this.getAttribute('data-idPelicula');
    fetch('index.php?accion=quitar_pelicula_vista&id=' + idPelicula)
        .then(response => response.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                console.log('Vista quitada con éxito');
                actualizarEstadoVista('no_vista');

                let botonVista = document.getElementById('botonVista');
                let textoVista = document.querySelector('.texto-visto');

                botonVista.classList.add('icono-animado');
                setTimeout(() => botonVista.classList.remove('icono-animado'), 300);

                botonVista.classList.remove('quitarVista', 'icono-visto', 'fa-eye');
                botonVista.classList.add('ponerVista', 'icono-no-visto', 'fa-eye-slash');
                botonVista.setAttribute('title', 'Marcar como vista');
                botonVista.removeEventListener('click', quitarVista);
                botonVista.addEventListener('click', ponerVista);

                if (textoVista) {
                    textoVista.classList.add('oculto');
                }
            } else {
                console.error('Error al quitar estado de vista');
            }
        })
        .catch(error => console.error('Error en la solicitud:', error));
}

// Función para actualizar el estado visual de pelicula vista
function actualizarEstadoVista(estado) {
    const estadoVistaContenedor = document.getElementById('estadoVistaContenedor');
    if (estado === 'vista') {
        estadoVistaContenedor.innerHTML = '<strong class="estadoVista text-success">Película Vista</strong>';
    } else {
        estadoVistaContenedor.innerHTML = '';
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
        const idPelicula = this.getAttribute('data-idPelicula');

        fetch(`index.php?accion=guardar_puntuacion&id=${idPelicula}`, {
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


// Mostrar media visual de la película
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
const formularioComentario = document.getElementById('formComentario');
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
}

/* function mostrarMensajeComentario(mensaje, tipo) {
    const contenedor = document.getElementById('estadoComentarioContenedor');
    if (!contenedor) return;

    contenedor.innerHTML = `<div class="alert alert-${tipo}">${mensaje}</div>`;
    setTimeout(() => contenedor.innerHTML = '', 3000);
} */





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


