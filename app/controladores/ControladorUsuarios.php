<?php 

class ControladorUsuarios {
    public function registrar(){
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Limpiamos los datos
            $email = trim(htmlentities($_POST['email']));
            $password = trim(htmlentities($_POST['password']));

            // Validación: campos vacíos
            if (empty($email) || empty($password)) {
                $error = "Los campos email y contraseña no pueden estar vacíos.";
            }
            // Validación: longitud mínima del password
            elseif (strlen($password) < 4) {
                $error = "La contraseña debe tener al menos 4 caracteres.";
            }
            else {
                // Conectamos con la BD
                $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
                $conn = $connexionDB->getConnexion();

                // Compruebo que no haya un usuario registrado con el mismo email
                $usuariosDAO = new UsuariosDAO($conn);
                if ($usuariosDAO->getByEmail($email) != null) {
                    $error = "Ya existe un usuario con ese email.";
                } else {
                    // Si no hay error, insertamos
                    $usuario = new Usuario();
                    $usuario->setEmail($email);
                    $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                    $usuario->setPassword($passwordCifrado);
                    $usuario->setRol('U'); // Rol por defecto

                    if ($usuariosDAO->insert($usuario)) {
                        header("location: index.php?registro=ok");
                        die();
                    } else {
                        $error = "No se ha podido insertar el usuario.";
                    }
                }
            }
        }

        require 'app/vistas/registrar.php';

        // Si hay un error, lo mostramos con SweetAlert
        if (!empty($error)) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '".addslashes($error)."'
                    });
                });
            </script>";
        }
    }

    public function login(){
        $error = '';

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

        /* //email o password incorrectos, redirigir a index.php
        guardarMensaje("Email o password incorrectos");
        header('location: index.php'); */

        // Si llega aquí, hay error
        $error = "Email o contraseña incorrectos.";

        // Cargamos la vista
        require 'app/vistas/inicio.php';

        // Lanzamos SweetAlert2 con el error
        if (!empty($error)) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de acceso',
                        text: '" . addslashes($error) . "'
                    });
                });
            </script>";
        }

        
    }

    public function logout(){
        Sesion::cerrarSesion();
        header('location: index.php');
    }


}


