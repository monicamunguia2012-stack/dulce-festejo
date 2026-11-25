<?php
    session_start();
    if (empty($_SESSION['admin_autenticado'])) {
        header("Location: login.php");
        exit;
    }

    require_once 'db.php';
    $mensaje = '';
    $tipo_alerta = "success";

    // Lógica para obtener producto a editar
    $producto_editar = null;
    if (isset($_GET['editar'])) {
        $id_editar = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_INT);
        if ($id_editar) {
            $stmt = $conexion->prepare('SELECT * FROM productos WHERE id = ?');
            $stmt->execute([$id_editar]);
            $producto_editar = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    // Lógica para GUARDAR o ACTUALIZAR
    if (isset($_POST['nombre']) && isset($_POST['categoria']) && isset($_POST['precio'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre']);
        $categoria = trim($_POST['categoria']);
        $precio = trim($_POST['precio']);

        // Lógica para procesar la imagen
        $ruta_imagen = !empty($_POST['imagen_actual']) ? $_POST['imagen_actual'] : 'assets/default.jpg';
        $error_imagen = '';

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $tamano_archivo = $_FILES['imagen']['size'];
            $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));

            if (!in_array($extension, $extensiones_permitidas)) {
                $error_imagen = "Solo se permiten imágenes JPG, JPEG, PNG o WEBP.";
            } elseif ($tamano_archivo > 2 * 1024 * 1024) {
                $error_imagen = "La imagen no debe superar los 2 MB.";
            } else {
                $nuevo_nombre = uniqid('prod_') . '.' . $extension;
                $destino = 'assets/uploads/' . $nuevo_nombre;

                // Crea la carpeta si no existe
                if (!is_dir('assets/uploads')) {
                    mkdir('assets/uploads', 0755, true);
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    $ruta_imagen = $destino;
                }
            }
        }

        if (empty($error_imagen) && $nombre != '' && $categoria != '' && $precio != '') {
            if ($id) {
                // Actualizar
                $consulta = $conexion->prepare('UPDATE productos SET nombre = ?, categoria = ?, precio = ?, imagen = ? WHERE id = ?');
                $consulta->execute([$nombre, $categoria, $precio, $ruta_imagen, $id]);
                header("Location: productos.php");
                exit;
            } else {
                // VERIFICAR DUPLICADO ANTES DE INSERTAR
                $verificar = $conexion->prepare('SELECT id FROM productos WHERE nombre = ?');
                $verificar->execute([$nombre]);
                
                if ($verificar->fetch()) {
                    $mensaje = "Error: Ya existe un producto con ese nombre.";
                    $tipo_alerta = "danger";
                } else {
                    // Insertar solo si no existe
                    $consulta = $conexion->prepare('INSERT INTO productos (nombre, categoria, precio, imagen) VALUES (?, ?, ?, ?)');
                    $consulta->execute([$nombre, $categoria, $precio, $ruta_imagen]);
                    
                    // REDIRECCIÓN
                    header("Location: formulario.php?mensaje=guardado");
                    exit;
                }
            }
        } elseif (!empty($error_imagen)) {
            $mensaje = $error_imagen;
            $tipo_alerta = "danger";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario - Dulce Festejo</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />

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
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <!-- Alerta de errores (duplicado o imagen inválida) -->
                <?php if ($mensaje): ?>
                    <div class="alert alert-<?= $tipo_alerta ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($mensaje) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <!-- Alerta de éxito al guardar -->
                <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'guardado'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ¡Producto guardado con éxito!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <div class="formulario-tarjeta">
                    <div class="card shadow">
                        <div class="barra-formulario">
                            <h4><?= $producto_editar ? 'Editar Producto' : 'Registrar Producto'; ?></h4>
                        </div>
                        
                        <div class="card-body">
                            <form action="formulario.php" method="POST" id="formProducto" enctype="multipart/form-data">
                                <?php if ($producto_editar): ?>
                                    <input type="hidden" name="id" value="<?= $producto_editar['id']; ?>">
                                    <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($producto_editar['imagen'] ?? ''); ?>">
                                <?php endif; ?>
                                
                                <div class="mb-3">
                                    <label class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre" required 
                                        value="<?= $producto_editar ? htmlspecialchars($producto_editar['nombre']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categoría:</label>
                                    <input type="text" class="form-control" name="categoria" required 
                                        value="<?= $producto_editar ? htmlspecialchars($producto_editar['categoria']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Precio:</label>
                                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required 
                                        value="<?= $producto_editar ? htmlspecialchars($producto_editar['precio']) : ''; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="imagen" class="form-label fw-bold">Imagen del producto</label>
                                    
                                    <!-- Miniatura de vista previa -->
                                    <?php 
                                    $imagen_mostrar = !empty($producto_editar['imagen']) ? $producto_editar['imagen'] : 'assets/default.jpg'; 
                                    ?>
                                    <div class="mb-2">
                                        <img id="preview-imagen" 
                                            src="<?= htmlspecialchars($imagen_mostrar); ?>" 
                                            alt="Vista previa" 
                                            class="img-thumbnail" 
                                            style="max-height: 140px; object-fit: cover;">
                                    </div>

                                    <input type="file" 
                                        class="form-control" 
                                        id="imagen" 
                                        name="imagen" 
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP (máx. 2 MB).</small>
                                </div>

                                <script>
                                    document.getElementById('imagen').addEventListener('change', function(event) {
                                        const archivo = event.target.files[0];
                                        if (archivo) {
                                            const lector = new FileReader();
                                            lector.onload = function(e) {
                                                document.getElementById('preview-imagen').src = e.target.result;
                                            };
                                            lector.readAsDataURL(archivo);
                                        }
                                    });
                                </script>

                                <div id="errorDOM" class="text-danger mb-2" style="display:none;"></div>
                                <button type="submit" class="btn btn-primary w-100">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>    
</body>
</html>