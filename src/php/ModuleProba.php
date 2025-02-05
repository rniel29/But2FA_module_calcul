<?php

if(isset($_POST['Calculer'],$_POST['moyenne'],$_POST['ecart_type'],$_POST['portee'],$_POST['pas'])){
    $moyenne=$_POST['moyenne'];
    $ecart_type=$_POST['ecart_type'];
    $portee=$_POST['portee'];
    $pas=$_POST['pas'];
    if($ecart_type=>0 && $pas<19000000){
        echo 'alert("nope")';
    }
}


function rectangleMedian($n) {
    $a = 0;
    $b = 1;
    $h = ($b - $a) / $n;
    $somme = 0;

    for ($i = 0; $i < $n; $i++) {
        $milieu = $a + ($i + 0.5) * $h;
        $f_milieu = $milieu * $milieu; // Fonction f(x) = x^2
        $somme += $f_milieu;
    }

    return $somme * $h;
}

$n = 100; // Nombre de subdivisions
$resultat = rectangleMedian($n);
echo "Approximation de l'intégrale de f(x) = x² avec n=$n : $resultat";
?>
