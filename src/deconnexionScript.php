<!-- DeconnexionScript.php -->
<?php

session_start();
if (isset($_POST['DeconnexionScript'])) {
    // Détruire toutes les données de session
    $_SESSION = [];
    session_destroy();

    // Rediriger vers la page de connexion ou accueil
    header("Location: index.php");
    exit;
}
?>