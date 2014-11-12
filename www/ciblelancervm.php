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

<!-- Debut Page html -->
<html>
<head>
<title><?php echo $_POST['nomVM3']; ?></title>
<meta name="viewport" content="width=device-width"/>
<?php
//Selection feuille de style 
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
</head>

<!-- Menu Navigation -->
<header>
<ul id="menu1" class="menus">
<img src='/images/cloudicon1bis.png' width=40 height=40 style='position:relative;top:15;right:5;' />
 <li class="actif">
  <a href="infosperso.php"><?php echo $_SESSION['login'];?></a>
   <span></span>
 </li>
 <li>
  <a href="pageperso.php">PagePerso</a>
   <span></span>
 </li>
 <li>
  <a href="actualite.php">Actualites</a>
   <span></span>
 </li>
<?php
$mm="Minichat";
//Recuperation des messages postes
$reponse = $bdd->prepare("SELECT * FROM tabletest WHERE too=?");
$reponse->execute(array($_SESSION['login']));
//Affichage des messages 
while($donnees = $reponse->fetch())
{
?>
 <li <?php if($donnees['lu']==0){print "style='background:#0063a4;'";$mm="New Message";} ?>>
<?php
}

$reponse->closeCursor();
?>
  <a href="minichat.php"><?php echo $mm;?></a>
   <span></span>
 </li>
 <li>
  <a href="fichier.php">Fichiers</a>
   <span></span>
 </li>
<li><a href="telechargements.php">Telechargements</a>
   <span></span>
 </li> 
<li><a href="deconnexion.php">Deconnexion</a>
   <span></span>
 </li>
</ul>
</header>


<body>
<div id="corps1">

<!-- Titre page -->
<div style='margin:30px 0px 0px 0px;font-size:45px;font-style:italic;text-align:center;'>
Lancement de <?php echo $_POST['nomVM3']; ?>
</div><br/>

<fieldset>
<center><img src='images/cloudload.gif' /></center>
<?php 
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'pacoMySQL@35');//connexion bdd
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

//Recuperation infos sur la VM
$reponse = $bdd->prepare("SELECT * FROM tableVM WHERE nomVM = ? AND utilisateur = ?");
$reponse->execute(array($_POST['nomVM3'], $_SESSION['login'])); 

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
<div style='border-bottom:1px solid grey;'>
<img style='' src="images/<?php if($donnees['ostype']=="xppro" || $donnees['ostype']=="xpfamilial"){echo "xp_logo.png";} elseif($donnees['ostype']=="fedora"){echo "fedora.png";} elseif($donnees['ostype']=="ubuntu"){echo "ubuntu.png";} elseif($donnees['ostype']=="opensuse"){echo "opensuse.png";}?>" width="90" height="90" />
<span style='font-size:40px;margin:0px 0px 0px 25px;'><?php echo $donnees['nomVM']; ?></span><br/>
</div> <br/>
<table>
<tr>
<td style='text-align:center;'><span style='font-size:25px;margin:0px 12px 0px 0px;'> OS </span></td> 
<td><?php print $donnees['ostype']; ?></td> 
</tr>
<tr>
<td style='text-align:center;'><span style='font-size:25px;margin:0px 12px 0px 0px;'> Memoire Vive </span></td>
<td> <?php print $donnees['ram'];print ' Mo'; ?></td>
</tr>
<tr>
<td style='text-align:center;'><span style='font-size:25px;margin:0px 12px 0px 0px;'> Memoire Video </span></td>
<td> <?php print $donnees['ramv'];print ' Mo';?></td> 
</tr>
<tr>
<td style='text-align:center;'><span style='font-size:25px;margin:0px 12px 0px 0px;'> Disque Dur </span></td>
<td> <?php print $donnees['harddisk'];print ' Go'; ?></td> 
</tr>
<tr>
<td style='text-align:center;'> <span style='font-size:25px;margin:0px 12px 0px 0px;'>Reseau </span></td>
<td> <?php {print $donnees['reseau'];}?></td>
</tr>
<tr>
</tr>
</table>
<?php
}

$reponse->closeCursor();
?>

<?php 
/*
------------------------------------------------
------------------------------------------------
------------------------------------------------
             Lancement de la VM
------------------------------------------------
------------------------------------------------
------------------------------------------------
*/
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testter.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Lancement de la VM
fputs($script,"# Lancement de la VM");
fputs($script,"\n");
fputs($script,"vboxsdl --startvm ");
fputs($script,$_POST['nomVM3']);
fputs($script,"\n");
//Fermeture du fichier
fclose($script);
?>

<applet CODE='com.mindbright.application.MindTerm.class' ARCHIVE='mindterm241.weaversigned.jar' WIDTH='0' HEIGHT='0'>
<!--object CODETYPE='application/java-archive' CLASSID='java:com.mindbright.application.MindTerm.class' ARCHIVE='mindterm241.weaversigned.jar'-->
    <PARAM NAME='cabinets' value='mindterm_ie.cab'>
    <PARAM NAME='sepframe' value='true'>
    <PARAM NAME='debug' value='true'>
    <PARAM NAME='protocol' value='ssh2' />
    <PARAM NAME='quiet' value='true' />
    <PARAM NAME='server' value="<?php echo $_SESSION['serveur']; ?>" />
    <PARAM NAME='port' value="<?php echo $_SESSION['port']; ?>" />
    <PARAM NAME='username' value="<?php echo $_SESSION['login']; ?>" />
    <PARAM NAME='password' value="<?php echo $_SESSION['mdp']; ?>" />	
    <PARAM NAME='alive' value='60' />
    <PARAM NAME='80x132-enable' value='true' />
    <PARAM NAME='80x132-toggle' value='true' />
    <PARAM NAME='bg-color' value='white' />
    <PARAM NAME='fg-color' value='black' />
    <PARAM NAME='cursor-color' value='i_black' />
    <PARAM NAME='geometry' value='80x20' />
    <!--PARAM NAME='menus' value='no' /-->
    <PARAM NAME='scrollbar' value='none' />
    <!--PARAM NAME='sepframe' value='false' /-->
    <PARAM NAME='x11-forward' value='true' />
    <PARAM NAME='compression' value='1' />	
    <PARAM NAME='commandline' value="/home/paco/Script<?php echo ''.$_SESSION['login'].'/'.$_SESSION['login'].''; ?>testter.sh" />
   <!--/object-->
</applet>
</fieldset>

</div>
</body>
</html>
