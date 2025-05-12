<?php
session_start(); // Démarre la session

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $m = isset($_POST['moyenne']) ? floatval($_POST['moyenne']) : 0;//0
    $c = isset($_POST['ecart_type']) ? floatval($_POST['ecart_type']) : 1;//
    $t = isset($_POST['portee']) ? floatval($_POST['portee']) : 1;
    $n = isset($_POST['pas']) ? intval($_POST['pas']) : 1000;

    // Vérifier que les valeurs sont valides
    if ($c > 0 && $n > 0 && $n<20000)  {
        // Appel de la fonction pour calculer le résultat
        $resultat = rectangle_median($m, $c, $t, $n);

        // Stocker le résultat dans la session
        $_SESSION['resultat'] = $resultat;
        $_SESSION['portee'] = $t;

        // Rediriger vers la page modules.php
        header("Location: modules.php");
        exit; // Important pour stopper l'exécution du script
    } else {
        $_SESSION['error_message'] = "Erreur : Veuillez entrer des valeurs valides.";
        header("Location: modules.php");
        exit;
    }
}

function rectangle_median($m, $c, $t, $n) {
    $a = $m-5*$c;  // borne inférieure
    $b = $t; // borne supérieure
    $h = ($b - $a) / $n; // calcul de h

    $somme = 0; // variable pour effectuer la somme des points médians

    for ($i = 0; $i < $n; $i++) {
        $x = $a + ($i + 0.5) * $h; // calcul d'un point médian
        $formule = ($c / sqrt(2 * M_PI * $c)) * (exp(-0.5 * pow(($x - $m) / $c, 2))); // fonction densité écrite en PHP
        $somme += $formule;
    }

    return $somme * $h ;
}
?>
