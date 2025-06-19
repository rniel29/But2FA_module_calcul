<?php
session_start();
if (!isset($_SESSION['identifiant'])) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['identifiant'] !== 'adminweb') {
    header('Location: index.php');
    exit();
}

// Connexion base de données
$host = 'localhost';
$db   = 'sae';
$user = 'admin';
$pass = 'admin';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$sql = "SELECT id, login FROM user WHERE login != 'adminweb' ORDER BY login";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>SAE - Admin WEB</title>
    <link rel="icon" href="Images/Logo.png">
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="header">
        <img class="logo" src="Images/Logo.png" alt="Logo du site web">
        <h1><a class="Acc" href="accueil_Membre.php">Modul∈Calcul</a></h1>
        <form method="post" action="deconnexionScript.php">
            <div class="buttons">
                <button class="Btn_acc" name="DeconnexionScript">Déconnexion</button>
            </div>
        </form>
    </div>
</header>

<main>
    <div class="div_Btn_mod">
        <button class="Btn_mod" onclick="location.href='modules.php'">Loi normale</button>
        <button class="Btn_mod" onclick="location.href='cryptographie.php'">Cryptographie</button>
    </div>

    <div class="main_admin_dash">
        <div class="Div_table_admin_web">

            <table class="table_admin_web_dashboard">
                <thead>
                    <tr>
                        <th scope="col">Utilisateurs inscrits</th>
                        <th scope="col">Historique</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                        echo "<td>
                                <form method='post' action='historique_utilisateur.php' style='display:inline;'>
                                    <input type='hidden' name='user_id' value='{$row['id']}'>
                                    <button class='Btn_hist' aria-label='Consulter l'historique de {$row['login']}'></button>
                                </form>
                              </td>";
                        echo "<td>
                                <form method='post' action='supprimer_utilisateur.php' onsubmit=\"return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');\" style='display:inline;'>
                                    <input type='hidden' name='user_id' value='{$row['id']}'>
                                    <button class='Btn_Sup' aria-label='Supprimer l'utilisateur {$row['login']}'></button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucun utilisateur trouvé.</td></tr>";
                }
                $conn->close();
                ?>
                </tbody>
            </table>

            <table class="table_admin_web_Online">
                <thead>
                    <tr>
                        <th scope="col">Utilisateurs connectés</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img class="icon_Online" src="Images/icon_Online.png" width="20" height="20" alt="connecté"> adminweb</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button class="Btn_adm_consultation">Consulter les modifications</button>
    </div>
</main>

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
