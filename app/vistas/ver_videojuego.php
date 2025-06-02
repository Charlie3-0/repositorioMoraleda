<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Videojuego</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="web/css/estilos.css">
    <link rel="icon" type="image/png" href="web/icons/favicon_TestPlay.png">
    <!-- SweetAlert2 CSS y JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-bootstrap-purple border-bottom shadow-sm px-3">
            <div class="container-fluid">
                <!-- Logo grande -->
                <a class="navbar-brand d-flex align-items-center" href="index.php" title="Inicio">
                    <img src="web/icons/favicon_TestPlay.png" alt="Logo" style="height: 70px;" class="me-2">
                </a>

                <!-- Botón toggle para móviles -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Contenido del navbar -->
                <div class="collapse navbar-collapse" id="navbarContenido">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php if (Sesion::getUsuario()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="menuUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <strong>Menú</strong>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="menuUsuario">
                                    <?php if (Sesion::getUsuario()->getRol() === 'U'): ?>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_prestamos&id=<?=Sesion::getUsuario()->getId()?>">Préstamos</a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_reservas&id=<?=Sesion::getUsuario()->getId()?>">Reservas</a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_videojuegos_probados&id=<?=Sesion::getUsuario()->getId()?>">Videojuegos Probados</a></li>
                                    <?php elseif (Sesion::getUsuario()->getRol() === 'A'): ?>
                                        <li><h6 class="dropdown-header">Gestión General</h6></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_todos_prestamos">
                                            <i class="fa-solid fa-handshake me-2"></i>Todos los Préstamos
                                        </a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_todas_reservas">
                                            <i class="fa-solid fa-calendar-check me-2"></i>Todas las Reservas
                                        </a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_todos_videojuegos_probados">
                                            <i class="fa-solid fa-gamepad me-2"></i>Todos los Videojuegos Probados
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="index.php?accion=sobre_nosotros">
                                            <i class="fa-solid fa-circle-info me-2"></i>Sobre Nosotros
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="index.php?accion=configuraciones_videojuegos">
                                            <i class="fa-solid fa-gear me-2"></i> Configuraciones
                                        </a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Lado derecho del navbar -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (Sesion::getUsuario()): ?>
                            <!-- Email y logout -->
                            <li class="nav-item d-flex align-items-center me-3 fw-semibold">
                                <?php if (Sesion::getUsuario()->getRol() === 'A'): ?>
                                    <i class="fa-solid fa-shield-halved text-warning me-2 fs-5" title="Administrador"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-user text-white me-2 fs-5"></i>
                                <?php endif; ?>
                                <?= Sesion::getUsuario()->getEmail() ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?accion=logout" title="Cerrar sesión">Cerrar sesión</a>
                            </li>
                        <?php else: ?>
                            <!-- Formulario login -->
                            <form class="d-flex" action="index.php?accion=login" method="post">
                                <input class="form-control me-2" type="email" name="email" placeholder="Email" required>
                                <input class="form-control me-2" type="password" name="password" placeholder="Password" required>
                                <button class="btn btn-light me-2" type="submit">Login</button>
                                <a class="btn btn-outline-light" href="index.php?accion=registrar">Registrarse</a>
                            </form>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <br><br>

    <main>
        <?php if (!empty($_SESSION['mensaje_ok'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['mensaje_ok'] ?>
            </div>
            <?php unset($_SESSION['mensaje_ok']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['mensaje_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['mensaje_error'] ?>
            </div>
            <?php unset($_SESSION['mensaje_error']); ?>
        <?php endif; ?>

        <div class="ver_videojuego">
            <?php if ($videojuego!= null) : ?>
                <h2 class="titulo"><?= $videojuego->getTitulo() ?> </h2>
                <div class="desarrollador">Desarrollador: <?= $videojuego->getDesarrollador() ?> </div>
                <div class="descripcion">Descripción: <?= $videojuego->getDescripcion() ?> </div>
                <div class="foto">
                    <img src="web/images/<?=$videojuego->getFoto() ?>" style="height: 300px; border: 1px solid black";>
                </div>
                <div class="nombreCategoria">Categoría: <?= $categoria->getNombre()?></div>
                <div class="fecha_lanzamiento">Fecha de lanzamiento: <?= $videojuego->getFechaLanzamiento() ?> </div>
                <br>
                <?php if (!empty($videojuego->getTrailer())): ?>
                    <div class="trailer">
                        <h3>Tráiler</h3>
                        <div class="iframe-container">
                            <iframe src="<?= $videojuego->getTrailer() ?>" class="border border-3 rounded-3" width="560" height="315" title="YouTube video trailer" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                <?php endif; ?>

                <br>

                <!-- Esto lo dejamos fuera del if, para poder usarlo en otras partes del codigo -->
                <?php
                    $daoPU = new PuntuacionesDAO($conn);
                ?>

                <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                    <?php
                        //$daoPU = new PuntuacionesDAO($conn);
                        $puntuacionUsuario = $daoPU->obtenerPuntuacionUsuario($videojuego->getId(), Sesion::getUsuario()->getId());
                    ?>
                    <div class="col-md-6">
                        <div class="rating-card p-4">
                            <h5 class="mb-4">Calificación de estrellas interactiva</h5>
                            <div class="star-rating animated-stars">
                                <?php for ($i = 10; $i >= 1; $i--): ?>
                                    <input type="radio"
                                        id="star<?= $i ?>"
                                        name="rating"
                                        value="<?= $i ?>"
                                        data-idVideojuego="<?= $videojuego->getId() ?>"
                                        <?= ($puntuacionUsuario == $i) ? 'checked' : '' ?>>
                                    <label for="star<?= $i ?>" class="bi bi-star-fill"></label>
                                <?php endfor; ?>
                            </div>
                            <p class="text-muted mt-2">Haga clic para calificar</p>
                            <div id="estadoPuntuacionContenedor">
                                <?php if ($puntuacionUsuario): ?>
                                    <strong class="estadoPuntuacion text-warning">Tu puntuación: <?= $puntuacionUsuario ?>/10</strong>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                    $mediaVideojuego = $daoPU->obtenerPuntuacionMedia($videojuego->getId());
                ?>
                <p id="mediaPuntuacion" class="mt-1">
                    <?php if ($mediaVideojuego): ?>
                        <strong>Media: <?= $mediaVideojuego ?>/10</strong>
                    <?php endif; ?>
                </p>
                
                <div id="mediaVisualEstrellas" class="star-rating disabled-stars mt-1" style="pointer-events: none;">
                    <?php for ($i = 10; $i >= 1; $i--): ?>
                        <i class="bi <?= ($mediaVideojuego >= $i) ? 'bi-star-fill text-secondary' : (($mediaVideojuego >= $i - 0.5) ? 'bi-star-half text-secondary' : 'bi-star text-secondary') ?>"></i>
                    <?php endfor; ?>
                </div>

                <p id="numeroVotos" class="text-muted small mt-1">
                    <i class="bi bi-people-fill"></i> <?= $totalVotos ?> voto<?= $totalVotos != 1 ? 's' : '' ?>
                </p>

                
                <br>

                <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                    <a href="index.php?accion=editar_videojuego&id=<?= $videojuego->getId() ?>">Editar Videojuego</a>
                <?php endif; ?>


                <br><br><br>
                

                <div id="estadoReservaContenedor">
                    <?php if ($videojuegoReservado): ?>
                        <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                            <?php if ($usuarioReservado): ?>
                                <strong class="estadoReservado text-dark">
                                    Videojuego Reservado
                                    <i>por: <?= $usuarioReservado->getEmail() ?></i>
                                </strong>
                            <?php else: ?>
                                <strong class="text-dark">Videojuego disponible para Reserva</strong>
                            <?php endif; ?>
                        <?php elseif (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                            <strong class="estadoReservado text-dark">Videojuego Reservado</strong>
                        <?php endif; ?>
                    <?php else: ?>
                        <strong class="text-dark">Videojuego disponible para Reserva</strong>
                    <?php endif; ?>
                </div>


                
                <br>

                <div id="estadoPrestamoContenedor">
                    <?php if ($videojuegoPrestado): ?>
                        <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                            <?php if ($usuarioPrestamo != null): ?>
                                <strong class="estadoPrestado text-dark">Videojuego Prestado
                                    <i>a: <?= $usuarioPrestamo->getEmail() ?></i>
                                </strong>
                            <?php else: ?>
                                <strong class="text-dark">Videojuego Disponible para ser Prestado</strong>
                            <?php endif; ?>
                        <?php elseif (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                            <strong class="estadoPrestado text-dark">Videojuego Prestado</strong>
                        <?php endif; ?>
                    <?php else: ?>
                        <strong class="text-dark">Videojuego Disponible para ser Prestado</strong>
                    <?php endif; ?>
                </div>


                <br>
                
                <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                    <div id="estadoProbadoContenedor">
                        <?php if ($marcadoProbado): ?>
                            <strong class="estadoProbado text-success">Videojuego Probado</strong>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            <?php else : ?>
                <strong class="alert alert-warning" role="alert">Videojuego con id <?= $id ?> no encontrado</strong>
            <?php endif; ?>


            <br><br>
            <!-- Permitimos a los usuarios con rol "U" gestionar reservas de videojuegos si hay una sesión activa. Si
            el videojuego no está reservado o la reserva es del usuario conectado, se muestra un botón para "Quitar Reserva"
            o "Poner Reserva", según corresponda. -->
            <?php if(Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U' && ( !$videojuegoReservado || $existeReserva )): ?>
                <?php if($existeReserva): ?>
                    <button class="quitarReserva" data-idVideojuego="<?= $videojuego->getId()?>" id="botonReserva">Quitar Reserva</button>
                <?php else: ?>
                    <button class="ponerReserva" data-idVideojuego="<?= $videojuego->getId()?>" id="botonReserva">Poner Reserva</button>
                <?php endif; ?>
                
            <?php endif; ?>

            <br><br>

            <!-- Verificamos si hay una sesión activa con un usuario que tiene el rol "U". Si es así, permite
            al usuario marcar un videojuego como "probado" o "no probado" haciendo clic en el icono. -->
            <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                <span class="estado-probado">
                    <?php if ($marcadoProbado): ?>
                        <i id="botonProbado"
                        class="fas fa-gamepad quitarProbado icono-probado"
                        data-idVideojuego="<?= $videojuego->getId() ?>"
                        style="cursor: pointer; font-size: 1.5rem;"
                        title="Desmarcar probado"></i>
                    <?php else: ?>
                        <i id="botonProbado"
                        class="fas fa-circle-xmark ponerProbado icono-no-probado"
                        data-idVideojuego="<?= $videojuego->getId() ?>"
                        style="cursor: pointer; font-size: 1.5rem;"
                        title="Marcar como probado"></i>
                    <?php endif; ?>
                    
                    <!-- Siempre se muestra este span junto al icono al marcar el probado o si ya estaba
                    marcado como probado -->
                    <span class="texto-probado<?= $marcadoProbado ? '' : ' oculto' ?>">
                        <i class="fas fa-check-circle icono-confirmacion"></i> Probado
                    </span>
                </span>
            <?php endif; ?>

            <br><br>

            <!-- Sección de comentarios -->
            <div class="container mt-5">
                <div class="comment-section" id="tituloComentarios">
                    <h4 class="text-center"><span></span> Comentarios</h4>
                </div>
            </div>
            <hr>

            
            <?php if (Sesion::existeSesion()): ?>
                <div class="container mt-5">
                    <div class="comment-section" id="insertarComentario">
                        <!-- Formulario para comentar -->
                        <form id="formComentario" class="mb-4" data-idVideojuego="<?= $videojuego->getId(); ?>">
                            <div class="d-flex gap-3">
                                <!-- Avatar del usuario -->
                                <?php if (Sesion::getUsuario()->getRol() === 'A'): ?>
                                    <i class="fa-solid fa-shield-halved text-warning" title="Administrador"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-user text-primary"></i>
                                <?php endif; ?>
                                <span class="emailUsuario"><?= Sesion::getUsuario()->getEmail(); ?></span>
                                <div class="flex-grow-1">
                                    <textarea id="comentarioTexto" class="form-control comment-input" rows="3" placeholder="Escribe un comentario..."></textarea>
                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-comment text-white">Publicar Comentario</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Lista de comentarios -->
            <div class="container" data-idVideojuego="<?= $videojuego->getId(); ?>">
                <div class="comment-section" id="listaComentarios">
                    <?php if (!empty($comentarios)): ?>
                        <?php foreach ($comentarios as $comentario): ?>
                            <div class="comment-box mb-3" data-idComentario="<?= $comentario->id ?>">
                                <div class="d-flex gap-3">
                                    <!-- Avatar del usuario -->
                                    <?php if ($comentario->rol === 'A'): ?>
                                        <i class="fa-solid fa-shield-halved text-warning" title="Administrador"></i>
                                    <?php else: ?>
                                        <i class="fa-solid fa-user text-primary"></i>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0"><?= $comentario->email ?? 'Anónimo' ?></h6>
                                            <span class="comment-time" data-fecha="<?= $comentario->fecha_comentario ?>">
                                                <?= isset($comentario->fecha_comentario) ? date("c", strtotime($comentario->fecha_comentario)) : 'Sin fecha' ?>
                                            </span>

                                        </div>

                                        <!-- Texto del comentario -->
                                    <!--    <p class="mb-2"><?= nl2br($comentario->comentario) ?></p>-->

                                        <p class="mb-2" data-texto="<?= $comentario->comentario ?>">
                                            <?= nl2br($comentario->comentario) ?>
                                        </p>


                                        <!-- Mostrar botones solo si es el autor o un administrador -->
                                        <?php if (
                                            Sesion::existeSesion() && (
                                                Sesion::getUsuario()->getEmail() === $comentario->email ||
                                                Sesion::getUsuario()->getRol() === 'A'
                                            )
                                        ): ?>
                                            <div class="comment-actions">
                                                <a href="#" class="editar-comentario text-primary" data-id="<?= $comentario->id ?>">Editar</a>
                                                <a href="#" class="eliminar-comentario text-danger" data-id="<?= $comentario->id ?>">Eliminar</a>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="sin-comentarios">No hay comentarios aún. Sé el primero en comentar.</p>
                    <?php endif; ?>
                </div>
            </div>



            


            <br><br>
            <a href="index.php?accion=videojuegos_por_categoria&id=<?=$categoria->getId()?>">Volver a la Categoría <?= $categoria->getNombre() ?></a>
        </div>
    </main>
    

    <script src="js.js"></script>

    <script>
        const usuarioEmail = "<?= Sesion::existeSesion() ? Sesion::getUsuario()->getEmail() : '' ?>";
    </script>

    <script>
        setTimeout(() => {
            const success = document.querySelector('.alert-success');
            const error = document.querySelector('.alert-danger');

            if (success) success.remove();
            if (error) error.remove();
        }, 3000);
    </script>

</body>
</html>

