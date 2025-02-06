<?php
require("src/Modules.php");

// Initialize the result variable
$resultat = null;

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs du formulaire
    $m = isset($_POST['moyenne']) ? floatval($_POST['moyenne']) : 0;
    $c = isset($_POST['ecart_type']) ? floatval($_POST['ecart_type']) : 1;
    $t = isset($_POST['portee']) ? floatval($_POST['portee']) : 1;
    $n = isset($_POST['pas']) ? intval($_POST['pas']) : 1000;

    // Vérifier que les valeurs sont valides
    if ($c > 0 && $n > 0) {
        // Appel de la fonction
        $resultat = rectangle_median($m, $c, $t, $n);
    } else {
        $error_message = "Erreur : Veuillez entrer des valeurs valides.";
    }
}

function rectangle_median($m, $c, $t, $n) {
    $a = 0;  // borne inférieure
    $b = $t; // borne supérieure
    $h = ($b - $a) / $n; // calcul de h

    $somme = 0; // variable pour effectuer la somme des points médians

    for ($i = 0; $i < $n; $i++) {
        $x = $a + ($i + 0.5) * $h; // calcul d'un point médian
        $formule = ($c / sqrt(2 * M_PI * $c)) * (exp(-0.5 * pow(($x - $m) / $c, 2))); // fonction densité écrite en PHP
        $somme += $formule;
    }

    return $somme * $h + 0.5; // Ajout du 0.5 afin de prendre en compte les valeurs présentes entre -infini et 0
}

?>

<!-- HTML Code -->
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

        <form method="post" action="Modules.php" class="mod1">
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
            if (isset($resultat)) {
                echo "Résultat: " . $resultat;
            } elseif (isset($error_message)) {
                echo $error_message;
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
