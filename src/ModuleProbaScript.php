<?php

require("src/Modules.php");
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
        header("location:Modules.php/?resultat=$resultat");
    } else {
        echo "<p>Erreur : Veuillez entrer des valeurs valides.</p>";
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

// Tests
echo rectangle_median($m, $c, $t , $n) . "\n";
echo rectangle_median(2, 3, 4, 10) . "\n";
?>

?>
