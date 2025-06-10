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
    <link rel="icon" type="image/png" href="web/icons/TestPlay-icon.png">
    <!-- SweetAlert2 CSS y JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-bootstrap-purple border-bottom shadow-sm px-3">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="index.php" title="Inicio">
                    <img src="web/icons/TestPlay-icon.png" alt="Logo" style="height: 70px;" class="me-2">
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
                                        <li><a class="dropdown-item" href="index.php?accion=ver_prestamos&id=<?=Sesion::getUsuario()->getId()?>">
                                            <i class="fa-solid fa-handshake me-2"></i>Préstamos
                                        </a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_reservas&id=<?=Sesion::getUsuario()->getId()?>">
                                            <i class="fa-solid fa-calendar-check me-2"></i>Reservas
                                        </a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_videojuegos_probados&id=<?=Sesion::getUsuario()->getId()?>">
                                            <i class="fa-solid fa-gamepad me-2"></i>Videojuegos Probados
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="index.php?accion=sobre_nosotros">
                                            <i class="fa-solid fa-circle-info me-2"></i>Sobre Nosotros
                                        </a></li>
                                    <?php elseif (Sesion::getUsuario()->getRol() === 'A'): ?>
                                        <li>
                                            <h6 class="dropdown-header">Gestión General</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_todos_prestamos">
                                                <i class="fa-solid fa-handshake me-2"></i>Todos los Préstamos
                                            </a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_todas_reservas">
                                                <i class="fa-solid fa-calendar-check me-2"></i>Todas las Reservas
                                            </a></li>
                                        <li><a class="dropdown-item" href="index.php?accion=ver_todos_videojuegos_probados">
                                                <i class="fa-solid fa-gamepad me-2"></i>Todos los Videojuegos Probados
                                            </a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="index.php?accion=sobre_nosotros">
                                                <i class="fa-solid fa-circle-info me-2"></i>Sobre Nosotros
                                            </a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
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
                            <!-- Buscador de videojuegos -->
                            <li class="nav-item position-relative me-5 mb-3 mb-lg-0">
                                <input type="text" class="form-control" id="buscador-videojuegos" placeholder="Buscar videojuegos..." autocomplete="off">
                                <ul id="sugerencias-videojuegos" class="list-group position-absolute w-100" style="z-index: 999;"></ul>
                            </li>
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
                            <form class="d-flex mb-3 mb-lg-0" action="index.php?accion=login" method="post">
                                <input class="form-control me-2" type="email" name="email" placeholder="Email" required>
                                <input class="form-control me-2" type="password" name="password" placeholder="Password" required>
                                <button class="btn btn-light me-2" type="submit">Login</button>
                                <a class="btn btn-outline-light" href="index.php?accion=registrar">Registrarse</a>
                            </form>
                        <?php endif; ?>
                        <li>
                            <!-- BOTÓN MODO CLARO/OSCURO -->
                            <button id="themeToggle" class="btn btn-outline-light ms-3" aria-label="Cambiar tema">
                                <i class="fa-solid fa-moon" id="themeIcon"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div id="mainWrapper" class="bg-light text-dark">
        <main id="mainContent" class="container py-5">
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
                <?php if ($videojuego != null) : ?>
                    <h2 class="titulo text-center my-4"><?= $videojuego->getTitulo() ?> </h2>

                    <div class="container mb-5">
                        <div class="card shadow-sm p-3 bg-body-tertiary rounded no-hover">
                            <div class="row g-4 align-items-start">
                                <!-- Imagen -->
                                <div class="col-md-4 text-center">
                                    <img src="web/images/<?= $videojuego->getFoto() ?>" class="img-fluid rounded border" alt="Carátula del videojuego">
                                </div>

                                <!-- Info -->
                                <div class="col-md-8">
                                    <div class="mb-3"><strong>Desarrollador:</strong> <?= $videojuego->getDesarrollador() ?></div>
                                    <div class="mb-3"><strong>Descripción:</strong> <?= $videojuego->getDescripcion() ?></div>
                                    <div class="mb-3"><strong>Categoría:</strong> <?= $categoria->getNombre() ?></div>
                                    <div class="mb-3"><strong>Fecha de lanzamiento:</strong> <?= $videojuego->getFechaLanzamiento() ?></div>

                                    <?php
                                    $daoPU = new PuntuacionesDAO($conn);
                                    $mediaVideojuego = $daoPU->obtenerPuntuacionMedia($videojuego->getId());
                                    ?>

                                    <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                                        <?php $puntuacionUsuario = $daoPU->obtenerPuntuacionUsuario($videojuego->getId(), Sesion::getUsuario()->getId()); ?>
                                        <div class="rating-card p-3 border rounded bg-rating-light bg-rating-dark mb-3">
                                            <h5 class="mb-3">Calificación de estrellas</h5>
                                            <div class="star-rating animated-stars mb-1">
                                                <?php for ($i = 10; $i >= 1; $i--): ?>
                                                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>"
                                                        data-idVideojuego="<?= $videojuego->getId() ?>" <?= ($puntuacionUsuario == $i) ? 'checked' : '' ?>>
                                                    <label for="star<?= $i ?>" class="bi bi-star-fill"></label>
                                                <?php endfor; ?>
                                            </div>
                                            <p class="text-muted">Haz clic para calificar</p>
                                            <div id="estadoPuntuacionContenedor">
                                                <?php if ($puntuacionUsuario): ?>
                                                    <strong class="estadoPuntuacion text-warning">Tu puntuación: <?= $puntuacionUsuario ?>/10</strong>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <p id="mediaPuntuacion" class="mt-2">
                                        <?php if ($mediaVideojuego): ?>
                                            <strong>Media: <?= $mediaVideojuego ?>/10</strong>
                                        <?php endif; ?>
                                    </p>

                                    <div id="mediaVisualEstrellas" class="star-rating disabled-stars" style="pointer-events: none;">
                                        <?php for ($i = 10; $i >= 1; $i--): ?>
                                            <i class="bi <?= ($mediaVideojuego >= $i) ? 'bi-star-fill text-secondary' : (($mediaVideojuego >= $i - 0.5) ? 'bi-star-half text-secondary' : 'bi-star text-secondary') ?>"></i>
                                        <?php endfor; ?>
                                    </div>

                                    <p id="numeroVotos" class="text-muted small mt-1">
                                        <i class="bi bi-people-fill"></i> <?= $totalVotos ?> voto<?= $totalVotos != 1 ? 's' : '' ?>
                                    </p>

                                    <!-- Estado de reserva y préstamo -->
                                    <div id="estadoReservaContenedor" class="mt-3">
                                        <?php if ($videojuegoReservado): ?>
                                            <?php if (Sesion::getUsuario()->getRol() === 'A' && $usuarioReservado): ?>
                                                <strong class="estadoReservado text-warning">Reservado por: <i><?= $usuarioReservado->getEmail() ?></i></strong>
                                            <?php else: ?>
                                                <strong class="estadoReservado text-warning">Videojuego Reservado</strong>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <strong class="text-success">Disponible para Reserva</strong>
                                        <?php endif; ?>
                                    </div>

                                    <div id="estadoPrestamoContenedor" class="mt-3">
                                        <?php if ($videojuegoPrestado): ?>
                                            <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                                                <?php if ($usuarioPrestamo != null): ?>
                                                    <strong class="estadoPrestado text-warning">Videojuego Prestado
                                                        <i>a: <?= $usuarioPrestamo->getEmail() ?></i>
                                                    </strong>
                                                <?php else: ?>
                                                    <strong class="text-success">Disponible para Préstamo</strong>
                                                <?php endif; ?>
                                            <?php elseif (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                                                <?php if ($usuarioPrestamo != null): ?>
                                                    <strong class="estadoPrestado text-warning">Videojuego Prestado</strong>
                                                <?php else: ?>
                                                    <strong class="text-success">Disponible para Préstamo</strong>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <strong class="text-success">Disponible para Préstamo</strong>
                                        <?php endif; ?>
                                    </div>


                                    <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                                        <div id="estadoProbadoContenedor" class="mt-3">
                                            <?php if ($marcadoProbado): ?>
                                                <strong class="estadoProbado text-success">Videojuego Probado</strong>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Botones reserva / probado -->
                                        <?php if (!$videojuegoReservado || $existeReserva): ?>
                                            <div class="mt-3">
                                                <?php if ($existeReserva): ?>
                                                    <button class="quitarReserva btn btn-warning" data-idVideojuego="<?= $videojuego->getId() ?>" id="botonReserva">Quitar Reserva</button>
                                                <?php else: ?>
                                                    <button class="ponerReserva btn btn-warning" data-idVideojuego="<?= $videojuego->getId() ?>" id="botonReserva">Poner Reserva</button>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-3 estado-probado">
                                            <?php if ($marcadoProbado): ?>
                                                <i id="botonProbado" class="fas fa-gamepad quitarProbado icono-probado"
                                                    data-idVideojuego="<?= $videojuego->getId() ?>" style="cursor: pointer; font-size: 2.0rem;"
                                                    title="Desmarcar probado"></i>
                                            <?php else: ?>
                                                <i id="botonProbado" class="fas fa-circle-xmark ponerProbado icono-no-probado"
                                                    data-idVideojuego="<?= $videojuego->getId() ?>" style="cursor: pointer; font-size: 2.0rem;"
                                                    title="Marcar como probado"></i>
                                            <?php endif; ?>
                                            <span class="texto-probado text-success<?= $marcadoProbado ? '' : ' oculto' ?>">
                                                <i class="fas fa-check-circle icono-confirmacion" style="font-size: 1.5rem;"></i>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón editar -->
                    <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                        <div class="text-center mb-5">
                            <a href="index.php?accion=editar_videojuego&id=<?= $videojuego->getId() ?>" class="btn btn-warning">Editar Videojuego</a>
                        </div>
                    <?php endif; ?>

                    <!-- Tráiler debajo -->
                    <?php if (!empty($videojuego->getTrailer())): ?>
                        <div class="container text-center mb-5">
                            <h3 class="mb-3">Tráiler</h3>
                            <div class="ratio ratio-16x9">
                                <iframe src="<?= $videojuego->getTrailer() ?>" class="border border-3 rounded-3"
                                    title="YouTube video trailer" frameborder="0"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <strong class="alert alert-warning d-block text-center" role="alert">
                        Videojuego con id <?= $id ?> no encontrado
                    </strong>
                <?php endif; ?>


                <!-- Sección de comentarios -->
                <div class="container mt-5">
                    <div class="comment-section comment-card" id="tituloComentarios">
                        <h4 class="text-center"><span></span> Comentarios</h4>
                    </div>
                </div>
                <hr>

                <?php if (Sesion::existeSesion()): ?>
                    <div class="container mt-5">
                        <div class="comment-section comment-card border" id="insertarComentario">
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
                                <div class="comment-box comment-card border" data-idComentario="<?= $comentario->id ?>">
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
                                            <p class="my-3" data-texto="<?= $comentario->comentario ?>">
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

                <div class="text-center mt-5">
                    <a href="index.php?accion=videojuegos_por_categoria&id=<?= $categoria->getId() ?>" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Volver a la Categoría <?= $categoria->getNombre() ?>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <div id="footerWrapper" class="bg-footer-light text-dark">
        <footer id="footerContent" class="container py-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h6 class="fw-bold">Sobre TestPlay</h6>
                    <p class="mb-0">Alquiler temporal de videojuegos para PC. Explora títulos únicos y conocidos.</p>
                </div>

                <div class="col-md-6 text-center text-md-end">
                    <div class="mb-2 fs-4">
                        <a href="https://www.facebook.com/" target="_blank" class="text-reset me-3"><i class="bi bi-facebook"></i></a>
                        <a href="https://x.com/" target="_blank" class="text-reset me-3"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" class="text-reset me-3"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/" target="_blank" class="text-reset"><i class="bi bi-youtube"></i></a>
                    </div>
                    <p class="mb-0 small">&copy; 2025 TestPlay. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>

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