<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Videojuegos Probados</title>
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
        <h1 class="tituloPagina">
            <?php if (Sesion::getUsuario() && Sesion::getUsuario()->getRol() === 'A'): ?>
                TESTPLAY ADMIN
            <?php else: ?>
                TESTPLAY
            <?php endif; ?>
        </h1>

        <?php if (Sesion::getUsuario()): ?>
            <span class="emailUsuario">
                <?= Sesion::getUsuario()->getEmail() ?>
                <?php if (Sesion::getUsuario()->getRol() === 'A'): ?>
                    <strong>(ADMIN)</strong>
                <?php endif; ?>
            </span>
            <a href="index.php?accion=logout">Cerrar sesión</a>

            <?php if (Sesion::getUsuario()->getRol() === 'U'): ?>
                <br><br>
                <a href="index.php?accion=ver_prestamos&id=<?=Sesion::getUsuario()->getId()?>">Préstamos</a>

                <br><br>
                <a href="index.php?accion=ver_reservas&id=<?=Sesion::getUsuario()->getId()?>">Reservas</a>

                <br><br>
                <a href="index.php?accion=ver_videojuegos_probados&id=<?=Sesion::getUsuario()->getId()?>">Videojuegos Probados</a>

            <?php elseif (Sesion::getUsuario()->getRol() === 'A'): ?>
                <br><br>
                <a href="index.php?accion=ver_todos_prestamos">Todos los Préstamos</a>

                <br><br>
                <a href="index.php?accion=ver_todas_reservas">Todas las Reservas</a>

                <br><br>
                <a href="index.php?accion=ver_todos_videojuegos_probados">Todos los Videojuegos Probados</a>

                <br><br>
                <a href="index.php?accion=insertar_videojuego">Insertar Videojuego</a>
            <?php endif; ?>

        <?php else: ?>
            <form action="index.php?accion=login" method="post">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Login">
                <a href="index.php?accion=registrar">Registrarse</a>
            </form>
        <?php endif; ?>
    </header>

    <br><br>

    <main>
        <h2>Todos los Videojuegos Probados</h2>
        <?php if (!empty($videojuegosProbadosAgrupadosPorUsuario)): ?>
            <div class="accordion" id="accordionUsuarios">
                <?php foreach ($videojuegosProbadosAgrupadosPorUsuario as $index => $grupo): ?>
                    <?php $usuario = $grupo['usuario']; ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $index ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?= $index ?>" aria-expanded="false"
                                    aria-controls="collapse<?= $index ?>">
                                    <i class="fa-solid fa-user text-primary me-2"></i> <?= $usuario->getEmail() ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
                            aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionUsuarios">
                            <div class="accordion-body">
                                <?php foreach ($grupo['videojuegos'] as $info): ?>
                                    <div class="videojuego_probado d-flex align-items-center gap-3 border p-2 mb-2 rounded">
                                        <div class="foto">
                                            <img src="web/images/<?= $info['videojuego']->getFoto() ?>" height="100" class="border rounded">
                                        </div>
                                        <div class="info">
                                            <h5>
                                                <a href="index.php?accion=ver_videojuego&id=<?= $info['videojuego']->getId() ?>">
                                                    <?= $info['videojuego']->getTitulo() ?>
                                                </a>
                                            </h5>
                                            <p><u>Probado en:</u> <?= $info['fecha'] ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No hay videojuegos probados actualmente.</p>
        <?php endif; ?>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
    </main>
    
</body>
</html>