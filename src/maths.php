<?php
session_start(); // Démarre la session pour accéder aux variables de session
if (!isset($_SESSION['identifiant'])) {
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>SAE - Admin Systeme</title>
    <link rel="icon" href="Images/Logo.png">
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async
    src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>
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
<div class="Div_mod">
    <div class="mod1">
        <h1>Méthode des rectangles médian</h1>
        <p>$$x = \frac{c}{\sqrt{2 \pi c}} e^{-\frac{1}{2} \left( \frac{x - m}{c} \right)^2}$$</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repellendus molestias error consequatur voluptatum dicta officia qui id in voluptatem at maiores ad porro earum, tempora sit quia autem aliquam!</p>

        <form method="post" action="moduleProbaScript.php" class="mod1">
            <label for="moyenne">Moyenne</label>
            <input type="number" id="moyenne" name="moyenne" placeholder="m" required>

            <label for="ecart_type">Écart type</label>
            <input type="number" id="ecart_type" name="ecart_type" min="0" placeholder="ecart type > 0" required>

            <label for="portee">Portée</label>
            <input type="number" id="portee" name="portee" placeholder="t" required>

            <label for="pas">Nombre de rectangles</label>
            <input type="number" id="pas" name="pas" min="1" max="20000" placeholder="Nb de rectangles < 20 000" required>

            <input type="submit" class="Btn_calc" value="Calculer">
        </form>




        <div class="result">
            <?php
            // Afficher le résultat s'il existe
            if (isset($_SESSION['resultat'])) {
                echo "<p class='resultat'>$$ P(X \leq  " .$_SESSION['portee'].") =" .$_SESSION['resultat']."$$</p>";
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
