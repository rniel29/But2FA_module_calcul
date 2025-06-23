<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'db.php';

// Vérifie que l'utilisateur est bien un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé.");
}

$stmt = $conn->prepare("SELECT login, last_ip, last_connection FROM users ORDER BY last_connection DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Système - Journal des connexions</title>
</head>
<body>
<h1>Journal des connexions utilisateurs</h1>
<table>
    <tr>
        <th>Login</th>
        <th>Dernière IP</th>
        <th>Dernière Connexion</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['login']) ?></td>
        <td><?= $user['last_ip'] ?? 'Jamais connecté' ?></td>
        <td><?= $user['last_connection'] ?? 'Jamais connecté' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
