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
/*
------------------------------------------------
------------------------------------------------
------------------------------------------------
       Exporte la VM sous forme .ova
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testexportvm.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Ajout au reseau de la VM
fputs($script,"# Exporte la VM");
fputs($script,"\n");
fputs($script,"vboxmanage export ");
fputs($script,$_POST['nomVM8']);
fputs($script," --output ");
fputs($script,$_POST['nomVM8']);
fputs($script,".ova");
fputs($script,"\n");
fclose($script);
?>

<?php
//=============Execution script via SSH====================
//Connexion au serveur SSH
$connection = ssh2_connect($_SESSION['serveur'],$_SESSION['port']);
//echo '[Connection OK]';echo '<br/>';
//Autentification login/mdp
if (!ssh2_auth_password($connection, $_SESSION['login'], $_SESSION['mdp'])) {
    header('Location: pageperso.php#menu3');//if login/mdp incorrect on renvoie sur la page principale
    exit();
}
echo '[Auth OK]';echo '<br/>';
//Creation ressource SSH
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testexportvm.sh")) {
    header('Location: pageperso.php#menu3');//if ressource inexistante on renvoie a la page principale
    exit();
}
//echo '[Exec OK]';echo '<br/>';

//Affichage output commande over ssh
stream_set_blocking($stream,true);
$out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
//echo stream_get_contents($out);

fclose($stream);
//echo '<br/>';
//echo 'Exporte la VM';echo '<br/>';
?>

<?php 
//=============Redirection vers le menu des VMs====================
header('Location: pageperso.php#menu3');
?>
