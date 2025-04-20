<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas por Categoría Administrador</title>

    <style>
        
    </style>
</head>
<body>
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
        <h2>Películas para la Categoría de <?= $categoria->getNombre() ?></h2>
        <?php foreach ($peliculas as $pelicula): ?>
            <div class="pelicula">
            <h4 class="titulo">
                    <a href="index.php?accion=ver_pelicula&id=<?=$pelicula->getId()?>"><?= $pelicula->getTitulo() ?></a>
                </h4>
            
            <div id="fotos">
                    <img src="../web/images/<?=$pelicula->getFoto()?>" alt="<?= $pelicula->getTitulo() ?>" style="height: 200px; border: 1px solid black";>                
            </div>
            
            </div>
            <hr>
        <?php endforeach; ?>
    </main>
    
    <br><br>
    <a href="index.php">Volver al listado de Categorías</a>
</body>
</html>