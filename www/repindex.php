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
$_SESSION['login']=$_POST['securite1'];
$_SESSION['mdp']=$_POST['securite'];

//Connexion Session
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');//connexion bdd
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

//On verifie le pseudo et le mot de passe pour la connexion
$connexion = $_POST['securite'];
$connexion1 = $_POST['securite1'];
$reponse = $bdd->prepare("SELECT ID FROM Inscription WHERE motdepasse='$connexion'");
$reponse->execute(array());
$reponse1 = $bdd->prepare("SELECT ID FROM Inscription WHERE pseudo='$connexion1'");
$reponse1->execute(array());
$count=$reponse->rowCount();
$count1=$reponse1->rowCount();
if($count == 1 && $count1 == 1)//if OK, connexion
{header('Location: pageperso.php');exit();}
else{$_SESSION['badlog']=11;header('Location: index.php');exit();}//sinon retour a l'index
?>

