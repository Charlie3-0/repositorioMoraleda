<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Videojuego</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <h2>Editar Videojuego</h2>
        <?php if (!empty($error)): ?>
            <div class="error">
                <p style="color: red;"><?= $error ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($videojuego): ?>
            <form action="index.php?accion=editar_videojuego&id=<?= $videojuego->getId() ?>" method="post" enctype="multipart/form-data">
                <label for="titulo">Título: </label>
                <input type="text" name="titulo" id="titulo" value="<?= $videojuego->getTitulo() ?>">
                <br>
                <label for="desarrollador">Desarrollador: </label>
                <input type="text" name="desarrollador" id="desarrollador" value="<?= $videojuego->getDesarrollador() ?>">
                <br><br>
                <label for="descripcion">Descripción: </label>
                <textarea name="descripcion" id="descripcion"><?= $videojuego->getDescripcion() ?></textarea>
                <br><br>
                <!-- Mostramos la foto actual del videojuego si existe -->
                <?php if ($videojuego->getFoto()): ?>
                    <label>Foto Actual: </label><br>
                    <img src="web/images/<?= $videojuego->getFoto() ?>" style="height: 100px; border: 1px solid black;">
                    <br><br>
                <?php endif; ?>
                <!-- Agregamos la opción para seleccionar una nueva foto -->
                <label for="foto">Seleccionar Nueva Foto: </label>
                <input type="file" name="foto" id="foto">
                <br>
                <label for="idCategoria">Categoría: </label>
                <select name="idCategoria" id="idCategoria">
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->getId() ?>" <?= ($videojuego->getIdCategoria() == $categoria->getId()) ? 'selected' : '' ?>>
                            <?= $categoria->getNombre() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <br><br>
                <input type="submit" value="Guardar Cambios">
                <a href="index.php?accion=ver_videojuego&id=<?= $videojuego->getId() ?>">Volver Atrás</a>
            </form>
        <?php else: ?>
            <p class="alert alert-warning" role="alert">El videojuego no existe o no se ha especificado.</p>
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