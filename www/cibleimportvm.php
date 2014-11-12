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
//ressource limite
if($_SESSION['pasVM']==1){ //si limite ressources atteinte
header('Location: pageperso.php');
}
?>

<?php
//Verifie si on a inscrit quelques chose dans le formulaire
if(empty($_POST['nomVM9']))
{
header('Location: pageperso.php');
}
//----------------------------------------------------
?>

<?php
//Enleve les espaces du nom et n'autorise que lettres et chiffres
$_POST['nomVM9']=preg_replace("#[^a-zA-Z0-9]#","",$_POST['nomVM9']);
$_POST['nomVM9']=trim($_POST['nomVM9']);
$_POST['nomVM9']=str_replace(' ','',$_POST['nomVM9']);
//----------------------------------------------------
?>


<?php 
//=============Verification Nom VM====================

//On regarde les nom de vm deja crees et on refuse les VMs de meme nom pour un utilisateur donné
$namevm = $_POST['nomVM9'];
$utill= $_SESSION['login'];
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
/*
------------------------------------------------
------------------------------------------------
------------------------------------------------
       		Importe la VM 
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testimportvm.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Ajout au reseau de la VM
fputs($script,"# Importe la VM");
fputs($script,"\n");
fputs($script,"vboxmanage import /home/paco/Documents/");
fputs($script,$_POST['importVM']);
fputs($script,".ova --vsys 0 --vmname ");
fputs($script,$_POST['nomVM9']);
fputs($script," --unit 10 --disk VirtualBox\ VMs/");
fputs($script,$_POST['nomVM9']);
fputs($script,"/");
fputs($script,$_POST['nomVM9']);
fputs($script,".vmdk");
fputs($script,"\n");
fclose($script);
?>

<?php 
//Connexion au serveur SSH
$connection = ssh2_connect($_SESSION['serveur'],$_SESSION['port']);
 echo '[Connection OK]';echo '<br/>';
//Autentification login/mdp
if (!ssh2_auth_password($connection, $_SESSION['login'], $_SESSION['mdp'])) {
    header('Location: pageperso.php');//if login/mdp incorrect on renvoie sur la page principale
    exit();
}
 echo '[Auth OK]';echo '<br/>';
//Creation ressource SSH
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testimportvm.sh")) {
    echo 'nop';//header('Location: pageperso.php');//if ressource inexistante on renvoie a la page principale
    exit();
}
echo '[Exec OK]';echo '<br/>';


//Affichage output commande over ssh
stream_set_blocking($stream,true);
$out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
echo stream_get_contents($out);

fclose($stream);
?>

<?php 
//=============Ecriture dans la base de donnees VMs data====================

$oss=substr($_POST['importVM'],0,strpos($_POST['importVM'],'_'));
$disk=substr(strrchr($_POST['importVM'],'_'),1);

//Insertion Donnees VMs
$req = $bdd->prepare("INSERT INTO tableVM (nomVM, ostype, ram, ramv, harddisk, utilisateur,reseau) VALUES(?, ?, ?, ?, ?, ?, ?)");
$req->execute(array($_POST['nomVM9'], $oss, 256, 12, $disk, $_SESSION['login'], 'nat'));
?>

<?php 
//=============Redirection vers le menu des VMs====================
header('Location: pageperso.php#menu3');
?>
