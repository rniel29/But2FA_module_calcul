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
                    <button class="Btn_acc" onclick="location.href='Connexion.php'">Connexion</button>
                </div>
            </div>
        </header>

        <main>
            <div class="center">
                <div class="Formul_Inscript"><h1>Inscription</h1></div>
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
                <input class="Btn_Form_Co" type="submit" name="inscription" value="S'inscrire">
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
