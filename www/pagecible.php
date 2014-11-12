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
<title>
<?php 
if($_POST['applications']=="uv4")
{echo uVsion4;}
elseif($_POST['applications']=="gba")
{echo GBA;}
elseif($_POST['applications']=="pspice")
{echo PSpice;}
elseif($_POST['applications']=="eclipse")
{echo Eclipse;}
else
{echo $_POST['applications'];}
?>
</title>
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
Lancement de 
<?php 
if($_POST['applications']=="uv4")
{echo uVsion4;}
elseif($_POST['applications']=="gba")
{echo GBA;}
elseif($_POST['applications']=="pspice")
{echo PSpice;}
elseif($_POST['applications']=="eclipse")
{echo Eclipse;}
else
{echo $_POST['applications'];}
?> </div><br/>

<!-- Lancement Applications --> 
<fieldset>
<center><img src='images/cloudload.gif' /></center>
<p>Un peu de patience avant que l'application se lance</p>
<p>Pour pouvoir lancer correctement 
<?php 
if($_POST['applications']=="uv4")
{echo uVsion4;}
elseif($_POST['applications']=="gba")
{echo GBA;}
elseif($_POST['applications']=="pspice")
{echo PSpice;}
elseif($_POST['applications']=="eclipse")
{echo Eclipse;}
else
{echo $_POST['applications'];}
?> veuillez accepter d'executer l'application "com.mindbright.application.Mindterm"</p>
<p>Si par erreur vous n'avez pas accepte, quittez le browser web et retentez la connexion</p>
<!--object CODETYPE='application/java-archive;version:1.6' CLASSID='java:com.mindbright.application.MindTerm.class'
          ARCHIVE='mindterm241.weaversigned.jar'-->
<applet CODE='com.mindbright.application.MindTerm.class' ARCHIVE='mindterm241.weaversigned.jar' width=0 height=0>
    <PARAM NAME='cabinets' value='mindterm_ie.cab' />   
    <PARAM NAME='sepframe' value='true' />
    <PARAM NAME='debug' value='true' />
    <PARAM NAME='protocol' value='ssh2' />
    <PARAM NAME='server' value="<?php echo $_SESSION['serveur']; ?>" />
    <PARAM NAME='port' value="<?php echo $_SESSION['port']; ?>" />
    <PARAM NAME='alive' value='60' />
    <PARAM NAME='username' value="<?php echo $_SESSION['login']; ?>" />
    <PARAM NAME='password' value="<?php echo $_SESSION['mdp']; ?>" />	 
    <PARAM NAME='quiet' value='true' />
    <PARAM NAME='80x132-enable' value='true' />
    <PARAM NAME='80x132-toggle' value='true' />
    <PARAM NAME='bg-color' value='white' />
    <PARAM NAME='fg-color' value='black' />
    <PARAM NAME='cursor-color' value='i_black' />
    <PARAM NAME='geometry' value='80x20' />
    <!--PARAM NAME='menus' value='no' /-->
    <PARAM NAME='scrollbar' value='none' />	
    <PARAM NAME='x11-forward' value='true' />
    <!--PARAM NAME='x11-display' value='127.0.0.1:0' /-->
    <PARAM NAME='compression' value='1' />	
    <PARAM NAME='commandline' value="<?php 
if($_POST['applications']=="uv4"){echo "/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."winekeil.sh";} 
elseif($_POST['applications']=="gba")
{echo "wine c:\\\\nogba\\\\nogba.exe";}
elseif($_POST['applications']=="pspice")
{echo "/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."winepspice.sh";}
elseif($_POST['applications']=="eclipse")
{echo "wine c:\\\\eclipse\\\\eclipse.exe";}		
elseif($_POST['applications']=="project64")
{echo "wine c:\\\\program files\\\\project64 1.6\\\\project64.exe";}
else
{echo $_POST['applications']; } ?>" />
   <!--/object-->
</applet>

<input type='button' class='mybutton' value='Relancer' OnClick='javascript:window.location.reload()'>

</fieldset>
</div>
</body>
</html>
