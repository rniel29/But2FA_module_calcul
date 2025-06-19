<?php
session_start();

if (!isset($_SESSION['identifiant'])) {
    header('Location: index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mot_cry = isset($_POST['mot_a_chiffrer']) ? $_POST['mot_a_chiffrer'] : '';
    $mot_decry = isset($_POST['mot_a_dechiffrer']) ? $_POST['mot_a_dechiffrer'] : '';

    if (!empty($mot_cry)) {
        $mot_crypte_resultat = crypter($mot_cry);
        $_SESSION['resultat_crypto'] = $mot_crypte_resultat; // ou $mot_decrypte_resultat
        header("Location: cryptographie.php");
        exit;
    } else if (!empty($mot_decry)) {

        if(strlen($mot_decry) % 2 != 0){
            $_SESSION['error_message'] = "Erreur : le texte à déchiffrer doit avoir un nombre pair de caractères.";
        } else{
            $mot_decrypte_resultat = decrypter($mot_decry);
            $_SESSION['resultat_crypto'] = $mot_decrypte_resultat;
        }
        header("Location: cryptographie.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Erreur : veuillez remplir au moins un des deux champs.";
        header("Location: cryptographie.php");
        exit;
    }
}


function crypter($mot) {
    $mot_en_liste = str_split(strtoupper($mot));
    $mot_crypte = "";

    $nom_grille = ['A', 'D', 'F', 'G', 'V', 'X'];
    $grille = [
        ['G', 'E', 'H', 'I', 'M', 'S'],
        ['C', 'R', 'F', 'T', 'D', 'U'],
        ['N', 'K', 'A', 'B', 'J', 'L'],
        ['O', 'P', 'Q', 'V', 'W', 'X'],
        ['Y', 'Z', '0', '1', '2', '3'],
        ['4', '5', '6', '7', '8', '9']
    ];

    foreach ($mot_en_liste as $lettre) {
        for ($i = 0; $i < count($nom_grille); $i++) {
            foreach ($grille[$i] as $j => $valeur) {
                if ($valeur == $lettre) {
                    $mot_crypte .= $nom_grille[$i] . $nom_grille[$j];
                }
            }
        }
    }

    return $mot_crypte;
}


function decrypter($mot) {
    $mot_decrypte = "";

    $nom_grille = ['A', 'D', 'F', 'G', 'V', 'X'];
    $grille = [
        ['G', 'E', 'H', 'I', 'M', 'S'],
        ['C', 'R', 'F', 'T', 'D', 'U'],
        ['N', 'K', 'A', 'B', 'J', 'L'],
        ['O', 'P', 'Q', 'V', 'W', 'X'],
        ['Y', 'Z', '0', '1', '2', '3'],
        ['4', '5', '6', '7', '8', '9']
    ];

    for ($i = 0; $i < strlen($mot); $i += 2) {
        $lettre1 = $mot[$i];
        $lettre2 = $mot[$i + 1];

        $i_ligne = array_search($lettre1, $nom_grille);
        $i_colonne = array_search($lettre2, $nom_grille);

        if ($i_ligne === false || $i_colonne === false) {
            $_SESSION['error_message'] = "Erreur : impossible de décrypter, un caractère non valide a été détecté.";
            header("Location: cryptographie.php");
            exit;
        } else {
            $mot_decrypte .= $grille[$i_ligne][$i_colonne];
        }
    }

    return $mot_decrypte;
}