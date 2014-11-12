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
//=============Recupeartion ID utilisateur====================

//Recuperation de l'ID utilisateur pour reseau
$reponse = $bdd->prepare("SELECT ID FROM Inscription WHERE pseudo= ?");
$reponse->execute(array($_SESSION['login']));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
  $idutili=$donnees['ID'];//stockage de l'ID dans une variable
}

$reponse->closeCursor();
?>

<?php 
//=============Recuperation nom OS====================

//Recuperation de l'OS selon le nom de la VM
$reponse = $bdd->prepare("SELECT ostype FROM tableVM WHERE nomVM= ?");
$reponse->execute(array($_POST['nomVM5']));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
$varostype=$donnees['ostype']; // recuperation dans une variable
}

$reponse->closeCursor();
?>

<?php
/*
------------------------------------------------
------------------------------------------------
------------------------------------------------
      Ajout de la VM au reseau interne
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testreseauter.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Ajout au reseau de la VM
fputs($script,"# Ajout au reseau interne");
fputs($script,"\n");
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM5']);
fputs($script," --nic");
fputs($script,$idutili);
fputs($script," intnet --nictype");
fputs($script,$idutili);
if($varostype=='xppro' || $varostype=='xpfamilial')
{
fputs($script," Am79C973 --cableconnected");
}
elseif($varostype=='ubuntu' || $varostype=='opensuse' || $varostype=='fedora')
{
fputs($script," 82540EM --cableconnected");
}
fputs($script,$idutili);
fputs($script," ON --intnet");
fputs($script,$idutili);
fputs($script," resint");
fputs($script,$_SESSION['login']);
fputs($script," --nicpromisc");
fputs($script,$idutili);
fputs($script," allow-vms");
fputs($script,"\n");
?>

<?php 
//=============Execution du script via SSH====================
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
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testreseauter.sh")) {
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
//echo 'VM passee sur le reseau interne';echo '<br/>';
?>

<?php
//=============Ecriture donnees dans bdd====================

$varloc="resint".$_SESSION['login'];
//Insertion Donnees VMs
$req = $bdd->prepare("UPDATE tableVM SET reseau = :newres WHERE nomVM = :namevm AND utilisateur = :utili ");
$req->execute(array('newres' => $varloc,'namevm' => $_POST['nomVM5'],'utili' => $_SESSION['login']));
?>

<?php 
//=============Redirection vers le menu des VMs====================
header('Location: pageperso.php#menu3');
?>

