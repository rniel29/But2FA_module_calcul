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
</div>
<div class="Div_mod">
    <div class="mod1">
        <h1>Méthode des rectangles médian</h1>
        <p>$$x = \frac{c}{\sqrt{2 \pi c}} e^{-\frac{1}{2} \left( \frac{x - m}{c} \right)^2}$$</p>
        <p>Moyenne (𝑚) : Centre de la distribution.<br>Portée : Différence entre le max et le min (indicateur de dispersion).<br>Écart-type (𝑐) : Largeur de la distribution normale.<br>Nombre de rectangles : Plus il est grand, plus l'approximation est précise avec la technique des rectangles médiants.</p>

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

    <div class="historique">
        <h2>Historique des derniers calculs</h2>
        <ul>
            <?php
            $conn = new mysqli('localhost', 'admin', 'admin', 'sae');
            if ($conn->connect_error) {
                echo "<li>Erreur de connexion à la base de données.</li>";
            } else {
                $sql = "SELECT moyenne, ecart_type, portee, pas, resultat, date_calcul 
                    FROM resultats 
                    ORDER BY date_calcul DESC 
                    LIMIT 5";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>m={$row['moyenne']}, c={$row['ecart_type']}, t={$row['portee']}, n={$row['pas']} → P(X≤t) ≈ {$row['resultat']} (". $row['date_calcul'] .")</li>";
                    }
                } else {
                    echo "<li>Aucun calcul enregistré.</li>";
                }

                $conn->close();
            }
            ?>
        </ul>
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
