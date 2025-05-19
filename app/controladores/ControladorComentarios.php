<?php 

class ControladorComentarios {

    /**
     * Guardar un comentario de un videojuego
     */
    function guardarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $comentariosDAO = new ComentariosDAO($conn);
    
        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }
    
        $idUsuario = Sesion::getUsuario()->getId();
        $idVideojuego = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $comentario = trim(filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
        if (empty($comentario)) {
            echo json_encode(['respuesta' => 'comentario_vacio']);
            exit;
        }

        $idComentario = $comentariosDAO->ponerComentario($idUsuario, $idVideojuego, $comentario);
    
        if ($idComentario) {
            echo json_encode([
                'respuesta' => 'ok',
                'idComentario' => $idComentario,
                'email' => Sesion::getUsuario()->getEmail(),
                'fecha' => date('d/m/Y H:i'),
                'comentario' => $comentario
            ]);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }


    /**
     * Editar un comentario de un videojuego por un usuario
     */
    function editarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $comentariosDAO = new ComentariosDAO($conn);

        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }

        $usuario = Sesion::getUsuario();
        $idComentario = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $nuevoComentario  = trim(filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (!$idComentario || empty($nuevoComentario )) {
            echo json_encode(['respuesta' => 'datos_invalidos']);
            exit;
        }

        // Obtener el comentario de la base de datos
        $comentario = $comentariosDAO->getComentarioPorId($idComentario);

        // Comprobar si el comentario existe y si el usuario tiene permiso(solo el autor o admin pueden editar)
        if (!$comentario || ($comentario->getIdUsuario() !== $usuario->getId() && $usuario->getRol() !== 'A')) {
            echo json_encode(['respuesta' => 'no_autorizado']);
            exit;
        }

        // Ejecutar la actualización del comentario
        $resultado = $comentariosDAO->editarComentarioPorId($idComentario, $nuevoComentario);

        if ($resultado) {
            echo json_encode([
                'respuesta' => 'ok',
                'comentario' => $nuevoComentario ,
                'fecha' => date("d/m/Y H:i")
            ]);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }


    /**
     * Eliminar comentario de un videojuego
     */
    function eliminarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $comentariosDAO = new ComentariosDAO($conn);

        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }

        $usuario = Sesion::getUsuario();
        $idComentario = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idComentario) {
            echo json_encode(['respuesta' => 'error_datos']);
            exit;
        }

        // Obtener el comentario de la base de datos
        $comentario = $comentariosDAO->getComentarioPorId($idComentario);

        // Comprobar si el comentario existe y si el usuario tiene permiso(solo el autor o admin pueden eliminar)
        if (!$comentario || ($comentario->getIdUsuario() !== $usuario->getId() && $usuario->getRol() !== 'A')) {
            echo json_encode(['respuesta' => 'no_autorizado']);
            exit;
        }

        $resultado = $comentariosDAO->quitarComentario($comentario);

        if ($resultado) {
            echo json_encode(['respuesta' => 'ok']);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }
    
    

    
}