<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos Reservados</title>
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
        <h2>Videojuegos Reservados del usuario <?= $usuario->getEmail() ?></h2>
        
        <?php if (!empty($reservas)): ?>
            <?php foreach ($reservas as $reserva): ?>
                <div class="reserva" style="display: flex; align-items: center; gap: 20px; border: 1px solid #ccc; padding: 10px; border-radius: 10px;">
                    <div class="foto">
                        <img src="web/images/<?= $reserva->videojuego->getFoto() ?>" style="height: 150px; border: 1px solid black; border-radius: 8px;">
                    </div>
                    <div class="info" style="display: flex; flex-direction: column;">
                        <h3 class="titulo" style="margin: 0 0 10px 0;">
                            <a href="index.php?accion=ver_videojuego&id=<?= $reserva->videojuego->getId() ?>">
                                <?= $reserva->videojuego->getTitulo() ?>
                            </a>
                        </h3>
                        <p class="fecha_reserva" style="margin: 0;"><u>Reservado en:</u> <?= $reserva->getFechaReserva() ?></p>
                    </div>
                    <hr>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay videojuegos reservados actualmente.</p>
        <?php endif; ?>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
    </main>
</body>
</html>