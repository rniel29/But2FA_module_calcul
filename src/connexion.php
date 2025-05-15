<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = 'localhost';
    $dbname = 'sae';
    $user = 'admin';
    $pass = 'admin';

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $identifiant = $_POST['identifiant'] ?? '';
    $mot_de_passe = $_POST['passwd'] ?? '';

    $stmt = $conn->prepare("SELECT login FROM user WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $identifiant, $mot_de_passe);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['identifiant'] = $identifiant;

        if ($identifiant === 'adminweb') {
            header('Location: admin_web2.php');
        } elseif ($identifiant === 'adminsysteme') {
            header('Location: admin_Systeme.php');
        } else {
            header('Location: modules.php');
        }
        exit(); 
    } else {
        $message = "L'utilisateur n'existe pas ou mot de passe incorrect !";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>SAE - Connexion</title>
        <link rel="icon" href="Images/Logo.png">
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <header>
            <div class="header">
                <img class="logo" src="Images/Logo.png" alt="Logo du site web">
                <h1><a class="Acc" href="accueil_Membre.php">Modul∈Calcul</a></h1>
                <div class="buttons">
                    <button class="Btn_acc" onclick="location.href='inscription.php'">Inscription</button>
                </div>
            </div>
        </header>

        <main>
            <div class="center">
                <div class="Formul_Inscript"><h1>Connexion</h1></div>
                <br>
                <form class="Formulaire" method="POST" action=''>
                    <div class="Titre_Formulaire"></div>
                    <h2>Identifiant</h2>
                    <label for="identifiant"></label>
                    <input type="text" id="identifiant" name="identifiant">
                    <h2>Mot de passe</h2>
                    <label class="input_pswd" for="mot_de_passe"></label>
                    <input type="password" id ="mot_de_passe" name= "passwd">
                    <input class="Btn_Form_Co" type="submit" name="connexion" value="Se connecter">
                </form>
            </div>
            <?php if (!empty($message)) echo "<p style='color:red; text-align:center;'>$message</p>"; ?>
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