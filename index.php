<?php 

require_once 'app/config/config.php';
require_once 'app/modelos/ConnexionDB.php';
require_once 'app/modelos/Videojuego.php';
require_once 'app/modelos/VideojuegosDAO.php';
require_once 'app/modelos/Usuario.php';
require_once 'app/modelos/UsuariosDAO.php';
require_once 'app/modelos/Categoria.php';
require_once 'app/modelos/CategoriasDAO.php';
require_once 'app/modelos/Prestamo.php';
require_once 'app/modelos/PrestamosDAO.php';
require_once 'app/modelos/Reserva.php';
require_once 'app/modelos/ReservasDAO.php';
require_once 'app/modelos/Comentario.php';
require_once 'app/modelos/ComentariosDAO.php';
require_once 'app/modelos/Videojuego_probado.php';
require_once 'app/modelos/Videojuegos_probadosDAO.php';
require_once 'app/modelos/Puntuacion.php';
require_once 'app/modelos/PuntuacionesDAO.php';
require_once 'app/controladores/ControladorUsuarios.php';
require_once 'app/controladores/ControladorVideojuegos.php';
require_once 'app/controladores/ControladorReservas.php';
require_once 'app/controladores/ControladorPrestamos.php';
require_once 'app/controladores/ControladorComentarios.php';
require_once 'app/controladores/ControladorVideojuegosProbados.php';
require_once 'app/controladores/ControladorPuntuaciones.php';

require_once 'app/utils/funciones.php';
require_once 'app/modelos/Sesion.php';

//Uso de variables de sesión
session_start();

//Mapa de enrutamiento
$mapa = array(
    'inicio'=>array('controlador'=>'ControladorVideojuegos',
                    'metodo'=>'inicio',
                    'privada'=>false),
    'ver_videojuego'=>array('controlador'=>'ControladorVideojuegos',
                         'metodo'=>'verVideojuego', 
                         'privada'=>false),
    'insertar_videojuego'=>array('controlador'=>'ControladorVideojuegos',
                                'metodo'=>'insertarVideojuego',
                                'privada'=>true),
    'editar_videojuego'=>array('controlador'=>'ControladorVideojuegos',
                            'metodo'=>'editarVideojuego', 
                            'privada'=>true),
    'eliminar_videojuego'=>array('controlador'=>'ControladorVideojuegos',
                            'metodo'=>'eliminarVideojuego',
                            'privada'=>true),
    'login'=>array('controlador'=>'ControladorUsuarios', 
                   'metodo'=>'login', 
                   'privada'=>false),
    'logout'=>array('controlador'=>'ControladorUsuarios', 
                    'metodo'=>'logout', 
                    'privada'=>true),
    'registrar'=>array('controlador'=>'ControladorUsuarios', 
                       'metodo'=>'registrar', 
                       'privada'=>false),
    'cambiar_rol_usuario'=>array('controlador'=>'ControladorUsuarios',
                            'metodo'=>'cambiarRolUsuario',
                            'privada'=>true),
    'videojuegos_por_categoria'=>array('controlador'=>'ControladorVideojuegos',
                                    'metodo'=>'verVideojuegosPorCategoria',
                                    'privada'=>false),
    'poner_reserva'=>array('controlador'=>'ControladorReservas',
                            'metodo'=>'insertarReserva',
                            'privada'=>false),
    'quitar_reserva'=>array('controlador'=>'ControladorReservas', 
                            'metodo'=>'borrarReserva',
                            'privada'=>false),
    'quitar_reserva_admin'=>array('controlador'=>'ControladorReservas', 
                            'metodo'=>'quitarReservaAdmin',
                            'privada'=>true),
    'ver_reservas'=>array('controlador'=>'ControladorReservas',
                            'metodo'=>'verReservas',
                            'privada'=>false),
    'ver_todas_reservas'=>array('controlador'=>'ControladorReservas',
                            'metodo'=>'verTodasReservas',
                            'privada'=>false),
    'poner_prestamo'=>array('controlador'=>'ControladorPrestamos',
                            'metodo'=>'insertarPrestamo',
                            'privada'=>false),
    'devolver_videojuego'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'devolverVideojuego',
                            'privada'=>false),
    'devolver_prestamo_admin'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'devolverPrestamoAdmin',
                            'privada'=>true),
    'ver_prestamos'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'verPrestamos',
                            'privada'=>false),
    'ver_todos_prestamos'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'verTodosPrestamos',
                            'privada'=>false),
    'poner_videojuego_probado'=>array('controlador'=>'ControladorVideojuegosProbados',
                                  'metodo'=>'ponerVideojuegoProbado',
                                  'privada'=>false),
    'quitar_videojuego_probado'=>array('controlador'=>'ControladorVideojuegosProbados', 
                                    'metodo'=>'quitarVideojuegoProbado',
                                    'privada'=>false),
    'ver_videojuegos_probados'=>array('controlador'=>'ControladorVideojuegosProbados',
                                    'metodo'=>'verVideojuegosProbados',
                                    'privada'=>false),
    'ver_todos_videojuegos_probados'=>array('controlador'=>'ControladorVideojuegosProbados',
                                        'metodo'=>'verTodosVideojuegosProbados',
                                        'privada'=>false),
    'guardar_puntuacion'=>array('controlador'=>'ControladorPuntuaciones',
                                'metodo'=>'guardarPuntuacion',
                                'privada'=>false),
    'guardar_comentario'=>array('controlador'=>'ControladorComentarios',
                                'metodo'=>'guardarComentario',
                                'privada'=>false),
    'editar_comentario'=>array('controlador'=>'ControladorComentarios',
                                'metodo'=>'editarComentario',
                                'privada'=>false),
    'eliminar_comentario'=>array('controlador'=>'ControladorComentarios',
                                'metodo'=>'eliminarComentario',
                                'privada'=>false),
    'configuraciones_videojuegos'=>array('controlador'=>'ControladorVideojuegos',
                         'metodo'=>'configuracionesVideojuegos', 
                         'privada'=>false),
    'sobre_nosotros'=>array('controlador'=>'ControladorUsuarios',
                         'metodo'=>'sobreNosotros', 
                         'privada'=>false)                              
);


//Parseo de la ruta
if(isset($_GET['accion'])){ //Compruebo si me han pasado una acción concreta, sino pongo la accción por defecto inicio
    if(isset($mapa[$_GET['accion']])){  //Compruebo si la accción existe en el mapa, sino muestro error 404
        $accion = $_GET['accion']; 
    }
    else{
        //La acción no existe
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
}else{
    $accion='inicio';   //Acción por defecto
}


//Si la acción es privada compruebo que ha iniciado sesión, sino, lo echamos a index
if(!Sesion::existeSesion() && $mapa[$accion]['privada']){
    header('location: index.php');
    guardarMensaje("Debes iniciar sesión para acceder a $accion");
    die();
}


//$acción ya tiene la acción a ejecutar, cogemos el controlador y metodo a ejecutar del mapa
$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];

$objeto = new $controlador();
$objeto->$metodo();



