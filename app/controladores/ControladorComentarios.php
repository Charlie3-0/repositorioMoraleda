<?php 

class ControladorComentarios {

    /**
     * Guardar un comentario de una película por un usuario
     */
    function guardarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);
    
        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }
    
        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $comentario = trim(filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
        if (empty($comentario)) {
            echo json_encode(['respuesta' => 'comentario_vacio']);
            exit;
        }
    
        if ($peliculas_usuariosDAO->ponerComentario($idUsuario, $idPelicula, $comentario)) {
            echo json_encode([
                'respuesta' => 'ok',
                'email' => Sesion::getUsuario()->getEmail(),
                'fecha' => date('d/m/Y H:i'),
                'comentario' => $comentario
            ]);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }




   /*  public function guardarComentario()
{
    $datos = json_decode(file_get_contents('php://input'), true);
    $idPelicula = $datos['id'] ?? null;
    $comentario = $datos['comentario'] ?? null;
    $usuario = Sesion::getUsuario();

    if (!$usuario || !$idPelicula || $comentario === null) {
        echo json_encode(['respuesta' => 'error']);
        return;
    }

    require_once 'modelo/DAO/Peliculas_usuariosDAO.php';
    $dao = new Peliculas_usuariosDAO($conn);
    $dao->ponerComentario($usuario->getId(), $idPelicula, $comentario);

    echo json_encode([
        'respuesta' => 'ok',
        'comentario' => htmlspecialchars($comentario),
        'fecha_comentario' => date('Y-m-d H:i'),
        'email' => $usuario->getEmail()
    ]);
} */




    /**
     * Editar un comentario de una película por un usuario
     */
    function editarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);

        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }

        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $comentario = trim(filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (empty($comentario)) {
            echo json_encode(['respuesta' => 'comentario_vacio']);
            exit;
        }

        $resultado = $peliculas_usuariosDAO->editarComentario($idUsuario, $idPelicula, $comentario);

        if ($resultado) {
            echo json_encode([
                'respuesta' => 'ok',
                'comentario' => $comentario,
                'fecha' => date("d/m/Y H:i") // para actualizar en la vista
            ]);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }


    /**
     * Eliminar comentario de una película
     */
    function eliminarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);

        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }

        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $resultado = $peliculas_usuariosDAO->quitarComentario($idUsuario, $idPelicula);

        if ($resultado) {
            echo json_encode(['respuesta' => 'ok']);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }


    
    /* public function guardarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        if (isset($_POST['idPelicula']) && isset($_POST['comentario'])) {
            $idPelicula = $_POST['idPelicula'];
            $comentario = $_POST['comentario'];
            $fechaComentario = date('Y-m-d H:i:s');
    
            $usuario = Sesion::getUsuario();
            if (!$usuario) {
                echo json_encode(['success' => false, 'error' => 'No hay sesión activa.']);
                return;
            }
    
            $idUsuario = $usuario->getId();
    
            $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);
            $peliculas_usuariosDAO->ponerComentario($idPelicula, $idUsuario, $comentario, $fechaComentario);
    
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
        }
    } */
    
    


    
}