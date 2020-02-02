<?php
    session_start();
    if (isset($_SESSION['admin_id']) AND isset($_SESSION['admin_identifiant'])) {
        $id = $_SESSION['admin_id'];
        $identifiant = $_SESSION['admin_identifiant'];
        if($id == 1 AND $identifiant == 'admin'){
            $bdd = new PDO('mysql:host=localhost;dbname=pcc','user','password');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gestion des profils | CVE</title>
    <link rel="stylesheet" type="text/css" href="style/accueil.css">
</head>
<body>
    <div>
        <header class="user__header">
            <div class="btn" >
                <?php
                    echo '<a href="deconnexion.php"> <span id="deco"> Salut <b>' . $identifiant . '</b></span>, Deconnexion</a>';
                ?>
            </div>
            <h1 class="user__title">Interface Administrateur</h1>
        </header>

        <div id ="ui">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Identifiant</th>
                    <th>Dernière connexion</th>
                <th>Consommation</th>
                <th>Total à payer</th>
                <th>Autorisation</th>
                <th>Changer autorisation</th>
                </tr>
                <?php
                    $req = $bdd->query('SELECT * FROM client ORDER BY cli_id ASC');
                    while($value = $req->fetch()){
                    $tmp_id = $value['cli_id'];
                        echo '<tr><td>'.$tmp_id. '</td><td>'.$value['cli_identifiant'].'</td><td>'.$value['cli_derniere_co']. '</td><td>'.$value['cli_conso'].'</td><td>'.$value['cli_prix'].'</td><td>'.$value['cli_autorisation'].'</td>';
                    echo '<td><form action="change_auto.php" method="GET"><button value="'.$tmp_id;
                    echo '">OUI</button> <button value="'.$tmp_id;
                    echo '">NON</button></form></td></tr>';
                    }
                ?>
            </table>
		<br>
		<a href="add_user.php" style="float:left;">Ajouter un utilisateur</a>
        <br>
    </div>
<body>
</html>

<?php
}else{
    header('Location:index.php');
}
}else {
    header('Location:index.php');
}
?>
