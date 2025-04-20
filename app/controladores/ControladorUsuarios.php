<?php 

class ControladorUsuarios {
    public function registrar(){
        $error = '';

        if ($_SERVER['REQUEST_METHOD']=='POST') {

            //Limpiamos los datos
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            //Compruebo que no haya un usuario registrado con el mismo email
            $usuariosDAO = new UsuariosDAO($conn);
            if ($usuariosDAO->getByEmail($email) != null) {
                $error = "Ya hay un usuario con ese email";
            } else {

                if ($error == '')    //Si no hay error
                {
                    //Insertamos en la BD

                    $usuario = new Usuario();
                    $usuario->setEmail($email);
                    //encriptamos el password
                    $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                    $usuario->setPassword($passwordCifrado);

                    // Establecer rol por defecto antes de insertar
                    $usuario->setRol('U');

                    if ($usuariosDAO->insert($usuario)) {
                        header("location: index.php");
                        die();
                    } else {
                        $error = "No se ha podido insertar el usuario";
                    }
                }
            }
        } //
        
        require 'app/vistas/registrar.php';
    }

    public function login(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //limpiamos los datos que vienen del usuario
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //Validamos el usuario
        $usuariosDAO = new UsuariosDAO($conn);
        if ($usuario = $usuariosDAO->getByEmail($email)) {
            if (password_verify($password, $usuario->getPassword())) {
                //email y password correctos. Inciamos sesión
                Sesion::iniciarSesion($usuario);
                
                
                //$_SESSION['email'] = $usuario->getEmail();
                //$_SESSION['id'] = $usuario->getId();

                //Redirigimos a index.php
                header('location: index.php');
                die();
            }
        }
        //email o password incorrectos, redirigir a index.php
        guardarMensaje("Email o password incorrectos");
        header('location: index.php');
    }

    public function logout(){
        Sesion::cerrarSesion();
        header('location: index.php');
    }


}


