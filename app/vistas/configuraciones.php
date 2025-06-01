<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuraciones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="web/css/estilos.css">
    <link rel="icon" type="image/png" href="web/icons/favicon_TestPlay.png">
    <!-- SweetAlert2 CSS y JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <a class="navbar-brand" href="index.php" required title="Inicio">
            <img src="web/icons/Logo_TestPlay.png" style="height: 200px;";>
        </a>

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

                <br><br>
                <a href="index.php?accion=sobre_nosotros">Sobre Nosotros</a>

                <br><br>
                <a href="index.php?accion=configuraciones_videojuegos"><i class="fa-solid fa-gear"></i> Configuraciones</a>
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

    <main>
        <h1 class="tituloPagina">Configuraciones de Videojuegos</h1>

        <?php if (!empty($_SESSION['mensaje_ok'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['mensaje_ok'] ?>
            </div>
            <?php unset($_SESSION['mensaje_ok']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['mensaje_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['mensaje_error'] ?>
            </div>
            <?php unset($_SESSION['mensaje_error']); ?>
        <?php endif; ?>
        
        <h2>Tabla de usuarios</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                        <td>
                            <?= $usuario->getRol() === 'A' ? 'Administrador' : 'Usuario' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Configuración de roles</h2>
        <form action="index.php?accion=cambiar_rol_usuario" method="post" class="mb-5">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="usuario" class="col-form-label">Usuario:</label>
                </div>
                <div class="col-auto">
                    <select name="id_usuario" id="usuario" class="form-select">
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php if ($usuario->getEmail() !== 'admin@gmail.com'): ?>
                                <option value="<?= $usuario->getId() ?>">
                                    <?= htmlspecialchars($usuario->getEmail()) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-auto">
                    <label for="rol" class="col-form-label">Rol:</label>
                </div>
                <div class="col-auto">
                    <select name="nuevo_rol" id="rol" class="form-select">
                        <option value="U">Usuario</option>
                        <option value="A">Administrador</option>
                    </select>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>

        <h2>Tabla de Videojuegos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($videojuegos as $videojuego): ?>
                    <?php
                        $idVideojuego = $videojuego->getId();
                        $usuarioReservado = $reservasDAO->getUsuarioReservaPorVideojuegoId($idVideojuego); // Puede ser null
                        $reservaActiva = $usuarioReservado !== null;
                        $prestamo = $prestamosDAO->getPrestamoActivoPorVideojuegoId($idVideojuego); // devuelve Prestamo o null
                        $prestamoActivo = $prestamo !== null; // ya está activo si no es null

                    ?>
                    <tr>
                        <td>
                            <a href="index.php?accion=ver_videojuego&id=<?= $videojuego->getId() ?>">
                                <?= $videojuego->getTitulo() ?>
                            </a>
                        </td>
                        <td>
                            <a href="index.php?accion=editar_videojuego&id=<?= $videojuego->getId() ?>" class="btn btn-sm btn-warning">Editar <i class="fa-solid fa-pen-to-square"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="confirmarEliminacion(<?= $videojuego->getId() ?>)">Eliminar <i class="fa-solid fa-trash-can"></i></button>

                            <!-- RESERVA -->
                            <?php if ($reservaActiva): ?>
                                <a href="index.php?accion=quitar_reserva_admin&idVideojuego=<?= $videojuego->getId() ?>" class="btn btn-sm btn-secondary">
                                    Quitar Reserva <i class="fa-solid fa-ban"></i>
                                </a>
                            <?php else: ?>
                                <span class="texto-disponible">Reserva Disponible</span>
                            <?php endif; ?>

                            <!-- PRÉSTAMO -->
                            <?php if ($prestamoActivo): ?>
                                <a href="index.php?accion=devolver_prestamo_admin&idVideojuego=<?= $videojuego->getId() ?>" class="btn btn-sm btn-success">
                                    Devolver <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            <?php else: ?>
                                <span class="texto-disponible">Préstamo Disponible</span>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Botón para insertar videojuego -->
        <a href="index.php?accion=insertar_videojuego" class="btn btn-success mt-3"><i class="fa-solid fa-plus"></i> Añadir Videojuego</a>
        <br>
        <a href="index.php?accion=poner_prestamo" class="btn btn-success mt-3"><i class="fa-solid fa-plus"></i> Añadir Préstamo</a>


    </main>

    <footer>
    </footer>

    <script>
        function confirmarEliminacion(idVideojuego) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminarán permanentemente todos los datos relacionados (reservas, préstamos, puntuaciones, comentarios...)",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?accion=eliminar_videojuego&id=' + idVideojuego;
                }
            });
        }


        setTimeout(() => {
            const success = document.querySelector('.alert-success');
            const error = document.querySelector('.alert-danger');

            if (success) success.remove();
            if (error) error.remove();
        }, 3000);
    </script>

</body>
</html>