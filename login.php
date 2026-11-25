<?php
session_start();

$clave_correcta = "Dulce2026"; 
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['password'] ?? '') === $clave_correcta) {
        $_SESSION['admin_autenticado'] = true;
        header("Location: formulario.php");
        exit;
    } else {
        $error = "Contraseña incorrecta.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin - Dulce Festejo</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <main class="card shadow p-4" style="max-width: 380px; width: 100%;">
        <div class="text-center mb-3">
            <img src="assets/logo.png" alt="Dulce Festejo" style="height: 60px;">
            <h4 class="mt-2 fw-bold">Panel Administrativo</h4>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
            <a href="index.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Volver al inicio</a>
        </form>
    </main>
</body>
</html>