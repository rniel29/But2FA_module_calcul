<?php
session_start(); // Démarre la session pour accéder aux variables de session

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>SAE - Admin Systeme</title>
    <link rel="icon" href="Images/Logo.png">
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="header">
        <img class="logo" src="Images/Logo.png" alt="Logo du site web">
        <h1>Modul∈Calcul</h1>
        <div class="buttons">
            <button class="Btn_acc" onclick="location.href='index.html'">Déconnexion</button>
        </div>
    </div>
</header>

<div class="div_Btn_mod"><button class="Btn_mod">Modules</button></div>

<div class="Div_mod">
    <div class="mod1">
        <h1>Méthode des rectangles médian</h1>
        <img class="Img_rect" src="Images/Formule_Rect_Med.png" alt="Formule Rectangle Médian">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repellendus molestias error consequatur voluptatum dicta officia qui id in voluptatem at maiores ad porro earum, tempora sit quia autem aliquam!</p>

        <form method="post" action="ModuleProbaScript.php" class="mod1">
            <label for="moyenne">Moyenne</label>
            <input type="text" id="moyenne" name="moyenne" required>

            <label for="ecart_type">Écart type</label>
            <input type="text" id="ecart_type" name="ecart_type" required>

            <label for="portee">Portée</label>
            <input type="text" id="portee" name="portee" required>

            <label for="pas">Pas</label>
            <input type="text" id="pas" name="pas" required>

            <div class="div_Btn_mod"><input type="submit" class="Btn_calc" value="Calculer"></div>
        </form>

        <div class="result">
            <?php
            // Afficher le résultat s'il existe
            if (isset($_SESSION['resultat'])) {
                echo "<p class='resultat'>Résultat: " . $_SESSION['resultat'] . "</p>";
                // Supprimer le résultat après l'affichage
                unset($_SESSION['resultat']);
            } elseif (isset($_SESSION['error_message'])) {
                echo "<p class='error'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']);
            }
            ?>
        </div>

    </div>
</div>

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
</body>
</html>
