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
//====Connexion====
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');
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
if($co != 1 || $co1 != 1){header('Location: index.php');}
?>
<html>
<head>
<title></title>
</head>

<body>

<!--?php

echo $_POST['rom'];
echo '<br />';
echo $_POST['ram']; 


echo 'top';

?-->


<!--?php 
//echo $_SERVER['DOCUMENT_ROOT'];

$ftp_server='localhost';
$ftp_user_name=$session2;
$ftp_user_pass=$session1;

// Mise en place d'une connexion basique
$conn_id = ftp_connect($ftp_server);

// Identication avec un nom d'utilisateur et un mot de passe
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

if(ftp_pasv($conn_id,true)){

$nom_fichier = $_POST['fichier'];
if(ftp_get($conn_id, "./", $nom_fichier, FTP_BINARY))
{echo 'get' ;}

ftp_close($conn_id);

}
?-->


<!--?php

$dir = 'Dirtestbis';
$ftp_server='localhost';
$ftp_user_name='testsftp';
$ftp_user_pass='test@35';

// Mise en place d'une connexion basique
$conn_id = ftp_connect($ftp_server);

// Identication avec un nom d'utilisateur et un mot de passe
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// Tentative de création du dossier $dir
if (ftp_mkdir($conn_id, $dir)) {
 echo "Le dossier $dir a été créé avec succès\n";
} else {
 echo "Il y a eu un problème lors de la création du dossier $dir\n";
}

// Fermeture de la connexion
ftp_close($conn_id);
?-->

<?php 
/*
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');//connexion bdd
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}


//modification favoris flux rss
$req = $bdd->prepare("UPDATE rateApplication SET $session2 = :newres WHERE nomcommande = :nameappli");
$req->execute(array('newres' => $_POST['test'],'nameappli' => 'firefox'));

//Redirection vers la page actualite
header("Location: pagevideo.php");
*/
?>


</body>
</html>
