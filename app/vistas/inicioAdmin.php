<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Administrador</title>
    <link rel="stylesheet" href="web/css/estilos.css">

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

    <h1>Login de Administrador</h1>
   
    <header>
        <h1 class="tituloPagina">CINEMA_CLICK ADMIN</h1>
        <?php if(Sesion::getAdmin()): ?>
            <span class="emailAdmin"><?= Sesion::getAdmin()->getEmail() ?></span>
            <a href="index.php?accion=logoutAdmin">Cerrar Sesión Admin</a>

            <br><br>
            <a href="index.php?accion=ver_todos_prestamos">Ver Todos los Préstamos</a>

            <br><br>
            <a href="index.php?accion=ver_todas_reservas">Ver Todas las Reservas</a>

            <br><br>
            <a href="index.php?accion=ver_todas_peliculas_vistas">Ver Todas las Películas Vistas</a>

            <br><br>
            <a href="index.php?accion=insertar_pelicula">Insertar Película</a>

        <?php else: ?>
            <form action="index.php?accion=loginAdmin" method="post">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Login Administrador">
                <br><br>
                <a href="../index.php">Volver al Inicio de Usuario</a>
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