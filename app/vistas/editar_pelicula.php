<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
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
        <h2>Editar Película</h2>
        <?php if (!empty($error)): ?>
            <div class="error">
                <p style="color: red;"><?= $error ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($pelicula): ?>
            <form action="index.php?accion=editar_pelicula&id=<?= $pelicula->getId() ?>" method="post" enctype="multipart/form-data">
                <label for="titulo">Título: </label>
                <input type="text" name="titulo" id="titulo" value="<?= $pelicula->getTitulo() ?>">
                <br>
                <label for="director">Director: </label>
                <input type="text" name="director" id="director" value="<?= $pelicula->getDirector() ?>">
                <br><br>
                <label for="descripcion">Descripción: </label>
                <textarea name="descripcion" id="descripcion"><?= $pelicula->getDescripcion() ?></textarea>
                <br><br>
                <!-- Mostramos la foto actual de la pelicula si existe -->
                <?php if ($pelicula->getFoto()): ?>
                    <label>Foto Actual: </label><br>
                    <img src="web/images/<?= $pelicula->getFoto() ?>" style="height: 100px; border: 1px solid black;">
                    <br><br>
                <?php endif; ?>
                <!-- Agregamos la opción para seleccionar una nueva foto -->
                <label for="foto">Seleccionar Nueva Foto: </label>
                <input type="file" name="foto" id="foto">
                <br>
                <label for="idCategoria">Categoría: </label>
                <select name="idCategoria" id="idCategoria">
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->getId() ?>" <?= ($pelicula->getIdCategoria() == $categoria->getId()) ? 'selected' : '' ?>>
                            <?= $categoria->getNombre() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <br><br>
                <input type="submit" value="Guardar Cambios">
                <a href="index.php?accion=ver_pelicula&id=<?= $pelicula->getId() ?>">Volver Atrás</a>
            </form>
        <?php else: ?>
            <p class="alert alert-warning" role="alert">La película no existe o no se ha especificado.</p>
        <?php endif; ?>
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