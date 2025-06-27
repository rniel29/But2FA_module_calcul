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
    <button class="Btn_mod" onclick="location.href='profil.php'">Profil</button>
    <?php if ($_SESSION['identifiant'] == 'adminweb'){
            echo '<button class="Btn_mod" onclick="location.href=\'admin_Web.php\'">Dashboard</button>';
            }
            ?>
            <?php if ($_SESSION['identifiant'] == 'sysadmin'){
            echo '<button class="Btn_mod" onclick="location.href=\'admin_Systeme.php\'">Dashboard</button>';
            }
            ?>
</div>
<div class="Div_mod">
    <div class="mod1">
        <h1>Système ADFGVX</h1>
        <p>Le système ADFGVX est un moyen de chiffrer un message en utilisant une table spéciale. Chaque lettre ou chiffre du message est transformé en une paire de lettres parmi A, D, F, G, V, X pour cacher son contenu.</p>

        <form method="post" action="calcul_crypto.php" class="mod1">
            <label for="mot_a_chiffrer">Mot à chiffrer</label>
            <input type="text" id="mot_a_chiffrer" name="mot_a_chiffrer" placeholder="ex : perdu">

            <label for="mot_a_dechiffrer">Mot à déchiffrer</label>
            <input type="text" id="mot_a_dechiffrer" name="mot_a_dechiffrer" placeholder="ex : GDADDDDVDX">

            <input type="submit" class="Btn_calc" value="Valider">
        </form>




        <div class="result">
            <?php

            if (isset($_SESSION['resultat_crypto'])) {
                echo "<p class='resultat'>Mot chiffré/déchiffré : <strong>" . $_SESSION['resultat_crypto'] . "</strong></p>";
                unset($_SESSION['resultat_crypto']);
            } elseif (isset($_SESSION['error_message'])) {
                echo "<p class='error'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']);
            }
            ?>
        </div>


    <div class="historique">
    <h2>Historique des derniers calculs</h2>
    <?php
    if (!isset($_SESSION['user_id'])) {
        echo "<p class='error'>Erreur : utilisateur non connecté.</p>";
    } else {
        $user_id = $_SESSION['user_id'];
        $conn = new mysqli('localhost', 'admin', 'admin', 'sae');
        if ($conn->connect_error) {
            echo "<p class='error'>Erreur de connexion à la base de données.</p>";
        } else {
            $sql = "SELECT id, moyenne, ecart_type, portee, pas, resultat, date_calcul 
                    FROM crypto 
                    WHERE user_id = ? 
                    ORDER BY date_calcul DESC 
                    LIMIT 5";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                ?>
                <table class="table-historique">
                    <thead>
                        <tr>
                            <th>Chiffrer</th>
                            <th>Déchiffrer</th>
                            <th>Date</th>
                    
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['moyenne']) ?></td>
                            <td><?= htmlspecialchars($row['ecart_type']) ?></td>
                            <td><?= htmlspecialchars($row['portee']) ?></td>
                            <td><?= htmlspecialchars($row['pas']) ?></td>
                            <td><?= htmlspecialchars($row['resultat']) ?></td>
                            <td><?= htmlspecialchars($row['date_calcul']) ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Supprimer ce calcul ?');">
                                    <input type="hidden" name="supprimer_colonne" value="<?= $row['id'] ?>">
                                    <button class="Btn_Sup">X</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>Aucun calcul enregistré.</p>";
            }

            $stmt->close();
            $conn->close();
        }
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
