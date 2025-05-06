<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todos los Préstamos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <h2>Todas las Películas Prestadas</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($prestamos)): ?>
            <?php foreach ($prestamos as $prestamo): ?>
                <div class="prestamo">
                    <h3 class="titulo"><?= $prestamo->pelicula->getTitulo() ?></h3>
                    <p class="fecha">Fecha del Préstamo: <?= $prestamo->getFecha() ?></p>
                    <!-- Mediante el operador ternario mostramos "Película devuelta" si $prestamo->getDevuelto() devuelve true (1) y "Película NO devuelta" si devuelve false (0). -->
                    <p class="devuelto"><?= $prestamo->getDevuelta() ? "Película devuelta" : "Película NO devuelta" ?></p>
                    <strong>Película Prestada a: <?= $prestamo->usuario->getEmail() ?></strong>
                    <br><br>
                    
                    <?php if (!$prestamo->getDevuelta()): ?>
                        <form action="index.php?accion=devolver_pelicula" method="post" style="display:inline;">
                            <input type="hidden" name="idPrestamo" value="<?= $prestamo->getId() ?>">
                            <button type="submit">Devolver Película</button>
                        </form>
                    <?php endif; ?>
                    <hr>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay películas prestadas actualmente.</p>
        <?php endif; ?>

        <br>
        <a href="index.php?accion=poner_prestamo">Añadir Préstamo</a>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
    </main>
</body>
</html>