<?php
/*****************************
*
* Cloudi Version 0.1
* 
* Written by François Blas
* Last Modification : 11/01/14
* 
******************************/

//demarage de session
session_start();

//Connexion Session
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');//connexion bdd 
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}
$session1=$_SESSION['mdp'];
$session2=$_SESSION['login'];
$rep = $bdd->prepare("SELECT ID FROM Inscription WHERE motdepasse='$session1'");
$rep->execute(array());
$rep1 = $bdd->prepare("SELECT ID FROM Inscription WHERE pseudo='$session2'");
$rep1->execute(array());
$co=$rep->rowCount();
$co1=$rep1->rowCount();
if($co != 1 || $co1 != 1){header('Location: index.php');}//si login/mdp pas trouvé on renvoie a l'index
//-----------------------------------------------------------------------------
?>

<?php

//Insertion Memo
$req = $bdd->prepare("INSERT INTO tableAgenda (Minute, Heure, Jour, Mois, Annee, Memo, Utilisateur) VALUES(?,?,?,?,?,?,?)");
$req->execute(array($_POST['minute'],$_POST['heure'], $_POST['jour'], $_POST['mois'], $_POST['annee'], $_POST['memo'], $_SESSION['login']));

//Redirection vers la page principale
header("Location: pageperso.php");
?>
