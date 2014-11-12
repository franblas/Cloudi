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

if($_POST['champ-texte']===$_SESSION['login']){
$luu='1';
}
else{
$luu='0';
}

//Insertion Message
$req = $bdd->prepare("INSERT INTO tabletest (fromm, too, message,lu,datee) VALUES(?, ?, ?, ?, ?)");
$req->execute(array($_SESSION['login'], $_POST['champ-texte'], $_POST['message'], $luu, date("F j, Y, g:i a")));

//Redirection vers le minichat
header("Location: minichat.php");
?>

