<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la BDD + session
require_once __DIR__.'/connexion.php';

// Vérifie que la session est active (évite notice)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie que l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé.");
}

// Récupération des utilisateurs + logs
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT login, last_ip, last_connection FROM users ORDER BY last_connection DESC");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    error_log($e->getMessage());
    exit("Erreur SQL : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Système – Journal des connexions</title>
</head>
<body>
    <h1>Journal des connexions utilisateurs</h1>

    <table border="1" cellpadding="6">
        <tr>
            <th>Login</th>
            <th>Dernière IP</th>
            <th>Dernière Connexion</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['login']) ?></td>
            <td><?= $u['last_ip'] ?: 'Jamais' ?></td>
            <td><?= $u['last_connection'] ?: 'Jamais' ?></td>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>
