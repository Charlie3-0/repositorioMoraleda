<?php 
class Sesion {

    // MÉTODOS PARA USUARIO
    static public function getUsuario():Usuario|false{
        if(isset($_SESSION['usuario'])){
            return unserialize($_SESSION['usuario']);
            /*
            $usuario = unserialize($_SESSION['usuario']);
            echo "<pre>";
            var_dump($usuario);
            echo "</pre>";
            return $usuario;
            */ 
        }else{
            return false;
        }
    }

    static public function iniciarSesion($usuario){
        $_SESSION['usuario'] = serialize($usuario);
    }

    static public function cerrarSesion(){
        unset($_SESSION['usuario']);
        
    }

    static public function existeSesion(){
        if(isset($_SESSION['usuario'])){
            return true;
        }else{
            return false;
        }
    }



    // MÉTODOS PARA ADMINISTRADOR
    static public function getAdmin():Administrador|false{
        if(isset($_SESSION['administrador'])){
            return unserialize($_SESSION['administrador']); 
        }else{
            return false;
        }
    }

    static public function iniciarSesionAdmin($administrador){
        $_SESSION['administrador'] = serialize($administrador);
    }

    static public function cerrarSesionAdmin(){
        unset($_SESSION['administrador']);
        
    }

    static public function existeSesionAdmin(){
        if(isset($_SESSION['administrador'])){
            return true;
        }else{
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