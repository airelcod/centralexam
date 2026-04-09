<?php
require_once 'includes/auth.php';
require_once 'config/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $stmt = $pdo->prepare("INSERT INTO noticias (titulo, contenido, autor_id) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $contenido, $_SESSION['user_id']]);
    echo '<div class="alert alert-success">Noticia publicada</div>';
}

$noticias = $pdo->query("SELECT n.*, u.nombre FROM noticias n JOIN usuarios u ON n.autor_id = u.id ORDER BY n.fecha_creacion DESC")->fetchAll();
?>

<h2>📰 Noticias internas</h2>

<div class="card">
    <h3>➕ Nueva noticia</h3>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título" required style="width:100%; margin-bottom:10px; padding:8px;">
        <textarea name="contenido" rows="4" placeholder="Contenido..." required style="width:100%; margin-bottom:10px;"></textarea>
        <button type="submit">Publicar</button>
    </form>
</div>

<div class="card">
    <h3>📄 Listado de noticias</h3>
    <?php foreach ($noticias as $n): ?>
        <div style="margin-bottom:20px;">
            <strong><?= htmlspecialchars($n['titulo']) ?></strong> <br>
            <small><?= $n['fecha_creacion'] ?> por <?= htmlspecialchars($n['nombre']) ?></small>
            <p><?= nl2br(htmlspecialchars($n['contenido'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
