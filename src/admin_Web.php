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
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Traitement de la suppression d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_user_id'])) {
    $user_id = intval($_POST['supprimer_user_id']);

    $stmt_check = $conn->prepare("SELECT login FROM user WHERE id = ?");
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $stmt_check->bind_result($login);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($login !== 'adminweb') {
        $stmt_results = $conn->prepare("DELETE FROM resultats WHERE user_id = ?");
        $stmt_results->bind_param("i", $user_id);
        $stmt_results->execute();
        $stmt_results->close();

        $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $alert = "✔️ Utilisateur supprimé.";
    } else {
        $alert = "❌ Suppression interdite pour cet utilisateur.";
    }
}


// Importer le csv
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];     //pour avoir le chemin de ou se trouve le fichier
        $fileExtension = pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION); //recupere lextension du fichier

        if (strtolower($fileExtension) === 'csv') {
            if (($handle = fopen($fileTmpPath, 'r')) !== false) {
                $row = 0;
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    // Sauter la premiere ligne
                    if ($row === 0) {
                        $row++;
                        continue;
                    }

                    $identifiant = trim($data[0]);
                    $mot_de_passe = trim($data[1]);

                    if (empty($identifiant) || empty($mot_de_passe)) {
                        continue; // ignorer lignes vides
                    }

                    // Vérifie si l'identifiant existe déjà
                    $check = $pdo->prepare("SELECT login FROM user WHERE login = :identifiant");
                    $check->bindParam(':identifiant', $identifiant);
                    $check->execute();

                    if ($check->rowCount() === 0) {
                        // Hash du mot de passe
                        $mot_de_passe_hash = md5($mot_de_passe);

                        $stmt = $pdo->prepare("INSERT INTO user (login, password) VALUES (:identifiant, :mot_de_passe)");
                        $stmt->bindParam(':identifiant', $identifiant);
                        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);
                        $stmt->execute();
                    }

                    $row++;
                }

                fclose($handle);
            }
        } else {
            echo "Format de fichier invalide.";
        }
    } else {
        echo "Aucun fichier sélectionné ou erreur lors de l'upload.";
    }

}






// Récupération des utilisateurs
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
        <button class="Btn_mod" onclick="location.href='profil.php'">Profil</button>
    </div>

    <div class="main_admin_dash">
        <?php if (!empty($alert)): ?>
            <div style="text-align:center; color:red; font-weight:bold; margin: 10px;">
                <?= htmlspecialchars($alert) ?>
            </div>
        <?php endif; ?>

        <div class="Div_table_admin_web">
            <table class="table_admin_web_dashboard">
                <thead>
                    <tr>
                        <th scope="col">Utilisateurs inscrits</th>
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
                                    <form method='post' style='display:inline;' onsubmit=\"return confirm('Supprimer cet utilisateur ?');\">
                                        <input type='hidden' name='supprimer_user_id' value='" . $row['id'] . "'>
                                        <button class='Btn_Sup' aria-label='Supprimer " . htmlspecialchars($row['login']) . "'></button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Aucun utilisateur trouvé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <button class="Btn_adm_consultation">Consulter les modifications</button>
        <form method="POST" class="Importer" action="" enctype="multipart/form-data">
            <label for="csv">Choisissez un fichier CSV (login, mot de passe) pour créer un utilisateur :</label>
            <input type="file" name="csv_file" id="csv" accept=".csv" required>
            <button type="submit" name="submit">Importer</button>
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
