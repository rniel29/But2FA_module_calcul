<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Connexion a la base
    $host = 'localhost';
    $dbname = 'sae';
    $user = '';
    $pass = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    $identifiant = $_POST['identifiant'] ?? '';
    $mot_de_passe = $_POST['passwd'] ?? '';

    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE identifiant = :identifiant and mot_de_passe = :mot_de_passe");
    $check->bindParam(':identifiant', $identifiant);
    $check->bindParam(':mot_de_passe', $mot_de_passe);
    $check->execute();

    if ($check->rowCount() > 0) {
        if ($identifiant == 'adminweb' && $mot_de_passe == 'adminweb'){
            session_start();
            $_SESSION['identifiant'] = $identifiant;
            $_SESSION['mot_de_passe'] = md5($mot_de_passe);
            header('location: Admin_Web.php');
        }
        elseif ($identifiant == 'adminsysteme' && $mot_de_passe == 'adminsysteme'){
            session_start();
            $_SESSION['identifiant'] = $identifiant;
            $_SESSION['mot_de_passe'] = md5($mot_de_passe);
            header('location: Admin_Systeme.php');
        }
        else{
            session_start();
            $_SESSION['identifiant'] = $identifiant;
            $_SESSION['mot_de_passe'] = md5($mot_de_passe);
            header('Location: Modules.php');
        }
    } else {
        $message = "L'utilisateur n'existe pas ou mot de passe incorrect !";
    }

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
                <h1><a class="Acc" href="Accueil_Membre.php">Modul∈Calcul</a></h1>
                <div class="buttons">
                    <button class="Btn_acc" onclick="location.href='Inscription.php'">Inscription</button>
                </div>
            </div>
        </header>

        <main>
            <div class="center">
                <div class="Formul_Inscript"><h1>Connexion</h1></div>
                <br>
                <form class="Formulaire">
                    <div class="Titre_Formulaire"></div>
                    <h2>Identifiant</h2>
                    <label for="identifiant"></label>
                    <input type="text" id="identifiant" name="identifiant">
                    <h2>Mot de passe</h2>
                    <label class="input_pswd" for="mot_de_passe"></label>
                    <input type="password" id ="mot_de_passe" name= "passwd">
                </form>
                <input class="Btn_Form_Co" type="submit" name="connexion" value="Se connecter" onclick="location.href='Admin_Web.php'" >
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