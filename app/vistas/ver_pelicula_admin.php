<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pelicula Administrador</title>

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
            
            <!--    <br><br>
                <a href="../index.php">Volver al Inicio de Usuario</a>
            </form>
            -->
        <?php endif; ?>
    </header>

    <br><br>

    <main>
        <div class="ver_pelicula">
            <?php if ($pelicula!= null) : ?>
                <h2 class="titulo"><?= $pelicula->getTitulo() ?> </h2>
                <div class="director">Director: <?= $pelicula->getDirector() ?> </div>
                <div class="descripcion">Descripción: <?= $pelicula->getDescripcion() ?> </div>
                <div class="foto">
                    <img src="../web/images/<?=$pelicula->getFoto() ?>" style="height: 300px; border: 1px solid black";>
                </div>
                <div class="nombreCategoria">Categoría: <?= $categoria->getNombre()?></div>

                <br>

                <?php if(Sesion::existeSesionAdmin()): ?>
                    <a href="index.php?accion=editar_pelicula&id=<?= $pelicula->getId() ?>">Editar Película</a>
                <?php endif; ?>

                <br><br>

                <div id="estadoReservaContenedor">
                    <?php if ($peliculaReservada): ?>
                        <strong class="estadoReservado text-warning">Película Reservada
                            <?php if ($usuarioReservado): ?>
                                <i>por: <?= $usuarioReservado->getEmail() ?></i>
                            <?php endif; ?>
                        </strong>
                    <?php endif; ?>
                </div>
                
                <br>

                <div>
                    <?php if($peliculaPrestada): ?>
                        <?php if ($usuarioPrestamo != null): ?>
                            <strong class="estadoPrestado text-warning">Película Prestada
                                <i>a: <?= $usuarioPrestamo->getEmail() ?></i>
                            </strong>
                        <?php else: ?>
                            <strong class="text-warning">Película Disponible para ser Prestada</strong>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <strong class="alert alert-warning" role="alert">Pelicula con id <?= $id ?> no encontrada</strong>
            <?php endif; ?>

            <br><br>
            <!-- Aquí indicamos si existe Sesion, si la pelicula no está Reservada o si la Reserva es mía(del usuario que está logeado)
            entonces se puede si existe reserva quitarla o sino existe ponerla. -->
            <?php if(Sesion::existeSesion() && ( !$peliculaReservada || $existeReserva )): ?>
                <?php if($existeReserva): ?>
                    <button class="quitarReserva" data-idPelicula="<?= $pelicula->getId()?>" id="botonReserva">Quitar Reserva</button>
                <?php else: ?>
                    <button class="ponerReserva" data-idPelicula="<?= $pelicula->getId()?>" id="botonReserva">Poner Reserva</button>
                <?php endif; ?>
                
            <?php endif; ?>

            <br>
            <a href="index.php?accion=peliculas_por_categoria&id=<?=$categoria->getId()?>">Volver a la Categoría <?= $categoria->getNombre() ?></a>
        </div>
    </main>
    

    <script src="js.js"></script>

</body>
</html>