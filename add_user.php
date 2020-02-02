<?php
    session_start();
    if (isset($_SESSION['admin_id']) AND isset($_SESSION['admin_identifiant'])) {
        $id = $_SESSION['admin_id'];
        $identifiant = $_SESSION['admin_identifiant'];
        if($id == 1 AND $identifiant == 'admin'){
            $bdd = new PDO('mysql:host=localhost;dbname=pcc','user','password');
try {
    $bdd = new PDO('mysql:host=localhost;dbname=pcc','user','password');
}catch(PDOException $e){
   die('Erreur : '.$e->getMessage());
}
    if(!empty($_POST['identifiant']) AND !empty($_POST['mot_de_passe']) AND !empty($_POST['mot_de_passe_confirm'])){
        $identifiant = htmlspecialchars($_POST['identifiant']);
        $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);
        $mot_de_passe_confirm = htmlspecialchars($_POST['mot_de_passe_confirm']);
        if($mot_de_passe == $mot_de_passe_confirm){
            $crypt_motdepasse = password_hash($mot_de_passe,PASSWORD_DEFAULT);
            $req = $bdd->prepare('insert into client(cli_identifiant,cli_mot_de_passe) values(?,?);');
            if($req){
                $req->execute(array($identifiant,$crypt_motdepasse));
                $message = 'Compte créé avec succès !';
        header('Location:index.php');
            }else {
                $message = 'Probleme de préparation de la requete';
            }
        }else {
            $message = 'Les mots de passes ne sont pas identique';
        }
    }else {
        $message = 'Remplissez tous les champs <br />';
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ajout utilisateur | CVE</title>
    <link rel="stylesheet" type="text/css" href="style/custom_commun.css">
</head>
<body>
    <div class="user">
    <header class="user__header">
        <h1 class="user__title">Ajout utilisateur</h1>
    </header>
    
    <form class="form" method="POST" action="">
        <div class="form__group">
            <input type="text" placeholder="Identifiant" class="form__input" name="identifiant" />
        </div>
        
        <div class="form__group">
            <input type="password" placeholder="Mot de passe" class="form__input" name="mot_de_passe"/>
        </div>
        
        <div class="form__group">
            <input type="password" placeholder="Confirmation mot de passe" class="form__input" name="mot_de_passe_confirm"/>
        </div>
        
        <button class="btn" type="submit">S'Enregistrer</button>
        <br>
    <div>
        <a href='accueil.php'>Annuler</a>
    </div>
        <div style="text-align: center;">
            <?php
                if (isset($message)) {
                    echo $message;
                }
            ?>
        <div>
    </form>
</div>
<?php
}else {
	header('Location:index.php');
}
}else{
	header('Location:index.php');
}
?>
</body>
</html>



