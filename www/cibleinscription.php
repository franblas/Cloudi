<?php
/*****************************
*
* Cloudi Version 0.1
* 
* Written by François Blas
* Last Modification : 11/01/14
* 
******************************/

?>
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php 
if(stripos($_SERVER['HTTP_USER_AGENT'],'Firefox') != 0)
{
?>
<link rel="stylesheet" href="stylefirefox.css" />
<?php
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') != 0)
{
?>
<link rel="stylesheet" href="stylechrome.css" />
<?php
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'msie') != 0)
{}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Opera') != 0)
{}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Safari') != 0)
{
?>
<link rel="stylesheet" href="stylechrome.css" />
<?php
}
else
{}
?>
<link rel="icon" href="images/favicon.ico" />
<title>Creation de compte</title>
</head>

<body>
<div id="corps1">
<?php
//Verifie si on a inscrit quelques chose dans le formulaire
if(empty($_POST['inscription1']) || empty($_POST['inscription']) || empty($_POST['inscriptionb']) || empty($_POST['inscription7']))
{
header('Location: index.php');
break;
}
//----------------------------------------------------
?>

<!--////////////////////////////////////////////////////-->

<?php
//Enleve les espaces du nom et n'autorise que lettres et chiffres
$_POST['inscription1']=preg_replace("#[^a-zA-Z0-9]#","",$_POST['inscription1']);
$_POST['inscription1']=trim($_POST['inscription1']);
$_POST['inscription1']=str_replace(' ','',$_POST['inscription1']);
//----------------------------------------------------
?>

<!--////////////////////////////////////////////////////-->

<?php 
//=============Verification Mot de Passe===============
$mdp=$_POST['inscription'];
$mdpb=$_POST['inscriptionb'];
//verifie que le mot de passe est le même sinon on revient au formulaire
if($mdp!=$mdpb)
{
$_SESSION['badmdp']=11;
header('Location: index.php');
break;
}
?>

<!--/////////////////////////////////////-->

<?php 
//=============Verification Pseudo====================
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'pacoMySQL@35');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

//On regarde les pseudo deja crees
//$reponse = $bdd->query("SELECT COUNT(*) AS nbr FROM Inscription WHERE pseudo=$_POST['inscription1']");
$login = $_POST['inscription1'];
$reponse = $bdd->prepare("SELECT ID FROM Inscription WHERE pseudo='$login'");
$reponse->execute(array());
$count=$reponse->rowCount();
if($count == 1)
{
$_SESSION['badpseudo']=11;
header('Location: index.php');
break;
}

?>

<!--///////////////////////////////////-->

<?php 
//=============Verification Email====================

//On regarde les emails deja crees
$email = $_POST['inscription7'];
$reponse = $bdd->prepare("SELECT ID FROM Inscription WHERE email='$email'");
$reponse->execute(array());
$count=$reponse->rowCount();
if($count == 1)
{
$_SESSION['badmail']=11;
header('Location: index.php');
break;
}

?>
<!--///////////////////////////////////-->

<?php
/*
------------------------------------------------
------------------------------------------------
------------------------------------------------
      Creation & configuration du compte
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ecriture dans un fichier personnalisé a chaque fois
$pse=$_POST['inscription1'];
$nomfichier="/home/paco/useraccount/useraccount".$pse.".sh"; 
//Ouverture du fichier en mode lecture/reecriture
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//creation variable mot de passe chiffré
fputs($script,"# Creation du mot de passe chiffré et compte");
fputs($script,"\n");
fputs($script,"varmdp=$(mkpasswd ");
fputs($script,$_POST['inscription']);
fputs($script,")");
fputs($script,"\n");
fputs($script,"sudo useradd -m -p $");
fputs($script,"varmdp ");
fputs($script,$_POST['inscription1']);
fputs($script,"\n");
fputs($script,"sudo usermod -s /usr/bin/lshell ");
fputs($script,$_POST['inscription1']);
fputs($script,"\n");
fputs($script,"# Creation dossier et fichiers scripts utilisateur");
fputs($script,"\n");
fputs($script,"cd /home/paco/");
fputs($script,"\n");
fputs($script,"mkdir Script");
fputs($script,$_POST['inscription1']);
fputs($script,"\n");
fputs($script,"cd Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testimportvm.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testexportvm.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testlistvm.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testmodram.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"test.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testbis.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testter.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testreseaunat.sh");
fputs($script,"\n");
fputs($script,"> ");
fputs($script,$_POST['inscription1']);
fputs($script,"testreseauter.sh");
fputs($script,"\n");
fputs($script,"cd ..");
fputs($script,"\n");
fputs($script,"sudo chmod -R +x Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,"\n");
fputs($script,"sudo chown -R www-data:www-data Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,"\n");
fputs($script,"# Modification lshell.conf");
fputs($script,"\n");
fputs($script,"sudo echo '' >> /etc/lshell.conf");
fputs($script,"\n");
fputs($script,"sudo echo '[");
fputs($script,$_POST['inscription1']);
fputs($script,"'] >> /etc/lshell.conf");
fputs($script,"\n");
fputs($script,"sudo echo \"overssh: ['wine','firefox','arduino','gedit','eagle','blender','codeblocks','fraqtive','geogebra','gelemental','gimp','google-earth','libreoffice','marble','minetest','netbeans','rhythmbox','skype','stellarium','vlc','filezilla',");
fputs($script,"'/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testimportvm.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testexportvm.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testlistvm.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testmodram.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"test.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testbis.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testter.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testreseau.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testreseaubis.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testreseauter.sh','/home/paco/Script");
fputs($script,$_POST['inscription1']);
fputs($script,"/");
fputs($script,$_POST['inscription1']);
fputs($script,"testreseaunat.sh']\"");
fputs($script," >> /etc/lshell.conf");
fputs($script,"\n");
fputs($script,"sudo echo '' > /home/paco/useraccount/");
fputs($script,"useraccount");
fputs($script,$_POST['inscription1']);
fputs($script,".sh");
//Fermeture du fichier
fclose($script);
?>

<!--///////////////////////////////////-->

<?php 

//Insertion données
$req = $bdd->prepare("INSERT INTO Inscription (pseudo,motdepasse,email) VALUES(?,?,?)");
$req->execute(array($_POST['inscription1'], $_POST['inscription'],$_POST['inscription7']));

//header('Location: index.php');

?>

<!--///////////////////////////////////////////-->


<?php 

$fr=0;
$fr2=$_POST['inscription1'];

//Creation colonnes dans tableApplication tableActualite pour utilisateur
$req = $bdd->prepare("ALTER TABLE tableApplication ADD $fr2 INT NOT NULL");
$req->execute(array($fr));

$reqbis = $bdd->prepare("ALTER TABLE tableApplication ALTER $fr2 SET DEFAULT '0'");
$reqbis->execute(array($fr));

$req2 = $bdd->prepare("ALTER TABLE tableActualite ADD $fr2 INT NOT NULL");
$req2->execute(array($fr));

$req2bis = $bdd->prepare("ALTER TABLE tableActualite ALTER $fr2 SET DEFAULT '0'");
$req2bis->execute(array($fr));

//Insertion données
$req3 = $bdd->prepare("INSERT INTO tablepath (user,currentpath,racine) VALUES(?,?,?)");
$req3->execute(array($_POST['inscription1'],'./','./'));

//header('Location: index.php');

?>

<!--///////////////////////////////////////////-->

<?php
/*
//===============Envoi du mail=================

$mail = $_POST['inscription7']; // Déclaration de l'adresse de destination.

if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bugs.
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "Bienvenue sur Cloudi ! \n Pour confirmer l'inscription cliquer sur le lien suivant : \n ===Lien===";
$message_html = "<html>
<head></head>
<body>
<p>Bienvenue sur Cloudi ! </p>
<p>Votre identifiant est : $pse </p>
<p>Votre mot de passe est : $mdp </p>
<p>Attention : Conservez bien vos données personnelles ! </p>
<p>Pour confirmer l'inscription cliquer sur le lien suivant : </p> 
<p>===Lien===</p>
</body>
</html>";
//==========
  
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//=====Définition du sujet.
$sujet = "Bienvenue sur Cloudi";
//=========
  
//=====Création du header de l'e-mail.
$header = "From: \"Cloudi\"<paco@cloudi.no-ip.org>".$passage_ligne;
$header.= "Reply-to: \"Cloudi\" <paco@cloudi.no-ip.org>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
//==========

*/
?>

<!--//////////////////////////////////////////-->
<p>***********************************************</p>
<p>Inscription terminee 			  </p>
<p>***********************************************</p>
<fieldset>
<p>Bienvenue sur cloudi <?php echo $_POST['inscription1']; ?> !</p>
<p>Un mail vous a ete envoye a l'adresse suivante : <?php echo $_POST['inscription7']; ?></p>
<p><a href="index.php">Revenir a la page d'accueil</a></p>
</fieldset>
<!-- /////////////////////////////////////////////////// -->
</div>
</body>
</html>
