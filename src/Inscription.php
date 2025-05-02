<?php
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

    // Verifie si l'identifiant existe deja
    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE identifiant = :identifiant");
    $check->bindParam(':identifiant', $identifiant);
    $check->execute();

    if ($check->rowCount() > 0) {
        $message = "Identifiant deja utilise.";
    } else {
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO utilisateurs (identifiant, mot_de_passe) VALUES (:identifiant, :mot_de_passe)");
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);

        $message = $stmt->execute() ? "Inscription reussie." : "Erreur lors de l'inscription.";
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
                    <button class="Btn_acc" onclick="location.href='Connexion.html'">Connexion</button>
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
                </form>
                <input class="Btn_Form_Co" type="submit" name="inscription" value="S'inscrire">
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