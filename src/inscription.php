<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Générer captcha uniquement en GET
    $captchaChars = "azertyuiopmlkjgfdsqwxcvbn135469872?;.:/!";
    $captcha = substr(str_shuffle($captchaChars), 0, 6);
    $_SESSION['captcha'] = $captcha;
} else {
    // En POST, récupérer le captcha stocké en session (pour affichage et vérification)
    $captcha = $_SESSION['captcha'] ?? '';
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $dbname = 'sae';
    $user = 'admin';
    $pass = 'admin';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    $identifiant = trim($_POST['identifiant'] ?? '');
    $mot_de_passe = trim($_POST['passwd'] ?? '');
    $captcha2 = trim($_POST['captcha'] ?? '');

    if (empty($identifiant) || empty($mot_de_passe) || empty($captcha2)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        // Vérifier si identifiant existe déjà
        $check = $pdo->prepare("SELECT login FROM user WHERE login = :identifiant");
        $check->bindParam(':identifiant', $identifiant);
        $check->execute();

        if ($check->rowCount() > 0) {
            $message = "Identifiant déjà utilisé.";
        } else {
            // Vérifier captcha
            if ($captcha2 === $captcha) {
                $mot_de_passe_hash = md5($mot_de_passe);

                $stmt = $pdo->prepare("INSERT INTO user (login, password) VALUES (:identifiant, :mot_de_passe)");
                $stmt->bindParam(':identifiant', $identifiant);
                $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);

                if ($stmt->execute()) {
                    header("Location: connexion.php");
                    exit();
                } else {
                    $message = "Erreur lors de l'inscription.";
                }
            } else {
                $message = "Captcha incorrect.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>SAE - Inscription</title>
    <link rel="icon" href="Images/Logo3.png">
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="header">
        <img class="logo" src="Images/Logo.png" alt="Logo du site web">
        <h1><a class="Acc" href="index.php">Modul∈Calcul</a></h1>
        <div class="buttons">
            <button class="Btn_acc" onclick="location.href='connexion.php'">Connexion</button>
        </div>
    </div>
</header>

<main>
    <div class="center">
        <div class="Formul_Inscript"><h1>Inscription</h1></div>
        <br>
        <?php if (!empty($message)): ?>
            <p style="color:red; text-align:center;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form class="Formulaire" method="POST" action="">
            <h2>Identifiant</h2>
            <input type="text" id="identifiant" name="identifiant" required>
            <h2>Mot de passe</h2>
            <input type="password" id="mot_de_passe" name="passwd" required>
            <h2>Captcha</h2>
            <label style="font-weight:bold; font-size:1.5em; letter-spacing: 4px; user-select:none;">
                <?= htmlspecialchars($captcha) ?>
            </label>
            <input type="text" name="captcha" placeholder="Captcha" required>
            <br><br>
            <input class="Btn_Form_Co" type="submit" name="inscription" value="S'inscrire">
        </form>
    </div>
</main>

<footer>
    <div class="footer">
        <img src="Images/IUT.jpg" alt="Logo_IUT_UVSQ" height="60">
        <ul class="sans-puces">
            <li>KOUNDI Maryam</li>
            <li>NIEL Ronan</li>
            <li>BELOT Herve</li>
        </ul>
    </div>
</footer>
</body>
</html>