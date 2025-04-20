<?php 
/**
 * Genera un hash aleatorio para un nombre de arhivo manteniendo la extensión original
 */
function generarNombreArchivo(string $nombreOriginal):string {
    $nuevoNombre = md5(time()+rand());
    $partes = explode('.',$nombreOriginal);
    $extension = $partes[count($partes)-1];
    return $nuevoNombre.'.'.$extension;
}

function guardarMensaje($mensaje){
    $_SESSION['error']=$mensaje;
}

function guardarMensajeGeneral($mensaje){
    $_SESSION['error2']=$mensaje;
}

/* Función para el resto de los errores */
/* function imprimirMensajeGeneral(){
    if(isset($_SESSION['error'])){
        echo '<div class="error" id="mensajeError">'.$_SESSION['error'].'</div>';
        unset($_SESSION['error']);
    } 
} */



/* Función para errores generales */
function imprimirMensajeGeneral() {
    if (isset($_SESSION['error2'])) {
        echo '<h4 class="alert alert-danger text-center mx-auto" role="alert" id="mensajeError">' . $_SESSION['error2'] . '</h4>';
        unset($_SESSION['error2']);
    } 
}


/* Función de error para email o password incorrectos */
function imprimirMensaje() {
    $mensajeError = '';
    if (isset($_SESSION['error'])) {
        $mensajeError = $_SESSION['error'];
        unset($_SESSION['error']); // Eliminamos el mensaje de la sesión después de obtenerlo
    }
    return $mensajeError;
}