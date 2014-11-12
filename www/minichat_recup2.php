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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<link rel="icon" href="images/favicon.ico" />
<title>MiniChat</title>
<style>

/************************/
/* 	Mail 		*/
/************************/

#mailmenu
{
  font-family: Verdana, Georgia, Arial;
  font-size:90%;
  min-width:200px;
  max-width:1000px;	
}

#mailmenu span
{
    display: block;
    float:none;
    margin:0;
    text-align: left;
    padding:0.2em 0.5em 0.4em;
    color: black;
    font-size:90%;
    font-weight:normal;
    word-wrap: break-work;	
}

#mailmenu a
{
    text-decoration:none;
    text-align:left;
    background-color:#ddd;
    border-bottom-width:0;
    color:#fff;
    display:block;
    font-size:100%;
    font-weight:bold;
    margin:0;
    padding:0.3em 0.5em;
    word-wrap: break-work;
}

#mailmenu ul li
{
    background-color:#ffffee; 
    border:1px solid #fff;
    clear:both;
    display:block;
    padding:0 0 0.5em;
    margin:1em;
}
</style>
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
<li><a href="telechargements.php">Store</a>
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
Mail
</div><br/>

<!-- Mail (bis) -->
<fieldset>
<legend id="legendminichat">Mail</legend>
<div id='mailmenu'>
<ul>
<?php 

//Recuperation du message
$reponse = $bdd->prepare("SELECT * FROM tabletest WHERE (fromm=? AND too=?) OR (too=? AND fromm=?) ORDER BY ID ASC");
$reponse->execute(array($_SESSION['msgfrom'],$_SESSION['login'],$_SESSION['msgfrom'],$_SESSION['login']));

//Affichage des messages 
while($donnees = $reponse->fetch())
{
?>
<li <?php if($donnees['fromm']===$_SESSION['login']){print "style='margin-left:330px;max-width:600px;'";}else{print "style='margin-right:50px;max-width:600px;'";} ?>><a <?php if($donnees['fromm']===$_SESSION['login']){print "style='background-color:#0063a4;'";} ?>><?php print $donnees['fromm'];print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';print $donnees['datee'];?></a><br><span><?php print $donnees['message']; ?></span></li>
<?php
}

$reponse->closeCursor();
?>
</ul>
</div>
</fieldset>

<?php 
if($_SESSION['msgfrom']!==$_SESSION['login']){
?>
<fieldset>
<legend id="legendminichat">Repondre Mail</legend>
<form action="minichat_recupbis.php" method="post">
<input type="hidden" name="champ-texte" value="<?php print $_SESSION['msgfrom']; ?>" class="text">
<textarea type="text" name="message" rows="5" cols="40" placeholder="Votre message" required ></textarea><br /> 
<input type="submit" class="mybutton" value="Repondre" />
</form>
</fieldset>
<?php
}
?>

<?php 

if($_SESSION['noupdate']==321)
{

//update variables lu
$req = $bdd->prepare("UPDATE tabletest SET lu = :newrees WHERE message = :namee");
$req->execute(array('newrees' => '1','namee' => $_SESSION['message2']));

$_SESSION['noupdate']=42;
}
?>

</div>
</body>
</html>
