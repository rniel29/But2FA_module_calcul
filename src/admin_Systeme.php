<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['identifiant']) || $_SESSION['identifiant'] !== 'sysadmin') {
    die('Accès refusé.');
}

$host = 'localhost';
$dbname = 'sae';
$user = 'admin';
$pass = 'admin';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

$sql = "SELECT login, last_ip, last_connection FROM user ORDER BY COALESCE(last_connection, '0000-00-00 00:00:00') DESC";
$result = $conn->query($sql);
$users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Système – Journal des connexions</title>
    <style>
        table { border-collapse: collapse; margin-top: 20px }
        th, td { border: 1px solid #000; padding: 6px 12px; text-align: center }
    </style>
</head>
<body>
    <h1>Journal des connexions utilisateurs</h1>
    <table>
        <tr>
            <th>Login</th>
            <th>Dernière IP</th>
            <th>Dernière connexion</th>
        </tr>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td><?= $u['last_ip'] ?: 'Jamais' ?></td>
                <td><?= $u['last_connection'] ?: 'Jamais' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
