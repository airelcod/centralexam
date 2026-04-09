<?php
require_once 'includes/auth.php';
require_once 'config/db.php';
include 'includes/header.php';

// Últimas noticias
$stmt = $pdo->query("SELECT n.*, u.nombre as autor FROM noticias n JOIN usuarios u ON n.autor_id = u.id ORDER BY n.fecha_creacion DESC LIMIT 5");
$noticias = $stmt->fetchAll();
?>

<h2>Bienvenido, <?= htmlspecialchars($_SESSION['user_nombre']) ?></h2>

<div class="card">
    <h3>📢 Últimas noticias internas</h3>
    <?php foreach ($noticias as $noticia): ?>
        <div style="border-bottom:1px solid #eee; margin-bottom:15px;">
            <strong><?= htmlspecialchars($noticia['titulo']) ?></strong><br>
            <small>Por <?= htmlspecialchars($noticia['autor']) ?> - <?= $noticia['fecha_creacion'] ?></small>
            <p><?= nl2br(htmlspecialchars($noticia['contenido'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
