<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos Probados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <h2>Videojuegos Probados del usuario <?= $usuario->getEmail() ?></h2>
        <?php if (!empty($videojuegosProbados)): ?>
            <?php foreach ($videojuegosProbados as $videojuegoProbado): ?>
                <div class="videojuego_probado" style="display: flex; align-items: center; gap: 20px; border: 1px solid #ccc; padding: 10px; border-radius: 10px;">
                    <div class="foto">
                        <img src="web/images/<?= $videojuegoProbado->videojuego->getFoto() ?>" style="height: 150px; border: 1px solid black; border-radius: 8px;">
                    </div>
                    <div class="info" style="display: flex; flex-direction: column;">
                        <h3 class="titulo" style="margin: 0 0 10px 0;"><?= $videojuegoProbado->videojuego->getTitulo() ?></h3>
                        <p class="fecha_probado" style="margin: 0;"><u>Videojuego probado en:</u> <?= $videojuegoProbado->getFechaProbado() ?></p>
                    </div>
                    <hr>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay videojuegos probados actualmente.</p>
        <?php endif; ?>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
    </main>
</body>
</html>