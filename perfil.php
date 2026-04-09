<?php
require_once 'includes/auth.php';
require_once 'config/db.php';
include 'includes/header.php';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<h2>Mi perfil</h2>
<div class="card">
    <p><strong>Nombre:</strong> <?= htmlspecialchars($user['nombre']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Rol:</strong> <?= $user['rol'] ?></p>
</div>

<?php include 'includes/footer.php'; ?>
