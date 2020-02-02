<?php
session_start();
    if (isset($_SESSION['admin_id']) AND isset($_SESSION['admin_identifiant'])) {
        $id = $_SESSION['admin_id'];
        $identifiant = $_SESSION['admin_identifiant'];

    if($id == 1 AND $identifiant == 'admin'){
            header('Location:accueil.php');
    }else {
        $no_co = "Vous n'êtes pas autoriser à vous connecter ici.";
    }
    }

$bdd = new PDO('mysql:host=localhost;dbname=pcc','user','password');

$identifiant = htmlspecialchars($_POST['identifiant']);

$req = $bdd->prepare('SELECT admin_id, admin_mot_de_passe FROM admin WHERE admin_identifiant = :admin_identifiant');
$req->execute(array('admin_identifiant' => $identifiant));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$verif_mdp = password_verify($_POST['mot_de_passe'], $resultat['admin_mot_de_passe']);

if(!empty($_POST['identifiant']) AND !empty($_POST['mot_de_passe'])){ //Si les deux variables existent et sont remplies
    if (!$resultat) //Si l'identifiant ne match pas
    {
        $message = 'Mauvais identifiant !</br />';
    }
    else //Si l'idetifiant match alors
    {
        if ($verif_mdp) { // On test si password_verify envoie True
            session_start();
            $_SESSION['admin_id'] = $resultat['admin_id'];
            $_SESSION['admin_identifiant'] = $identifiant;
            header('Location:accueil.php');
        }
        else {
            $message = 'Mauvais mot de passe !<br />';
        }
    }
}else {
    $message = 'Remplissez les champs !<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Connexion | CVE</title>
    <link rel="stylesheet" type="text/css" href="style/custom_commun.css">
</head>
<body>
<div class="user">
    <header class="user__header">
        <h1 class="user__title">Chargeur Véhicule Electrique</h1>
    </header>
    
    <form class="form" method="POST" action="">
        <div class="form__group">
            <input type="text" placeholder="Identifiant" class="form__input" name="identifiant" />
        </div>
        
        <div class="form__group">
            <input type="password" placeholder="Mot de passe" class="form__input" name="mot_de_passe"/>
        </div>
        <button class="btn" type="submit">Se Connecter</button>
        <br>
        <div style="text-align: center;">
            <?php
        if(isset($no_co)){ echo $no_co; }
        else{
                    if(isset($message)){echo $message;}
        }
            ?>
        <div>
    </form>
</div>
</body>
</html>

