<?php
if (isset($_POST['Esperance'],$_POST['Forme'],$_POST['ValeurT'],$_POST['NBRVAL'])){
    $esperance = $_POST['Esperance'];
    $forme = $_POST['forme'];
    if($esperance >= 0 && $forme == 'admin'){
        header('location: admin.php');

    }else{
        header('location: formulaire.php?error=1');
    }

}
