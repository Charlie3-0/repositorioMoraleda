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



