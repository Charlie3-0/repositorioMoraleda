<?php 

class ControladorPrestamos {

    public function verPrestamos(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener el videojuego
        /* $idVideojuego = htmlspecialchars($_GET['id']);
        $videojuego = $videojuegosDAO->getById($idVideojuego); */

        $idUsuario =htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);
        //var_dump($_GET);

        // Obtener los préstamos
        $prestamos = $prestamosDAO->obtenerPrestamosByIdUsuario($idUsuario);
        
        // Asignar el videojuego a cada préstamo
        foreach ($prestamos as $prestamo) {
            $prestamo->videojuego = $videojuegosDAO->getById($prestamo->getIdVideojuego());
        }

        require 'app/vistas/ver_prestados.php';
    }


    public function verTodosPrestamos(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener todos los préstamos
        $todosLosPrestamos = $prestamosDAO->getAll();

        
        foreach ($todosLosPrestamos as $prestamo) {
            $prestamo->videojuego = $videojuegosDAO->getById($prestamo->getIdVideojuego()); // Asignar el videojuego a cada préstamo
            $prestamo->usuario = $usuariosDAO->getById($prestamo->getIdUsuario()); // Asignar el usuario al préstamo
        }

        // Pasar los préstamos a la vista
        $prestamos = $todosLosPrestamos;

        require 'app/vistas/ver_todos_prestamos.php';
    }


    public function insertarPrestamo() {
        $error = '';
    
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $usuariosDAO = new UsuariosDAO($conn);
        $videojuegosDAO = new VideojuegosDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
    
        // Obtener todos los usuarios y videojuegos
        $usuarios = $usuariosDAO->getAll();
        $videojuegos = $videojuegosDAO->getAll();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos que vienen del formulario
            $idUsuario = htmlspecialchars($_POST['idUsuario']); // Es necesario si queremos seleccionar usuario en el desplegable
            $idVideojuego = htmlspecialchars($_POST['idVideojuego']); // Es necesario si queremos seleccionar videojuego en el desplegable
            $fecha_prestamo = date('Y-m-d'); // Fecha actual
            $devuelto = 0; // Por defecto, el videojuego NO está devuelto
    
            // Obtener el número de préstamos para el videojuego(en nuestro caso será solo 1)
            // $videojuegoPrestado = $prestamosDAO->countByIdVideojuego($idVideojuego);


            // Modificar para obtener el préstamo activo(NO DEVUELTO) del videojuego
            if (!$stmt = $conn->prepare("SELECT COUNT(*) FROM prestamos WHERE idVideojuego = ? AND devuelto = 0")) {
                echo "Error en la SQL: " . $conn->error;
            }
            $stmt->bind_param("i", $idVideojuego);
            $stmt->execute();
            $stmt->bind_result($videojuegoPrestado);
            $stmt->fetch();
            $stmt->close();

    
            // Validamos los datos(modificar esto para que permita insertar los prestamos si el videojuego no tiene prestamos o el prestamo tenga el videojuego devuelto)
            if (empty($idUsuario) || empty($idVideojuego)) {
                $error = "Los campos de usuario y videojuego son obligatorios.";
            } elseif ($videojuegoPrestado > 0) {
                $error = "El videojuego ya está prestado.";
            } else {
                // Insertamos el préstamo
                $prestamo = new Prestamo();
                $prestamo->setIdUsuario($idUsuario);
                $prestamo->setIdVideojuego($idVideojuego);
                $prestamo->setFechaPrestamo($fecha_prestamo);
                $prestamo->setDevuelto($devuelto);
    
                if ($prestamosDAO->insertar($prestamo)) {
                    echo "El préstamo se ha insertado correctamente.";
                } else {
                    echo "Error al insertar el préstamo.";
                }
    
                // Redireccionamos al administrador de préstamos
                header('location: index.php?accion=ver_todos_prestamos');
                die();
            }
        }
    
        // Cargamos la vista de insertar préstamo
        require 'app/vistas/insertar_prestamo.php';
    }
    

    /* Función para cambiar el estado del prestamo de NO DEVUELTO A DEVUELTO, para poder realizar más prestamos
    y así no tener que borrar los prestamos realizados y se queden guardados en la Base de Datos y de esta forma se
    puedan visualizar en la vista de mostrarTodosPrestamos. */
    public function devolverVideojuego() {
        $error = '';
    
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $prestamosDAO = new PrestamosDAO($conn);
        $videojuegosDAO = new VideojuegosDAO($conn);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos que vienen del formulario
            $idPrestamo = htmlspecialchars($_POST['idPrestamo']); // ID del préstamo a marcar como devuelto
    
            // Validamos los datos
            if (empty($idPrestamo)) {
                $error = "El ID del préstamo es obligatorio.";
            } else {
                // Actualizamos el estado del préstamo a devuelto
                if ($prestamosDAO->marcarComoDevuelto($idPrestamo)) {
                    echo "El préstamo se ha marcado como devuelto correctamente.";
                } else {
                    echo "Error al marcar el préstamo como devuelto.";
                }
    
                // Redireccionamos al administrador de préstamos
                header('location: index.php?accion=ver_todos_prestamos');
                die();
            }
        } else {
            $error = "No se ha proporcionado un ID de préstamo válido.";
        }
    
        // Cargamos la vista de ver todos los préstamos
        require 'app/vistas/ver_todos_prestamos.php';
    }
    
    
    

}

