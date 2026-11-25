<?php
// Conexión a la base de datos para hacer la página dinámica
require_once 'db.php';
$stmt = $conexion->query("SELECT * FROM productos ORDER BY id DESC LIMIT 6");
$productosRecientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Dulce Festejo - Inicio</title>
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
    <body id="page-top">
        
        <!-- Navegación con Logo -->
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
        
        <!-- Hero Section: Carrusel Promocional -->
        <header class="masthead p-0 mt-5 pt-5">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/img/banner1.jpg" class="d-block w-100" alt="Dulces a granel" style="height: 60vh; object-fit: cover; filter: brightness(0.6);">
                        <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                            <h1 class="display-3 fw-bold text-white shadow-sm">Los mejores dulces para tus fiestas</h1>
                            <p class="lead text-white">Mayoreo y menudeo con envíos a todo el país.</p>
                            <a class="btn btn-primary btn-xl text-uppercase mt-3 align-self-center" href="productos.php">Ver Catálogo</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/img/banner2.jpg" class="d-block w-100" alt="Piñatas y decoración" style="height: 60vh; object-fit: cover; filter: brightness(0.6);">
                        <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                            <h1 class="display-3 fw-bold text-white shadow-sm">Todo para tu fiesta</h1>
                            <p class="lead text-white">Piñatas, globos y desechables.</p>
                            <a class="btn btn-primary btn-xl text-uppercase mt-3 align-self-center" href="#portfolio">Conoce más</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </header>

        <!-- Contenido principal -->
        <main>
            <section class="page-section bg-light" id="portfolio">
                <div class="container">
                    <div class="text-center">
                        <h2 class="section-heading text-uppercase">Nuestros Productos</h2>
                        <h3 class="section-subheading text-muted">Inventario actualizado en tiempo real.</h3>
                    </div>
                    <div class="row">
                        <?php if (count($productosRecientes) > 0): ?>
                            <?php foreach ($productosRecientes as $prod): ?>
                                <?php
                                $telefono = "5213340483603"; 
                                $mensaje = urlencode("¡Hola Dulce Festejo! Me interesa pedir: " . $prod['nombre'] . " ($" . $prod['precio'] . ")");
                                ?>
                                <div class="col-lg-4 col-sm-6 mb-4">
                                    <div class="portfolio-item">
                                        <a class="portfolio-link" href="productos.php">
                                            <div class="portfolio-hover">
                                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                                            </div>
                                            <img src="<?= htmlspecialchars($prod['imagen']); ?>" alt="Imagen del producto" class="img-fluid">
                                        </a>
                                        <div class="portfolio-caption">
                                            <div class="portfolio-caption-heading"><?= htmlspecialchars($prod['nombre']) ?></div>
                                            <div class="portfolio-caption-subheading text-muted"><?= htmlspecialchars($prod['categoria']) ?></div>
                                            <div class="portfolio-caption-subheading text-primary fw-bold mt-2">$<?= number_format((float)$prod['precio'], 2) ?></div>
                                            
                                            <a href="https://wa.me/<?= $telefono; ?>?text=<?= $mensaje; ?>" 
                                            target="_blank" 
                                            class="btn btn-success btn-sm w-100 mt-3">
                                            <i class="fab fa-whatsapp me-1"></i> Pedir por WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p class="text-muted">Aún no hay productos registrados. <a href="formulario.php">Agrega tu primer producto aquí.</a></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>    

        <?php include 'footer.php'; ?>
        
        <!-- Scripts unificados -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>