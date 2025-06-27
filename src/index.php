<!DOCTYPE html>
<html lang="fr">

    <head>
        <title>SAE - Accueil</title>
        <link rel="icon" href="Images/Logo.png">
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <header>
            <div class="header">
                <img class = "logo" src="Images/Logo.png" alt="Logo du site web">
                <h1><a class="Acc" href="index.php">Modul∈Calcul</a></h1>
                <div class="buttons">
                    <button class="Btn_acc" onclick="location.href='connexion.php'">Connexion</button>
                    <button class="Btn_acc" onclick="location.href='inscription.php'">Inscription</button>
                </div>
            </div>
        </header>

        <main>
            <div class="center_acc">
                <div id="ratio">
                    <!-- <iframe  src="Vidéo/DUT Informatique (INFO) _ Présentation.mp4" allowTransparency="true"></iframe> -->
                    <video id="video" controls="" autoplay="" name="media"><source src="Video/DUT_Informatique.mp4" type="video/mp4"></video>
                </div>
                <div class="Presentation">
                    <h1>Bienvenue sur Modul∈Calcul !</h1>
                    <p> Afin de pouvoir profiter des fonctionnalités de notre site, nous vous invitons à vous inscrire !</p>
                    <p> Ici, nous vous proposons divers modules de calculs mathématiques, vous aurez le choix entre :</p>
                    <ul>
                        <li>Loi normale qui décrit de manière théorique une expérience aléatoire </li>
                        <li>Cryptographie pour chiffrer vos messages</li>
                    </ul>
                    <p>Vous pourrez également profiter d'un accès à votre historique, ainsi, vous pourrez préserver vos calculs les plus importants. </p>
                </div>
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
