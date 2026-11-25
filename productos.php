<?php
    session_start();
    require_once 'db.php';

    $esAdmin = !empty($_SESSION['admin_autenticado']);

    // Solo permite eliminar si el usuario es administrador
    if (isset($_POST['eliminar_id']) && $esAdmin) {
        $eliminar_id = filter_input(INPUT_POST, 'eliminar_id', FILTER_VALIDATE_INT);
        if ($eliminar_id) {
            $consulta = $conexion->prepare('DELETE FROM productos WHERE id = ?');
            $consulta->execute([$eliminar_id]);
            header("Location: productos.php");
            exit;
        }
    }

    // Obtener todos los productos
    $productos = $conexion->query('SELECT * FROM productos ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Catálogo - Dulce Festejo</title>
        <link rel="icon" type="image/x-icon" href="assets/logo.png" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        
        <!-- Fuentes-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap 5.3.3 y estilos -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body style="padding-top: 100px;" class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="assets/logo.png" alt="Logo Dulce Festejo">
                    Dulce Festejo
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                    Menu <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="productos.php">Catálogo</a></li>
                        <li class="nav-item"><a class="nav-link" href="formulario.php">Agregar Producto</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-5">
            <h2 class="mb-4 text-center">Catálogo de Productos</h2>

            <!-- Buscador de productos -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0">🔍</span>
                        <input type="text" id="buscador-productos" class="form-control border-start-0" placeholder="Buscar dulces por nombre o categoría...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover bg-white shadow-sm">
                    <thead style="background-color: var(--color-rosa); color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <?php if ($esAdmin): ?>
                                <th>Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="tabla-productos">
                        <?php foreach ($productos as $prod): ?>
                        <tr class="fila-producto">
                            <td><?= $prod['id']; ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($prod['imagen']) ?>" 
                                    alt="<?= htmlspecialchars($prod['nombre']) ?>" 
                                    width="50" height="50" 
                                    style="object-fit: cover; border-radius: 8px;">
                            </td>
                            <td><?= htmlspecialchars($prod['nombre']); ?></td>
                            <td><?= htmlspecialchars($prod['categoria']); ?></td>
                            <td><span class="precio-badge">$<?= number_format((float)$prod['precio'], 2) ?></span></td>
                              
                            <?php if ($esAdmin): ?>
                                <td>
                                    <a href="formulario.php?editar=<?= $prod['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="productos.php" method="POST" class="d-inline">
                                        <input type="hidden" name="eliminar_id" value="<?= $prod['id']; ?>">
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm btn-eliminar">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>

                            <?php endif; ?>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php include 'footer.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script>
            document.getElementById('buscador-productos').addEventListener('keyup', function() {
                const texto = this.value.toLowerCase();
                const filas = document.querySelectorAll('.fila-producto');

                filas.forEach(function(fila) {
                    const contenido = fila.textContent.toLowerCase();
                    fila.style.display = contenido.includes(texto) ? '' : 'none';
                });
            });
        </script>
    </body>
</html>