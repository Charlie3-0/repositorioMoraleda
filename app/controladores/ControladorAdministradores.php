<?php 

class ControladorAdministradores {
    public function registrarAdministrador(){
        $error = '';

        if ($_SERVER['REQUEST_METHOD']=='POST') {

            //Limpiamos los datos
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            //Compruebo que no haya un administrador registrado con el mismo email
            $administradoresDAO = new AdministradoresDAO($conn);
            if ($administradoresDAO->getByEmail($email) != null) {
                $error = "Ya hay un administrador con ese email";
            } else {

                if ($error == '')    //Si no hay error
                {
                    //Insertamos en la BD

                    $administrador = new Administrador();
                    $administrador->setEmail($email);
                    //encriptamos el password
                    $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                    $administrador->setPassword($passwordCifrado);

                    if ($administradoresDAO->insert($administrador)) {
                        header("location: index.php");
                        die();
                    } else {
                        $error = "No se ha podido insertar el administrador";
                    }
                }
            }
        } //
        
        require '../app/vistas/registrarAdmin.php';
    }

    public function loginAdministrador(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //limpiamos los datos que vienen del administrador
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //Validamos el administrador
        $administradoresDAO = new AdministradoresDAO($conn);
        if ($administrador = $administradoresDAO->getByEmail($email)) {
            if (password_verify($password, $administrador->getPassword())) {
                //email y password correctos. Inciamos sesión
                Sesion::iniciarSesionAdmin($administrador);
                
                
                //$_SESSION['email'] = $administrador->getEmail();
                //$_SESSION['id'] = $administrador->getId();

                //Redirigimos a index.php
                header('location: index.php');
                die();
            }
        }
        //email o password incorrectos, redirigir a index.php
        guardarMensaje("Email o password incorrectos");
        header('location: index.php');

        /* require '../app/vistas/loginAdmin.php'; */
    }

    public function logoutAdministrador(){
        Sesion::cerrarSesionAdmin();
        header('location: index.php');
    }


}