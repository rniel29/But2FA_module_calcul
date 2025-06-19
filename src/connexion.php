<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données avec MySQLi
    $host = 'localhost';
    $dbname = 'sae';
    $user = 'admin';
    $pass = 'admin';

    $conn = new mysqli($host, $user, $pass, $dbname);

    // Vérifie la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $identifiant = $_POST['identifiant'] ?? '';
    $mot_de_passe = $_POST['passwd'] ?? '';

    // Préparer une requête sécurisée
    $stmt = $conn->prepare("SELECT id,password FROM user WHERE login = ?");
    $stmt->bind_param("s", $identifiant);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id,$hash);
        $stmt->fetch();

        // Vérification MD5
        if (md5($mot_de_passe) === $hash) {
            // Mot de passe correct
            $_SESSION['identifiant'] = $identifiant;
            $_SESSION['user_id'] = $user_id;


            // Mise à jour date/heure et IP dernière connexion
            $ip = $_SERVER['REMOTE_ADDR'];
            $now = date('Y-m-d H:i:s');

            $update = $conn->prepare("UPDATE user SET last_connection = ?, last_ip = ? WHERE login = ?");
            $update->bind_param("sss", $now, $ip, $identifiant);
            $update->execute();
            $update->close();

            if ($identifiant === 'adminweb') {
                header('Location: admin_Web.php');
                exit();
            } elseif ($identifiant === 'sysadmin') {
                header('Location: admin_Systeme.php');
                exit();
            } else {
                header('Location: accueil_Membre.php');
                exit();
            }
        } else {
            $message = "Mot de passe incorrect !";
        }
    } else {
        $message = "L'utilisateur n'existe pas !";
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

                    <p><a href="mdp_oublier.php">Mot de passe oublié</a></p>
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