<?php
session_start();

if (!isset($_SESSION['identifiant'])) {
    header('Location: login.php');
    exit();
}

$identifiant = $_SESSION['identifiant'];
$message = '';

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


    $mot_de_passe = $_POST['passwd'] ?? '';
    $mot_de_passe_hash = md5($mot_de_passe);

    $stmt = $conn->prepare("UPDATE user SET mot_de_passe = ? WHERE login = ?");
    $stmt->bind_param("ss", $mot_de_passe_hash, $identifiant);

    if ($stmt->execute()) {
        header("Location: modules.php");
        exit();
    } else {
        $message = "Erreur lors de la mise à jour du mot de passe.";
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
                <h1><a class="Acc" href="accueil_Membre.php">Modul∈Calcul</a></h1>
                <form method="post" action="deconnexionScript.php">
                    <div class="buttons">
                        <button class="Btn_acc" onclick="location.href='index.php'" name="DeconnexionScript">Déconnexion</button>
                    </div>
                </form>
            </div>
        </header>
        <div class="div_Btn_mod">
            <button class="Btn_mod" onclick="location.href='modules.php'">Loi normale</button>
            <button class="Btn_mod" onclick="location.href='cryptographie.php'">Cryptographie</button>
            <button class="Btn_mod" onclick="location.href='maths.php'">Maths</button>
        </div>
        <main>
            <h1>Bonjour <?php echo htmlspecialchars($identifiant); ?></h1>

            <div class="center">
                    <div class="Formul_mdp"></div>
                    <br>
                    <form class="Formulaire" method="POST" action=''>
                        <h2>Changer le mot de passe</h2>
                        <label class="input_pswd" for="mot_de_passe"> Nouveau mot de passe : </label>
                        <input type="password" id ="mot_de_passe" name= "passwd">
                        <input class="Btn_Form_Co" type="submit" name="connexion" value="Se connecter">
                    </form>
                </div>

            <?php if (!empty($message)): ?>
                <p style="color:red; text-align:center;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            
        </main>
        
    </body>
    <footer>
        <div class="footer">
            <img class="IUT" src="Images/IUT.jpg" alt="Logo IUT UVSQ" height="60">
            <ul class="sans-puces">
                <li>KOUNDI Maryam</li>
                <li>NIEL Ronan</li>
                <li>BELOT Hervé</li>
            </ul>
        </div>
    </footer>

</html>