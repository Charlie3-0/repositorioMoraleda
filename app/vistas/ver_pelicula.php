<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pelicula</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Colores personalizados */
        .icono-visto {
            color: black;
        }

        .icono-no-visto {
            color: gray;
        }

        /* Animación rápida al hacer clic */
        .icono-animado {
            animation: rebote 0.4s ease;
        }

        @keyframes rebote {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }

        .estado-vista {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }

        .texto-visto {
            font-size: 1em;
            color: black; /* mismo tono que icono-visto */
            font-weight: bold;
            margin-left: 8px;
            display: inline-block;

            opacity: 1;
            visibility: visible;
            /* transition: opacity 0.7s ease, visibility 0.7s ease; */

            transform: translateY(0);
            transition: opacity 0.7s ease, visibility 0.7s ease, transform 0.7s ease;
        }

        .texto-visto.oculto {
            opacity: 0;
            visibility: hidden;

            transform: translateY(-5px);
        }

        .icono-confirmacion {
            margin-right: 4px;
            color: #28a745;
        }

        
        /* Estilos puntuaciones */
        .star-rating {
            direction: rtl;
            display: inline-block;
            cursor: pointer;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            font-size: 24px;
            padding: 0 2px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: #ffc107;
        }


        .disabled-stars i {
            font-size: 1.3rem;
            margin-right: 2px;
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
        <div class="ver_pelicula">
            <?php if ($pelicula!= null) : ?>
                <h2 class="titulo"><?= $pelicula->getTitulo() ?> </h2>
                <div class="director">Director: <?= $pelicula->getDirector() ?> </div>
                <div class="descripcion">Descripción: <?= $pelicula->getDescripcion() ?> </div>
                <div class="foto">
                    <img src="web/images/<?=$pelicula->getFoto() ?>" style="height: 300px; border: 1px solid black";>
                </div>
                <div class="nombreCategoria">Categoría: <?= $categoria->getNombre()?></div>

                <br>

            <!--    <div class="col-md-6">
                    <div class="rating-card p-4">
                        <h5 class="mb-4">Calificación de estrellas interactiva</h5>
                        <div class="star-rating animated-stars">
                            <input type="radio" id="star10" name="rating" value="10">
                            <label for="star10" class="bi bi-star-fill"></label>
                            <input type="radio" id="star9" name="rating" value="9">
                            <label for="star9" class="bi bi-star-fill"></label>
                            <input type="radio" id="star8" name="rating" value="8">
                            <label for="star8" class="bi bi-star-fill"></label>
                            <input type="radio" id="star7" name="rating" value="7">
                            <label for="star7" class="bi bi-star-fill"></label>
                            <input type="radio" id="star6" name="rating" value="6">
                            <label for="star6" class="bi bi-star-fill"></label>
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5" class="bi bi-star-fill"></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4" class="bi bi-star-fill"></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3" class="bi bi-star-fill"></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2" class="bi bi-star-fill"></label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1" class="bi bi-star-fill"></label>
                        </div>
                        <p class="text-muted mt-2">Haga clic para calificar</p>
                    </div>
                </div>
            -->

                <!-- Esto lo dejamos fuera del if, para poder usarlo en otras partes del codigo -->
                <?php
                    $daoPU = new Peliculas_usuariosDAO($conn);
                ?>

                <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                    <?php
                        //$daoPU = new Peliculas_usuariosDAO($conn);
                        $puntuacionUsuario = $daoPU->obtenerPuntuacionUsuario($pelicula->getId(), Sesion::getUsuario()->getId());
                    ?>
                    <div class="col-md-6">
                        <div class="rating-card p-4">
                            <h5 class="mb-4">Calificación de estrellas interactiva</h5>
                            <div class="star-rating animated-stars">
                                <?php for ($i = 10; $i >= 1; $i--): ?>
                                    <input type="radio"
                                        id="star<?= $i ?>"
                                        name="rating"
                                        value="<?= $i ?>"
                                        data-idPelicula="<?= $pelicula->getId() ?>"
                                        <?= ($puntuacionUsuario == $i) ? 'checked' : '' ?>>
                                    <label for="star<?= $i ?>" class="bi bi-star-fill"></label>
                                <?php endfor; ?>
                            </div>
                            <p class="text-muted mt-2">Haga clic para calificar</p>
                            <div id="estadoPuntuacionContenedor">
                                <?php if ($puntuacionUsuario): ?>
                                    <strong class="estadoPuntuacion text-warning">Tu puntuación: <?= $puntuacionUsuario ?>/10</strong>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                    $mediaPelicula = $daoPU->obtenerPuntuacionMedia($pelicula->getId());
                ?>
                <p id="mediaPuntuacion" class="mt-1">
                    <?php if ($mediaPelicula): ?>
                        <strong>Media: <?= $mediaPelicula ?>/10</strong>
                    <?php endif; ?>
                </p>
                
                <div id="mediaVisualEstrellas" class="star-rating disabled-stars mt-1" style="pointer-events: none;">
                    <?php for ($i = 10; $i >= 1; $i--): ?>
                        <i class="bi <?= ($mediaPelicula >= $i) ? 'bi-star-fill text-warning' : (($mediaPelicula >= $i - 0.5) ? 'bi-star-half text-warning' : 'bi-star text-secondary') ?>"></i>
                    <?php endfor; ?>
                </div>

                <p id="numeroVotos" class="text-muted small mt-1">
                    <i class="bi bi-people-fill"></i> <?= $totalVotos ?> voto<?= $totalVotos != 1 ? 's' : '' ?>
                </p>

                
                <br>

                <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                    <a href="index.php?accion=editar_pelicula&id=<?= $pelicula->getId() ?>">Editar Película</a>
                <?php endif; ?>


                <br><br><br>
                

                <div id="estadoReservaContenedor">
                    <?php if ($peliculaReservada): ?>
                        <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                            <strong class="estadoReservado text-warning">
                                Película Reservada
                                <?php if ($usuarioReservado): ?>
                                    <i>por: <?= $usuarioReservado->getEmail() ?></i>
                                <?php endif; ?>
                            </strong>
                        <?php elseif (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                            <strong class="estadoReservado text-warning">Película Reservada</strong>
                        <?php endif; ?>
                    <?php else: ?>
                        <strong class="text-warning">Película disponible para Reserva</strong>
                    <?php endif; ?>
                </div>

                
                <br>

                <div id="estadoPrestamoContenedor">
                    <?php if ($peliculaPrestada): ?>
                        <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'A'): ?>
                            <?php if ($usuarioPrestamo != null): ?>
                                <strong class="estadoPrestado text-warning">Película Prestada
                                    <i>a: <?= $usuarioPrestamo->getEmail() ?></i>
                                </strong>
                            <?php else: ?>
                                <strong class="text-warning">Película Disponible para ser Prestada</strong>
                            <?php endif; ?>
                        <?php elseif (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                            <strong class="estadoPrestado text-warning">Película Prestada</strong>
                        <?php endif; ?>
                    <?php else: ?>
                        <strong class="text-warning">Película Disponible para ser Prestada</strong>
                    <?php endif; ?>
                </div>


                <br>
                
                <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                    <div id="estadoVistaContenedor">
                        <?php if ($marcadaVista): ?>
                            <strong class="estadoVista text-success">Película Vista</strong>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <strong class="alert alert-warning" role="alert">Pelicula con id <?= $id ?> no encontrada</strong>
            <?php endif; ?>

            <br><br>

            

            <br><br>
            <!-- Permitimos a los usuarios con rol "U" gestionar reservas de películas si hay una sesión activa. Si
            la película no está reservada o la reserva es del usuario conectado, se muestra un botón para "Quitar Reserva"
            o "Poner Reserva", según corresponda. -->
            <?php if(Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U' && ( !$peliculaReservada || $existeReserva )): ?>
                <?php if($existeReserva): ?>
                    <button class="quitarReserva" data-idPelicula="<?= $pelicula->getId()?>" id="botonReserva">Quitar Reserva</button>
                <?php else: ?>
                    <button class="ponerReserva" data-idPelicula="<?= $pelicula->getId()?>" id="botonReserva">Poner Reserva</button>
                <?php endif; ?>
                
            <?php endif; ?>

            <br><br>

            <!-- Verificamos si hay una sesión activa con un usuario que tiene el rol "U". Si es así, permite
            al usuario marcar una película como "vista" o "no vista" haciendo clic en el icono. -->
            <?php if (Sesion::existeSesion() && Sesion::getUsuario()->getRol() === 'U'): ?>
                <span class="estado-vista">
                    <?php if ($marcadaVista): ?>
                        <i id="botonVista"
                        class="fas fa-eye quitarVista icono-visto"
                        data-idPelicula="<?= $pelicula->getId() ?>"
                        style="cursor: pointer; font-size: 1.5rem;"
                        title="Quitar vista"></i>
                    <?php else: ?>
                        <i id="botonVista"
                        class="fas fa-eye-slash ponerVista icono-no-visto"
                        data-idPelicula="<?= $pelicula->getId() ?>"
                        style="cursor: pointer; font-size: 1.5rem;"
                        title="Marcar como vista"></i>
                    <?php endif; ?>

                    <!-- Siempre se muestra este span junto al icono al marcar la vista o si ya estaba
                    marcada como vista -->
                    <span class="texto-visto<?= $marcadaVista ? '' : ' oculto' ?>">
                        <i class="fas fa-check-circle icono-confirmacion"></i> Vista
                    </span>
                </span>
            <?php endif; ?>


            <br><br>
            <a href="index.php?accion=peliculas_por_categoria&id=<?=$categoria->getId()?>">Volver a la Categoría <?= $categoria->getNombre() ?></a>
        </div>
    </main>
    

    <script src="js.js"></script>


</body>
</html>

