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
                <img class = "logo" src="Images/Logo.png" alt="Logo du site web">
                <h1><a class="Acc" href="Accueil_Membre.php">Modul∈Calcul</a></h1>
                <div class="buttons">
                    <button class="Btn_acc" onclick="location.href='index.php'">Déconnexion</button>
                </div>
            </div>
        </header>

        <div class="div_Btn_mod">
            <button class="Btn_mod" onclick="location.href='Modules.php'">Loi normale</button>
            <button class="Btn_mod" onclick="location.href='Cryptographie.php'">Cryptographie</button>
            <button class="Btn_mod" onclick="location.href='Maths.php'">Maths</button>
        </div>

            <div class="Div_table_admin_systeme">
                <table class="table_admin_systeme">
                    <thead>
                        <tr>
                            <th scope="col"> Journal d'activité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec augue diam, pretium sed nisl et, suscipit interdum ante. Proin et pretium sapien. Praesent varius volutpat tortor, at fermentum sem scelerisque sit amet. Etiam bibendum, enim dapibus hendrerit ornare, nisl massa pulvinar justo, a volutpat neque dui sed risus. Nullam ullamcorper orci nulla, ut consequat lorem laoreet at. Maecenas vel mauris eu orci pretium suscipit. In consequat odio orci, eget maximus tortor rhoncus sit amet. Morbi leo augue, porttitor in justo in, molestie ornare dui.</td>
                        </tr>
                    </tbody>
                </table>
                <button class = "Btn_consult_modif ">consulter les modifications</button>

            </div>


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
