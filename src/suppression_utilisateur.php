<?php
session_start();

// Vérifie que seul 'adminweb' peut accéder à cette page
if (!isset($_SESSION['identifiant']) || $_SESSION['identifiant'] !== 'adminweb') {
    header("Location: index.php");
    exit();
}

// Vérifie que le formulaire a bien été envoyé en POST avec un user_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Connexion à la base de données
    $host = 'localhost';
    $db   = 'sae';
    $user = 'admin';
    $pass = 'admin';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Sécurité : ne pas supprimer l'utilisateur adminweb
    $stmt_check = $conn->prepare("SELECT login FROM user WHERE id = ?");
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $stmt_check->bind_result($login);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($login === 'adminweb') {
        $conn->close();
        header("Location: admin_Web.php?message=interdit");
        exit();
    }
    if ($login === 'sysadmin') {
        $conn->close();
        header("Location: admin_Web.php?message=interdit");
        exit();
    }

    // Supprimer les résultats liés à l'utilisateur
    $stmt_results = $conn->prepare("DELETE FROM resultats WHERE user_id = ?");
    $stmt_results->bind_param("i", $user_id);
    $stmt_results->execute();
    $stmt_results->close();

    // Supprimer l'utilisateur
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: admin_Web.php?message=supprime");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: admin_Web.php?message=erreur");
        exit();
    }
} else {
    // Accès incorrect ou formulaire non valide
    header("Location: admin_Web.php");
    exit();
}
?>
