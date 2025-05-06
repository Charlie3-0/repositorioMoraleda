<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="web/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .error-message {
            background-color: #ffdddd;
            color: #d8000c;
            border: 1px solid #d8000c;
            padding: 15px;
            margin: 20px auto;
            text-align: center;
            max-width: 500px;
            border-radius: 15px;
            font-weight: bold;
            box-shadow: 0px 0px 10px rgba(216, 0, 12, 0.5);
        }

    </style>
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
    <?php $mensajeError = imprimirMensaje(); ?>
    <?php if ($mensajeError): ?>
        <div class="error-message">
            <h4><?= $mensajeError ?></h4>
        </div>
    <?php endif; ?>

    
    <?php if (!empty($categorias)): ?>
        <h2>Categorías</h2>
        <?php foreach ($categorias as $categoria): ?>
            <div class="categoria">
            <h4 class="titulo">
                    <a href="index.php?accion=peliculas_por_categoria&id=<?=$categoria->getId()?>"><?= $categoria->getNombre() ?></a>
                </h4>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Inicia sesión para ver las Categorías.</p>
    <?php endif; ?>
    
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var errorMessage = document.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            }, 3000);
        });
    </script>
</body>
</html>
