<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Película</title>
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
        <h2>Añadir Película</h2>
        <?php if (!empty($error)): ?>
            <div class="error">
                <p style="color: red;"><?= $error ?></p>
            </div>
        <?php endif; ?>
        
        <form action="index.php?accion=insertar_pelicula" method="post" enctype="multipart/form-data">
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" placeholder="Titulo">
            <br>
            <label for="director">Director: </label>
            <input type="text" name="director" id="director" placeholder="Director">
            <br>
            <label for="descripcion">Descripción: </label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripcion"></textarea>
            <br>
            <label for="foto">Imagen: </label>
            <input type="file" name="foto" id="foto">
            <br>
            <label for="idCategoria">Categoría: </label>
            <select name="idCategoria" id="idCategoria">
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria->getId() ?>"><?= $categoria->getNombre() ?></option>
                <?php endforeach; ?>
            </select>
            
            <br>
            <input type="submit" value="Insertar Película">
        </form>

        <br><br>
        <a href="index.php">Volver al listado de Categorías</a>
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