<?php 
class Sesion {

    // MÉTODOS PARA USUARIO
    static public function getUsuario():Usuario|false {
        if(isset($_SESSION['usuario'])) {
            return unserialize($_SESSION['usuario']);
        }else {
            return false;
        }
    }

    static public function iniciarSesion($usuario) {
        $_SESSION['usuario'] = serialize($usuario);
    }

    static public function cerrarSesion() {
        unset($_SESSION['usuario']);
        
    }

    static public function existeSesion() {
        if(isset($_SESSION['usuario'])) {
            return true;
        }else {
            return false;
        }
    }

}

/**
 * Para iniciar sesión: Sesion::iniciarSesion($usuario);
 * Para cerrar sesión: Sesion::cerrarSesion();
 * Para obtener el usuario: Sesion::getUsuario()
 * Para obtener una propiedad del usuario: Sesion::getUsuario()->getFoto()
 * Para comprobar si se ha iniciado sesión: if(Sesion::getUsuario())...
 */