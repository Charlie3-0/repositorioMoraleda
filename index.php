<?php 

require_once 'app/config/config.php';
require_once 'app/modelos/ConnexionDB.php';
require_once 'app/modelos/Pelicula.php';
require_once 'app/modelos/PeliculasDAO.php';
require_once 'app/modelos/Usuario.php';
require_once 'app/modelos/UsuariosDAO.php';
require_once 'app/modelos/Administrador.php';
require_once 'app/modelos/AdministradoresDAO.php';
require_once 'app/modelos/Categoria.php';
require_once 'app/modelos/CategoriasDAO.php';
require_once 'app/modelos/Prestamo.php';
require_once 'app/modelos/PrestamosDAO.php';
require_once 'app/modelos/Reserva.php';
require_once 'app/modelos/ReservasDAO.php';
require_once 'app/modelos/Comentario.php';
require_once 'app/modelos/ComentariosDAO.php';
require_once 'app/modelos/Pelicula_vista.php';
require_once 'app/modelos/Peliculas_vistasDAO.php';
require_once 'app/modelos/Pelicula_usuario.php';
require_once 'app/modelos/Peliculas_usuariosDAO.php';
require_once 'app/controladores/ControladorUsuarios.php';
require_once 'app/controladores/ControladorPeliculas.php';
require_once 'app/controladores/ControladorAdministradores.php';
require_once 'app/controladores/ControladorReservas.php';
require_once 'app/controladores/ControladorPrestamos.php';
require_once 'app/controladores/ControladorComentarios.php';
require_once 'app/controladores/ControladorPeliculasVistas.php';
require_once 'app/controladores/ControladorPuntuaciones.php';

require_once 'app/utils/funciones.php';
require_once 'app/modelos/Sesion.php';

//Uso de variables de sesión
session_start();

//Mapa de enrutamiento
$mapa = array(
    'inicio'=>array('controlador'=>'ControladorPeliculas',
                    'metodo'=>'inicio',
                    'privada'=>false),
    'ver_pelicula'=>array('controlador'=>'ControladorPeliculas',
                         'metodo'=>'verPelicula', 
                         'privada'=>false),
    'insertar_pelicula'=>array('controlador'=>'ControladorPeliculas',
                                'metodo'=>'insertarPelicula',
                                'privada'=>true),
    'editar_pelicula'=>array('controlador'=>'ControladorPeliculas',
                            'metodo'=>'editarPelicula', 
                            'privada'=>true),
    'eliminar_pelicula'=>array('controlador'=>'ControladorPeliculas',
                            'metodo'=>'eliminarPelicula',
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
    'peliculas_por_categoria'=>array('controlador'=>'ControladorPeliculas',
                                    'metodo'=>'verPeliculasPorCategoria',
                                    'privada'=>false),
    'poner_reserva'=>array('controlador'=>'ControladorReservas',
                            'metodo'=>'insertarReserva',
                            'privada'=>false),
    'quitar_reserva'=>array('controlador'=>'ControladorReservas', 
                            'metodo'=>'borrarReserva',
                            'privada'=>false),
    'ver_reservas'=>array('controlador'=>'ControladorReservas',
                            'metodo'=>'verReservas',
                            'privada'=>false),
    'ver_todas_reservas'=>array('controlador'=>'ControladorReservas',
                            'metodo'=>'verTodasReservas',
                            'privada'=>false),
    'poner_prestamo'=>array('controlador'=>'ControladorPrestamos',
                            'metodo'=>'insertarPrestamo',
                            'privada'=>false),
    'devolver_pelicula'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'devolverPelicula',
                            'privada'=>false),
    'ver_prestamos'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'verPrestamos',
                            'privada'=>false),
    'ver_todos_prestamos'=>array('controlador'=>'ControladorPrestamos', 
                            'metodo'=>'verTodosPrestamos',
                            'privada'=>false),
    'poner_pelicula_vista'=>array('controlador'=>'ControladorPeliculasVistas',
                                  'metodo'=>'ponerPeliculaVista',
                                  'privada'=>false),
    'quitar_pelicula_vista'=>array('controlador'=>'ControladorPeliculasVistas', 
                                    'metodo'=>'quitarPeliculaVista',
                                    'privada'=>false),
    'ver_peliculas_vistas'=>array('controlador'=>'ControladorPeliculasVistas',
                                    'metodo'=>'verPeliculasVistas',
                                    'privada'=>false),
    'ver_todas_peliculas_vistas'=>array('controlador'=>'ControladorPeliculasVistas',
                                        'metodo'=>'verTodasPeliculasVistas',
                                        'privada'=>false),
    'guardar_puntuacion'=>array('controlador'=>'ControladorPuntuaciones',
                                'metodo'=>'guardarPuntuacion',
                                'privada'=>false),
                                        
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



