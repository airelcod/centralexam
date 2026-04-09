<?php
require_once 'includes/auth.php';
require_once 'config/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];
    $nombreArchivo = time() . "_" . basename($archivo['name']);
    $ruta = "uploads/" . $nombreArchivo;

    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
        $stmt = $pdo->prepare("INSERT INTO documentos (nombre_archivo, descripcion, subido_por) VALUES (?, ?, ?)");
        $stmt->execute([$nombreArchivo, $descripcion, $_SESSION['user_id']]);
        echo '<div class="alert alert-success">Archivo subido</div>';
    } else {
        echo '<div class="alert alert-danger">Error al subir</div>';
    }
}

$docs = $pdo->query("SELECT d.*, u.nombre FROM documentos d JOIN usuarios u ON d.subido_por = u.id ORDER BY d.fecha_subida DESC")->fetchAll();
?>

<h2>📁 Documentos compartidos</h2>

<div class="card">
    <h3>➕ Subir documento</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="descripcion" placeholder="Descripción" required style="width:100%; margin-bottom:10px;">
        <input type="file" name="archivo" required>
        <button type="submit">Subir</button>
    </form>
</div>

<div class="card">
    <h3>📄 Documentos disponibles</h3>
    <table>
        <tr><th>Descripción</th><th>Subido por</th><th>Fecha</th><th>Descargar</th></tr>
        <?php foreach ($docs as $doc): ?>
        <tr>
            <td><?= htmlspecialchars($doc['descripcion']) ?></td>
            <td><?= htmlspecialchars($doc['nombre']) ?></td>
            <td><?= $doc['fecha_subida'] ?></td>
            <td><a href="uploads/<?= $doc['nombre_archivo'] ?>" target="_blank">📎 Ver</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
