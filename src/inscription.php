<?php
$captcha = "azertyuiopmlkjgfdsqwxcvbn135469872?;.:/!";
$captcha = str_shuffle($captcha);
$captcha = substr($captcha, 0, 6);
session_start();
$cook = setcookie("captcha", $captcha, time() + (60 * 60 * 24), "/");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base
    $host = 'localhost';
    $dbname = 'sae';
    $user = 'admin';
    $pass = 'admin';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    $identifiant = $_POST['identifiant'] ?? '';
    $mot_de_passe = $_POST['passwd'] ?? '';
    $captcha2 = $_POST['captcha'];

    // Vérifie si l'identifiant existe déjà
    $check = $pdo->prepare("SELECT id FROM user WHERE 'login' = :identifiant");
    $check->bindParam(':identifiant', $identifiant);
    $check->execute();

    if ($check->rowCount() > 0) {
        $message = "Identifiant déjà utilisé.";
    } else {
        // Vérifie si le captcha est correct
        if ($captcha2 == $_COOKIE['captcha']) {
            $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO user ('login', 'password') VALUES (:identifiant, :mot_de_passe)");
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
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>SAE - Formulaire</title>
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
                <form class="Formulaire" method="POST" action="">
                    <div class="Titre_Formulaire"></div>
                    <h2>Identifiant</h2>
                    <label for="identifiant"></label>
                    <input type="text" id="identifiant" name="identifiant">
                    <h2>Mot de passe</h2>
                    <label class="input_pswd" for="mot_de_passe"></label>
                    <input type="password" id ="mot_de_passe" name= "passwd">
                    <label>Captcha</label>
                    <label><?php echo "$captcha"?></label>
                    <input type='text' name='captcha' placeholder='Captcha'>
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
