<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Préstamo</title>
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
        <h2>Añadir Préstamo</h2>
        <?php if (!empty($error)): ?>
            <div class="error">
                <p style="color: red;"><?= $error ?></p>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=poner_prestamo" method="post">
            <label for="idUsuario">Usuario: </label>
            <select name="idUsuario" id="idUsuario">
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario->getId() ?>"><?= $usuario->getEmail() ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="idPelicula">Película: </label>
            <select name="idPelicula" id="idPelicula">
                <?php foreach ($peliculas as $pelicula): ?>
                    <option value="<?= $pelicula->getId() ?>"><?= $pelicula->getTitulo() ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <br>
            <input type="submit" value="Insertar Préstamo">
        </form>

        <br>
        <a href="index.php?accion=ver_todos_prestamos">Volver Atrás</a>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var errorMessage = document.querySelector('.error');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            }, 3000);
        });
    </script>
</body>
</html>