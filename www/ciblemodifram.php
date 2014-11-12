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
       Modifie la RAM de la VM
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testmodram.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Ajout au reseau de la VM
fputs($script,"# Modification RAM");
fputs($script,"\n");
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM7']);
fputs($script," --memory ");
fputs($script,$_POST['rama']);
fputs($script,"\n");
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
//echo '[Auth OK]';echo '<br/>';
//Creation ressource SSH
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testmodram.sh")) {
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
//echo 'Modification de la memoire vive de la VM';echo '<br/>';
?>

<?php
//=============Ecriture donnees dans database====================

//Insertion Donnees VMs
$req = $bdd->prepare("UPDATE tableVM SET ram = :newram WHERE nomVM = :namevm AND utilisateur = :utili ");
$req->execute(array('newram' => $_POST['rama'],'namevm' => $_POST['nomVM7'],'utili' => $_SESSION['login']));
?>

<?php 
//=============Redirection vers le menu des VMs====================
header('Location: pageperso.php#menu3');
?>