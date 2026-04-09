<?php
require_once 'includes/auth.php';
if ($_SESSION['user_rol'] != 'admin') {
    die("Acceso denegado");
}
require_once 'config/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $email, $password, $rol]);
    echo '<div class="alert alert-success">Usuario creado</div>';
}

$usuarios = $pdo->query("SELECT * FROM usuarios")->fetchAll();
?>

<h2>👥 Gestión de usuarios</h2>

<div class="card">
    <h3>➕ Nuevo usuario</h3>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="rol">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select>
        <button type="submit">Crear</button>
    </form>
</div>

<div class="card">
    <h3>📋 Lista de usuarios</h3>
    <table>
        <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th></tr>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['rol'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
