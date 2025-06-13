<?php
session_start();

$host = 'localhost';
$db   = 'sae';
$user = 'admin';
$pass = 'admin';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $m = isset($_POST['moyenne']) ? floatval($_POST['moyenne']) : 0;
    $c = isset($_POST['ecart_type']) ? floatval($_POST['ecart_type']) : 1;
    $t = isset($_POST['portee']) ? floatval($_POST['portee']) : 1;
    $n = isset($_POST['pas']) ? intval($_POST['pas']) : 1000;

    if ($c > 0 && $n > 0 && $n < 20000) {
        $resultat = rectangle_median($m, $c, $t, $n);

        $stmt = $conn->prepare("INSERT INTO resultats (moyenne, ecart_type, portee, pas, resultat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("dddid", $m, $c, $t, $n, $resultat);
        $stmt->execute();
        $stmt->close();

        $_SESSION['resultat'] = $resultat;
        $_SESSION['portee'] = $t;
        header("Location: modules.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Erreur : Veuillez entrer des valeurs valides.";
        header("Location: modules.php");
        exit;
    }
}

function rectangle_median($m, $c, $t, $n) {
    $a = $m - 5 * $c;
    $b = $t;
    $h = ($b - $a) / $n;
    $somme = 0;

    for ($i = 0; $i < $n; $i++) {
        $x = $a + ($i + 0.5) * $h;
        $formule = ($c / sqrt(2 * M_PI * $c)) * (exp(-0.5 * pow(($x - $m) / $c, 2)));
        $somme += $formule;
    }

    return $somme * $h;
}
?>
