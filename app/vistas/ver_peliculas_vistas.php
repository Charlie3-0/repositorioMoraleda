<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Películas Marcadas como Vistas</title>
</head>
<body>
    <header>
        <h1 class="tituloPagina">
            <?php if (Sesion::getUsuario() && Sesion::getUsuario()->getRol() === 'A'): ?>
                CINEMA_CLICK ADMIN
            <?php else: ?>
                CINEMA_CLICK
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
                <a href="index.php?accion=ver_prestamos&id=<?=Sesion::getUsuario()->getId()?>">Ver Películas Prestadas</a>

                <br><br>
                <a href="index.php?accion=ver_reservas&id=<?=Sesion::getUsuario()->getId()?>">Ver Películas Reservadas</a>

                <br><br>
                <a href="index.php?accion=ver_peliculas_vistas&id=<?=Sesion::getUsuario()->getId()?>">Ver Películas Vistas</a>

            <?php elseif (Sesion::getUsuario()->getRol() === 'A'): ?>
                <br><br>
                <a href="index.php?accion=ver_todos_prestamos">Ver Todos los Préstamos</a>

                <br><br>
                <a href="index.php?accion=ver_todas_reservas">Ver Todas las Reservas</a>

                <br><br>
                <a href="index.php?accion=ver_todas_peliculas_vistas">Ver Todas las Películas Vistas</a>

                <br><br>
                <a href="index.php?accion=insertar_pelicula">Insertar Película</a>
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
        <h2>Películas Vistas del usuario <?= $usuario->getEmail() ?></h2>
        <?php if (!empty($peliculasVistas)): ?>
            <?php foreach ($peliculasVistas as $peliculaVista): ?>
                <div class="pelicula_vista" style="display: flex; align-items: center; gap: 20px; border: 1px solid #ccc; padding: 10px; border-radius: 10px;">
                    <div class="foto">
                        <img src="web/images/<?= $peliculaVista->pelicula->getFoto() ?>" style="height: 150px; border: 1px solid black; border-radius: 8px;">
                    </div>
                    <div class="info" style="display: flex; flex-direction: column;">
                        <h3 class="titulo" style="margin: 0 0 10px 0;"><?= $peliculaVista->pelicula->getTitulo() ?></h3>
                        <p class="fechaVista" style="margin: 0;"><u>Película visualizada en:</u> <?= $peliculaVista->getFechaVista() ?></p>
                    </div>
                    <hr>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay películas vistas actualmente.</p>
        <?php endif; ?>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
    </main>
</body>
</html>