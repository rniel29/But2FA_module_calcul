<?php
session_start();

if (!isset($_SESSION['identifiant']) || $_SESSION['identifiant'] !== 'adminweb') {
    header('Location: index.php');
    exit();
}

$alert = '';
$host = 'localhost';
$db   = 'sae';
$user = 'admin';
$pass = 'admin';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}


// Supprimer un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_user_id'])) {
    $user_id = intval($_POST['supprimer_user_id']);
    $stmt = $conn->prepare("SELECT login FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($login);
    $stmt->fetch();
    $stmt->close();

    if ($login !== 'adminweb') {
        // Créer dossier/fichier logs s'ils n'existent pas
        $logDir = __DIR__ . '/logs';
        $logFile = $logDir . '/suppressions.log';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        if (!file_exists($logFile)) {
            file_put_contents($logFile, "== Journal des suppressions ==\n");
            chmod($logFile, 0666);
        }

        $conn->query("DELETE FROM resultats WHERE user_id = $user_id");

        $del_stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $del_stmt->bind_param("i", $user_id);
        $del_stmt->execute();
        $del_stmt->close();

        // Écrire dans le fichier log
        $now = date('Y-m-d H:i:s');
        $log_line = "$now - Utilisateur supprimé : $login\n";
        file_put_contents($logFile, $log_line, FILE_APPEND);

        $alert = " Utilisateur '$login' supprimé.";
    } else {
        $alert = " Suppression de l'administrateur interdite.";
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_historique'])) {
    $user_id = intval($_POST['supprimer_historique']);
    
    if($user_id !== null){

        $stmt = $conn->prepare("DELETE FROM resultats WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Historique supprimé avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la supression de l'historique";
        }

        $stmt->close();

    }else {
        $_SESSION['error_message'] = "Erreur de la fonction supprimer historique";
    }
}











// Import CSV
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    if ($_FILES['csv_file']['error'] === 0) {
        $tmp = $_FILES['csv_file']['tmp_name'];
        if (($handle = fopen($tmp, 'r')) !== false) {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row++ === 0) continue;
                [$login, $pwd] = array_map('trim', $data);
                if (!$login || !$pwd) continue;
                $check = $pdo->prepare("SELECT id FROM user WHERE login = ?");
                $check->execute([$login]);
                if ($check->rowCount() === 0) {
                    $hash = md5($pwd);
                    $insert = $pdo->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
                    $insert->execute([$login, $hash]);
                }
            }
            fclose($handle);
            $alert = " Utilisateurs importés avec succès.";
        }
    } else {
        $alert = " Erreur lors de l'import.";
    }
}

$result = $conn->query("SELECT id, login FROM user WHERE login != 'adminweb' ORDER BY login");
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
        <button class="Btn_mod" onclick="location.href='profil.php'">Profil</button>
    </div>

    <div class="main_admin_dash">
        <?php if ($alert): ?>
            <p style="color:red; text-align:center"><?= htmlspecialchars($alert) ?></p>
        <?php endif; ?>

        <h2>Utilisateurs inscrits</h2>
        <table border="1">
            <tr><th>Login</th><th>Supprimer utilisateur</th><th>Supprimer historique</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['login']) ?></td>
                    <td>
                        <form method="post" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                            <input type="hidden" name="supprimer_user_id" value="<?= $row['id'] ?>">
                            <button class="Btn_Sup">X</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" onsubmit="return confirm('Supprimer historique lier a cette utilisateur ?');">
                            <input type="hidden" name="supprimer_historique" value="<?= $row['id'] ?>">
                            <button class="Btn_Sup">X</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Importer des utilisateurs (CSV)</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="import">fichier</label>
            <input id="import" type="file" name="csv_file" accept=".csv" required>
            <button type="submit">Importer</button>
        </form>
    </div>
</main>

<footer>
    <div class="footer">
        <img src="Images/IUT.jpg" alt="Logo IUT UVSQ" height="60">
        <ul class="sans-puces">
            <li>KOUNDI Maryam</li>
            <li>NIEL Ronan</li>
            <li>BELOT Hervé</li>
        </ul>
    </div>
</footer>
</body>
</html>
