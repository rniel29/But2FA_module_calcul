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
        <title>SAE - Admin sys</title>
        <link rel="icon" href="Images/Logo.png">
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">



    </head>
    <body>
        <header>
            <div class="header">
                <img class = "logo" src="Images/Logo.png" alt="Logo du site web">
                <h1><a class="Acc" href="accueil_Membre.php">Modul∈Calcul</a></h1>
                <form method="post" action="deconnexionScript.php">
                    <div class="buttons">
                        <button class="Btn_acc" onclick="location.href='index.php'" name="DeconnexionScript">Déconnexion</button>
                    </div>
                </form>
            </div>
        </header>

        <main>

            <div class="div_Btn_mod">
                <button class="Btn_mod" onclick="location.href='modules.php'">Loi normale</button>
                <button class="Btn_mod" onclick="location.href='cryptographie.php'">Cryptographie</button>
                <button class="Btn_mod" onclick="location.href='profil.php'">Profil</button>
            </div>
    <body>
        <div class="main_admin_dash">
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
            </div>
                <footer>
                <div class="footer">
                    <img src="Images/IUT.jpg" alt="Logo_IUT_UVSQ" height="60">

                    <ul class="sans-puces">
                        <li>KOUNDI Maryam</li>
                        <li>NIEL Ronan</li>
                        <li>BELOT Hervé</li>
                    </ul>
                </div>
            </footer>
    </body>
</html>

