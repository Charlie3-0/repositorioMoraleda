<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Videojuego</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="web/css/estilos.css">
</head>
<body>
    <header>
        <h1 class="tituloPagina">
            <?php if (Sesion::getUsuario() && Sesion::getUsuario()->getRol() === 'A'): ?>
                TESTPLAY ADMIN
            <?php else: ?>
                TESTPLAY
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
                <a href="index.php?accion=ver_prestamos&id=<?=Sesion::getUsuario()->getId()?>">Préstamos</a>

                <br><br>
                <a href="index.php?accion=ver_reservas&id=<?=Sesion::getUsuario()->getId()?>">Reservas</a>

                <br><br>
                <a href="index.php?accion=ver_videojuegos_probados&id=<?=Sesion::getUsuario()->getId()?>">Videojuegos Probados</a>

            <?php elseif (Sesion::getUsuario()->getRol() === 'A'): ?>
                <br><br>
                <a href="index.php?accion=ver_todos_prestamos">Todos los Préstamos</a>

                <br><br>
                <a href="index.php?accion=ver_todas_reservas">Todas las Reservas</a>

                <br><br>
                <a href="index.php?accion=ver_todos_videojuegos_probados">Todos los Videojuegos Probados</a>

                <br><br>
                <a href="index.php?accion=insertar_videojuego">Insertar Videojuego</a>
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
        <h2>Añadir Videojuego</h2>
        <?php if (!empty($error)): ?>
            <div class="error">
                <p style="color: red;"><?= $error ?></p>
            </div>
        <?php endif; ?>
        
        <form action="index.php?accion=insertar_videojuego" method="post" enctype="multipart/form-data">
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" placeholder="Titulo">
            <br>
            <label for="desarrollador">Desarrollador: </label>
            <input type="text" name="desarrollador" id="desarrollador" placeholder="Desarrollador">
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
            <label>Fecha de lanzamiento:</label>
            <input type="date" name="fecha_lanzamiento" required>
            <br>
            <label>Tráiler (iframe de YouTube):</label>
            <textarea name="trailer" rows="4" placeholder="Pega aquí el iframe"></textarea>
            
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