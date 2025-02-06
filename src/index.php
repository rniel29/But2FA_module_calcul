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
                <h1>Modul∈Calcul</h1>
                <div class="buttons">
                    <button class="Btn_acc" onclick="location.href='Connexion.html'">Connexion</button>
                    <button class="Btn_acc" onclick="location.href='Inscription.html'">Inscription</button>
                </div>
            </div>
        </header>

        <main>
            <div class="div_Btn_mod"><button class="Btn_mod" onclick="location.href='Modules.html'">Modules</button></div>

            <div class="center_acc">
                <div id="ratio">
                    <!-- <iframe  src="Vidéo/DUT Informatique (INFO) _ Présentation.mp4" allowTransparency="true"></iframe> -->
                    <video id="video" controls="" autoplay="" name="media"><source src="Video/DUT_Informatique.mp4" type="video/mp4"></video>
                </div>
                <div class="Presentation">
                    <h1>Titre</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa nobis repellendus enim quis. Distinctio, reiciendis iste adipisci sunt quo similique rerum! Molestiae repellat id itaque ad alias doloremque velit labore!</p>
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
