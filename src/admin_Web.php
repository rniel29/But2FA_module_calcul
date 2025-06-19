
<?php
if (!isset($_SESSION['identifiant'])) {
    header('Location: index.php');
    exit();
}


if ($_SESSION['identifiant'] !== 'adminweb') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

    <head>
        <title>SAE - Admin WEB</title>
        <link rel="icon" href="Images/Logo.png">
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">

    </head>
    <body>
        <header>
            <div class="header">
                <img class = "logo" src="Images/Logo.png" alt="Logo du site web">
                <h1><a class="Acc" href="accueil_Membre.php">Modul∈Calcul</a></h1>
                <form method="post" action="deconnexionScript.php">
                    <div class="buttons">
                        <button class="Btn_acc" onclick="location.href='index.php'" name="DeconnexionScript">Déconnexion</button>
                    </div>
                </form>
            </div>
        </header>
        <main>

            <div class="div_Btn_mod">
                <button class="Btn_mod" onclick="location.href='modules.php'">Loi normale</button>
                <button class="Btn_mod" onclick="location.href='cryptographie.php'">Cryptographie</button>
                <button class="Btn_mod" onclick="location.href='maths.php'">Maths</button>
            </div>


            <div class="main_admin_dash">


            <div class="Div_table_admin_web">

                <table class="table_admin_web_dashboard">
                    <thead>
                        <tr>
                            <th scope="col"> Liste de tous les utilisateurs inscrits</th>
                            <th scope="col"> Historique</th>
                            <th scope="col"> Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>John DOE</td>
                        <td><button class="Btn_hist" aria-label="Consulter l'historique de John DOE"></button></td>
                        <td><button class="Btn_Sup" aria-label="Supprimer l'utilisateur John DOE"></button></td>
                      </tr>
                      <tr>
                        <td>John DOE</td>
                          <td><button class="Btn_hist" aria-label="Consulter l'historique de John DOE"></button></td>
                          <td><button class="Btn_Sup" aria-label="Supprimer l'utilisateur John DOE"></button></td>
                      </tr>
                      <tr>
                        <td>John DOE</td>
                          <td><button class="Btn_hist" aria-label="Consulter l'historique de John DOE"></button></td>
                          <td><button class="Btn_Sup" aria-label="Supprimer l'utilisateur John DOE"></button></td>
                      </tr>


                      <tr>
                        <td>John DOE</td>
                          <td><button class="Btn_hist" aria-label="Consulter l'historique de John DOE"></button></td>
                          <td><button class="Btn_Sup" aria-label="Supprimer l'utilisateur John DOE"></button></td>
                      </tr>
                      <tr>
                        <td>John DOE</td>
                          <td><button class="Btn_hist" aria-label="Consulter l'historique de John DOE"></button></td>
                          <td><button class="Btn_Sup" aria-label="Supprimer l'utilisateur John DOE"></button></td>
                      </tr>
                      <tr>
                        <td>John DOE</td>
                          <td><button class="Btn_hist" aria-label="Consulter l'historique de John DOE"></button></td>
                          <td><button class="Btn_Sup" aria-label="Supprimer l'utilisateur John DOE"></button></td>
                      </tr>


                    </tbody>
                </table>


                    <table class="table_admin_web_Online">
                        <thead>
                            <tr>
                                <th scope="col"> Uilisateurs connectés</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                    <img class="icon_Online" src="Images/icon_Online.png" width="20" height="20" alt="bouton vert">
                                John DOE
                          </tr>
                        </tbody>
                    </table>

            </div>

            <button class="Btn_adm_consultation">Consulter les modifications</button>
            </div>
        </main>

        <footer>
            <div class="footer">
                <img src="Images/IUT.jpg" alt="Logo_IUT_UVSQ" height="60">

                <ul class="sans-puces">
                    <li>KOUNDI Maryam</li>
                    <li>NIEL Ronan</li>
                    <li>BELOT Hervé</li>
                </ul>
            </div>
        </footer>
    </body>
</html>
