<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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

            <div id="bannerInicio" class="mb-4">
                <div class="p-5 rounded bg-body-secondary shadow-sm text-center">
                    <h1 class="tituloPagina pb-3">Bienvenido a TestPlay</h1>
                    <h3 class="mb-3">¡Explora, alquila y juega!</h3>
                    <p class="lead">Descubre cientos de videojuegos para PC disponibles por tiempo limitado.</p>
                </div>
            </div>

            <?php if (!empty($categorias)): ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 pt-3">
                    <?php foreach ($categorias as $categoria): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        <a href="index.php?accion=videojuegos_por_categoria&id=<?= $categoria->getId() ?>" class="stretched-link text-decoration-none">
                                            <?= $categoria->getNombre() ?>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="pt-3">
                    <p class="text-center">Inicia sesión para ver los Videojuegos y las Categorías.</p>
                </div>
            <?php endif; ?>
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

    <!-- SweetAlert2 para mostrar mensaje de éxito en el registro -->
    <?php if (isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Registro exitoso!',
                text: 'Ya puedes iniciar sesión.'
            });
        </script>
    <?php endif; ?>

    <script src="js.js"></script>

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
