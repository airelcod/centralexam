<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet - Central Lácteos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="navbar">
    <a href="dashboard.php">Inicio</a>
    <a href="noticias.php">Noticias</a>
    <a href="documentos.php">Documentos</a>
    <?php if ($_SESSION['user_rol'] == 'admin'): ?>
        <a href="usuarios.php">Usuarios</a>
    <?php endif; ?>
    <a href="perfil.php">Mi Perfil</a>
    <a href="logout.php">Cerrar Sesión</a>
</div>
<div class="container">
