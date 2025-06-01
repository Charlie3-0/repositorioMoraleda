<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Préstamos</title>
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
        <a class="navbar-brand" href="index.php" required title="Inicio">
            <img src="web/icons/Logo_TestPlay.png" style="height: 200px;";>
        </a>

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

                <br><br>
                <a href="index.php?accion=sobre_nosotros">Sobre Nosotros</a>

                <br><br>
                <a href="index.php?accion=configuraciones_videojuegos"><i class="fa-solid fa-gear"></i> Configuraciones</a>
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
        <h2>Todos los Videojuegos Prestados</h2>

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


        <?php if (!empty($prestamos)): ?>
            <?php foreach ($prestamos as $prestamo): ?>
                <div class="prestamo">
                    <h3 class="titulo">
                        <a href="index.php?accion=ver_videojuego&id=<?= $prestamo->videojuego->getId() ?>">
                            <?= $prestamo->videojuego->getTitulo() ?>
                        </a>
                    </h3>
                    <p class="fecha_prestamo">Fecha del Préstamo: <?= $prestamo->getFechaPrestamo() ?></p>
                    <!-- Mediante el operador ternario mostramos "Videojuego devuelto" si $prestamo->getDevuelto() devuelve true (1) y "Videojuego NO devuelto" si devuelve false (0). -->
                    <p class="devuelto"><?= $prestamo->getDevuelto() ? "Videojuego devuelto" : "Videojuego NO devuelto" ?></p>
                    <strong>Videojuego Prestado a: <?= $prestamo->usuario->getEmail() ?></strong>
                    <br><br>
                    
                    <?php if (!$prestamo->getDevuelto()): ?>
                        <form action="index.php?accion=devolver_videojuego" method="post" style="display:inline;">
                            <input type="hidden" name="idPrestamo" value="<?= $prestamo->getId() ?>">
                            <button type="submit">Devolver Videojuego</button>
                        </form>
                    <?php endif; ?>
                    <hr>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay videojuegos prestados actualmente.</p>
        <?php endif; ?>

        <br>
        <a href="index.php?accion=poner_prestamo">Añadir Préstamo</a>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
    </main>


    <!-- Script para ocultar los mensajes -->
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