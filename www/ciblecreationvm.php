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
if($co != 1 || $co1 != 1){header('Location: index.php');}
?>

<?php 
//ressource limite
if($_SESSION['pasVM']==1){ //si limite ressources atteinte
header('Location: pageperso.php');
}
?>

<?php
//Verifie si on a inscrit quelques chose dans le formulaire
if(empty($_POST['nomVM']))
{
header('Location: pageperso.php');
break;
}
//----------------------------------------------------
?>

<?php
//Enleve les espaces du nom et n'autorise que lettres et chiffres
$_POST['nomVM']=preg_replace("#[^a-zA-Z0-9]#","",$_POST['nomVM']);
$_POST['nomVM']=trim($_POST['nomVM']);
$_POST['nomVM']=str_replace(' ','',$_POST['nomVM']);
//----------------------------------------------------
?>


<?php 
//=============Verification Nom VM====================

//On regarde les nom de vm deja crees et on refuse les VMs de meme nom pour un utilisateur donné
$namevm = $_POST['nomVM'];
$utill= $_POST['user2'];
$reponse = $bdd->prepare("SELECT ID FROM tableVM WHERE nomVM='$namevm' AND utilisateur='$utill'");
$reponse->execute(array());
$count=$reponse->rowCount();
if($count == 1)
{
header('Location: pageperso.php');
break;
}
?>


<?php
//ID reseau interne

//Recuperation de l'ID utilisateur pour reseau
$reponse = $bdd->prepare("SELECT ID FROM Inscription WHERE pseudo= ?");
$reponse->execute(array($_SESSION['login']));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
  $idreseau=$donnees['ID'];//stockage de l'ID dans une variable
}

$reponse->closeCursor();
?>

<?php
/*
------------------------------------------------
------------------------------------------------
------------------------------------------------
      Creation & configuration de la VM
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."test.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Creation de la VM
fputs($script,"# Creation de la VM");
fputs($script,"\n");
fputs($script,"vboxmanage createvm --name ");
fputs($script,$_POST['nomVM']);
fputs($script," --register");
fputs($script,"\n");
//On va a l'emplacement de la VM
fputs($script,"# On va a l'emplacement de la VM");
fputs($script,"\n");
fputs($script,"cd /home/");
fputs($script,$_SESSION['login']);
fputs($script,"/VirtualBox\ VMs/");
fputs($script,$_POST['nomVM']);
fputs($script,"\n");
//Creation du disque dur
fputs($script,"# Creation du Disque Dur");
fputs($script,"\n");
fputs($script,"vboxmanage createhd --filename ");
fputs($script,$_POST['nomVM']);
fputs($script," --size ");
fputs($script,$_POST['harddisk']);
fputs($script,"000 --format VDI");
fputs($script,"\n");
//Parametrage Systeme de la VM
fputs($script,"# Parametrage systeme");
fputs($script,"\n");
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM']);
if($_POST['ostype']=='xppro' || $_POST['ostype']=='xpfamilial')
{fputs($script," --ostype WindowsXP --pae OFF ");}
elseif($_POST['ostype']=='ubuntu')
{fputs($script," --ostype Ubuntu --pae ON ");}
elseif($_POST['ostype']=='fedora')
{fputs($script," --ostype Fedora --pae OFF ");}
elseif($_POST['ostype']=='opensuse')
{fputs($script," --ostype OpenSUSE --pae OFF ");}
fputs($script,"--rtcuseutc ON ");
fputs($script,"--memory ");
fputs($script,$_POST['ram']);
fputs($script," --vram 12");
fputs($script,"\n");
//Creation des controlleurs
fputs($script,"# Creation des controlleurs");
fputs($script,"\n");
if($_POST['ostype']=='fedora' || $_POST['ostype']=='ubuntu' || $_POST['ostype']=='opensuse')
{
fputs($script,"# Creation de l'IDE");
fputs($script,"\n");
fputs($script,"vboxmanage storagectl ");
fputs($script,$_POST['nomVM']);
fputs($script," --name IDE --add IDE --controller PIIX4 --hostiocache ON --bootable ON ");
fputs($script,"\n");
fputs($script,"# Creation du SATA");
fputs($script,"\n");
fputs($script,"vboxmanage storagectl ");
fputs($script,$_POST['nomVM']);
fputs($script," --name SATA --add SATA --controller IntelAhci --sataportcount 1 --hostiocache OFF --bootable ON ");
fputs($script,"\n");
}
elseif($_POST['ostype']=='xppro' || $_POST['ostype']=='xpfamilial')
{
fputs($script,"# Creation de l'IDE");
fputs($script,"\n");
fputs($script,"vboxmanage storagectl ");
fputs($script,$_POST['nomVM']);
fputs($script," --name IDE --add IDE --controller PIIX4 --hostiocache ON --bootable ON ");
fputs($script,"\n");
}
//Creation des jonctions aux controlleurs
fputs($script,"# Creation des jonctions aux controlleurs");
fputs($script,"\n");
if($_POST['ostype']=='ubuntu')
{
fputs($script,"# Le SATA");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl SATA --port 0 --device 0 --type hdd --medium ");
fputs($script,$_POST['nomVM']);
fputs($script,".vdi");
fputs($script," --mtype normal");
fputs($script,"\n");
fputs($script,"# L'IDE");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 1 --device 0 --type dvddrive --medium /home/paco/Documents/ubuntu.iso --passthrough OFF --tempeject OFF");
fputs($script,"\n");
}
elseif($_POST['ostype']=='fedora')
{
fputs($script,"# Le SATA");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl SATA --port 0 --device 0 --type hdd --medium ");
fputs($script,$_POST['nomVM']);
fputs($script,".vdi");
fputs($script," --mtype normal");
fputs($script,"\n");
fputs($script,"# L'IDE");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 1 --device 0 --type dvddrive --medium /home/paco/Documents/fedora.iso --passthrough OFF --tempeject OFF");
fputs($script,"\n");
}
elseif($_POST['ostype']=='opensuse')
{
fputs($script,"# Le SATA");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl SATA --port 0 --device 0 --type hdd --medium ");
fputs($script,$_POST['nomVM']);
fputs($script,".vdi");
fputs($script," --mtype normal");
fputs($script,"\n");
fputs($script,"# L'IDE");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 1 --device 0 --type dvddrive --medium /home/paco/Documents/opensuse.iso --passthrough OFF --tempeject OFF");
fputs($script,"\n");
}
elseif($_POST['ostype']=='xppro')
{
fputs($script,"# IDE maitre primaire");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 0 --device 0 --type hdd --medium ");
fputs($script,$_POST['nomVM']);
fputs($script,".vdi");
fputs($script," --mtype normal");
fputs($script,"\n");
fputs($script,"# IDE maitre secondaire");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 1 --device 0 --type dvddrive --medium /home/paco/Documents/installautoPro.iso --passthrough OFF --tempeject OFF");
fputs($script,"\n");
}
elseif($_POST['ostype']=='xpfamilial')
{
fputs($script,"# IDE maitre primaire");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 0 --device 0 --type hdd --medium ");
fputs($script,$_POST['nomVM']);
fputs($script,".vdi");
fputs($script," --mtype normal");
fputs($script,"\n");
fputs($script,"# IDE maitre secondaire");
fputs($script,"\n");
fputs($script,"vboxmanage storageattach ");
fputs($script,$_POST['nomVM']);
fputs($script," --storagectl IDE --port 1 --device 0 --type dvddrive --medium /home/paco/Documents/xpfamilial.iso --passthrough OFF --tempeject OFF");
fputs($script,"\n");
}
//Configuration du son
fputs($script,"# Configuration du son");
fputs($script,"\n");
if($_POST['ostype']=='xppro' || $_POST['ostype']=='xpfamilial')
{
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM']);
fputs($script," --audio pulse");
fputs($script,"\n");
}
elseif($_POST['ostype']=='fedora' || $_POST['ostype']=='ubuntu' || $_POST['ostype']=='opensuse')
{
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM']);
fputs($script," --audio pulse");
fputs($script,"\n");
}
//Configuration USB
fputs($script,"# Configuration USB");
fputs($script,"\n");
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM']);
fputs($script," --usb ON --usbehci ON");
fputs($script,"\n");
//Configuration du reseau
fputs($script,"# Configuration du reseau");
fputs($script,"\n");
if($_POST['ostype']=='fedora' || $_POST['ostype']=='ubuntu' || $_POST['ostype']=='opensuse')
{
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM']);
fputs($script," --nic");
fputs($script,$idreseau);
fputs($script," nat --nictype");
fputs($script,$idreseau);
fputs($script," 82540EM --cableconnected");
fputs($script,$idreseau);
fputs($script," ON "); 
fputs($script,"\n");
}
elseif($_POST['ostype']=='xppro' || $_POST['ostype']=='xpfamilial')
{
fputs($script,"vboxmanage modifyvm ");
fputs($script,$_POST['nomVM']);
fputs($script," --nic");
fputs($script,$idreseau);
fputs($script," nat --nictype");
fputs($script,$idreseau);
fputs($script," Am79C973 --cableconnected");
fputs($script,$idreseau);
fputs($script," ON "); 
fputs($script,"\n");
}
//=============Creation reseau interne====================

fputs($script,"# Creation du reseau interne");
fputs($script,"\n");
fputs($script,"vboxmanage dhcpserver add --netname resint");
fputs($script,$_SESSION['login']);
fputs($script," --ip 192.168.");
fputs($script,$idreseau);
fputs($script,".1 --netmask 255.255.255.0 --lowerip 192.168.");
fputs($script,$idreseau);
fputs($script,".2");
fputs($script," --upperip 192.168.");
fputs($script,$idreseau);
fputs($script,".254");
fputs($script," --enable");
fputs($script,"\n");
fputs($script,"# Effacer script");
fputs($script,"\n");
fputs($script,"echo '' > /home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."test.sh");
fputs($script,"\n");

//Fermeture du fichier
fclose($script);
?>

<?php
//=============Ecriture dans la base de donnees reseau interne====================

$varloc1="252";//nombre ip
$varloc2="2";//first ip
$varloc3="254";//last ip
$varloc4="resint".$_SESSION['login'];//nom reseau interne
$varloc5=$_SESSION['login'];

//On verifie que le reseau n'est pas deja cree
$reponse2 = $bdd->prepare("SELECT ID FROM reseauinterne WHERE user='$varloc5' ");
$reponse2->execute(array());
$count2=$reponse2->rowCount();
if($count2 == 1)//si deja cree
{
$req = $bdd->prepare("UPDATE reseauinterne SET user = :newuser WHERE user = :name ");
$req->execute(array('newuser' => $_SESSION['login'],'name' => $_SESSION['login']));
}
else
{
//Insertion Donnees reseau
$req2 = $bdd->prepare("INSERT INTO reseauinterne (user, nomresint, nombrevm, lowerip, upperip) VALUES(?, ?, ?, ?, ?)");
$req2->execute(array($_SESSION['login'], $varloc4, $varloc1, $varloc2, $varloc3));
}
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
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."test.sh")) {
    header('Location: pageperso.php#menu3');//if ressource inexistante on renvoie a la page principale
    exit();
}
//echo '[Exec OK]';echo '<br/>';


//Affichage output commande over ssh
stream_set_blocking($stream,true);
$out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
//echo stream_get_contents($out);

//fermeture stream
fclose($stream);
//echo '<br/>';
//echo 'Creation de votre VM reusie';echo '<br/>';
?>

<?php 
//=============Ecriture dans la base de donnees VMs data====================

//Insertion Donnees VMs
$req = $bdd->prepare("INSERT INTO tableVM (nomVM, ostype, ram, ramv, harddisk, utilisateur,reseau) VALUES(?, ?, ?, ?, ?, ?, ?)");
$req->execute(array($_POST['nomVM'], $_POST['ostype'], $_POST['ram'], 12, $_POST['harddisk'], $_SESSION['login'], 'nat'));
?>

<?php 
//=============Redirection vers le menu des VMs====================
header('Location: pageperso.php#menu3');
?>

