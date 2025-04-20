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
                        mediaElemento.innerHTML = `Media: ${data.nuevaMedia}/10`;
                    }
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

