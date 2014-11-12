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
    	    Suppression de la VM
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testbis.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Suppression de la VM
fputs($script,"# Suppression de la VM");
fputs($script,"\n");
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM4']);
fputs($script," --hda none");
fputs($script,"\n");
fputs($script,"vboxmanage unregistervm ");
fputs($script,$_POST['nomVM4']);
fputs($script," --delete");
fputs($script,"\n");
fputs($script,"rm -R /home/");
fputs($script,$_SESSION['login']);
fputs($script,"/VirtualBox\ VMs/");
fputs($script,$_POST['nomVM4']);
fputs($script,"\n");
fclose($script);
?>


<?php 
//=============Lancement du script via SSH====================
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
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testbis.sh")) {
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
//echo 'Suppression de votre VM reussie';echo '<br/>';
?>

<?php 
//=============Suppression dans database VMs data====================

//Suppression données de la VM
$req = $bdd->prepare("DELETE FROM tableVM WHERE nomVM= ? AND utilisateur= ?");
$req->execute(array($_POST['nomVM4'],$_SESSION['login']));
?>

<?php 
//=============Redirection vers le menu des VMs====================
header('Location: pageperso.php#menu3');
?>
