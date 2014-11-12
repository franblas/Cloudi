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

<!-- Mails -->
<fieldset>
<legend id="legendminichat">Mail</legend>
<div>
<!-- Formulaire Envoi Mail -->
<form method='post' action="javascript:void(0)" onclick="document.getElementById('lightmail').style.display='block';document.getElementById('fademail').style.display='block'">
<input type="submit" class="mybutton" value="Utilisateurs" />
</form>
</div>
<form action="minichat_recup.php" method="post">
<p>
<!-- AutoCompletion Utilisateurs -->
 <script type="text/javascript" src="autocomplete3.js"></script>
<script type="text/javascript">
window.onload = function(){initAutoComplete(document.getElementById('form-test'),
document.getElementById('champ-texte'),document.getElementById('bouton-submit'))};
</script>
<input type="text" name="champ-texte" id="champ-texte" size="20" placeholder='User' autocomplete="off" required autofocus/><br />
<textarea type="text" name="message" rows="5" cols="40" placeholder="Votre message" required ></textarea><br /> 
<input type="submit" class="mybutton" value="Poster" />
</p>
</form>
</fieldset>

<!-- Menu Mail Recus -->
<fieldset>
<legend id="legendminichat">Mail</legend>
<div id='mailmenu'>
<ul>
<?php 

$reponsee = $bdd->prepare("SELECT pseudo FROM Inscription");
$reponsee->execute(array($_SESSION['login']));
while($donneesb = $reponsee->fetch())
{

//Recuperation des 10 derniers messages postes
$reponse = $bdd->prepare("SELECT * FROM tabletest WHERE too=? AND fromm=? OR fromm=? AND too=? ORDER BY ID DESC LIMIT 1");
$reponse->execute(array($_SESSION['login'],$donneesb['pseudo'],$_SESSION['login'],$donneesb['pseudo']));
//Affichage des messages 
while($donnees = $reponse->fetch())
{
?>
<li <?php if($donnees['lu']==1 || $donnees['fromm']===$_SESSION['login']){echo "style='border:1px solid #ccc;'";} ?>><form <?php if($donnees['lu']==1 || $donnees['fromm']===$_SESSION['login']){echo "style='background-color:#ccc;color:#fff;'";}?> action="minichat_recupter.php" method="post"><?php if($donnees['fromm']===$_SESSION['login']){print $donnees['too'];}else{print $donnees['fromm'];}print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';print $donnees['datee'];print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'?><?php print substr($donnees['message'],0,60) . "...";print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?><input type="hidden" value="<?php print $donnees['message'];?>" name="msg" class="text"><input type="hidden" value="<?php if($donnees['fromm']===$_SESSION['login']){print $donnees['too'];}else{print $donnees['fromm'];}?>" name="msgfrom" class="text"><?php if($donnees['fromm']===$_SESSION['login']){?><input type="hidden" value="123" name="noupdate" class="text"><?php }else{?><input type="hidden" value="321" name="noupdate" class="text"><?php }?><input <?php if($donnees['lu']==1 || $donnees['fromm']===$_SESSION['login']){echo "style='background-color:#969696;border:none;border-bottom:3px solid #707070;'";}?> type="submit" value="Voir Message" class="text"></form></li>

<?php
}

$reponse->closeCursor();

}

$reponsee->closeCursor();
?>
</ul>
</div>
</fieldset>

<!--//////////////////////////////////////-->
<!--////////////// POPUP /////////////////-->
<!--//////////////////////////////////////-->
<?php 
$nombreactus="30";
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT pseudo FROM Inscription ORDER BY ID DESC LIMIT 0, 30");
$reponse2->execute(array($nombreactus));
?>

<!-- POPUP utilisateurs -->
<div id='lightmail' class='white_content'>
<?php while($donnees = $reponse2->fetch()){?><?php echo $donnees['pseudo'];?><br/><?php }$reponse->closeCursor();?><br/><br/><a class='closepopup' href='javascript:void(0)' onclick="document.getElementById('lightmail').style.display='none';document.getElementById('fademail').style.display='none' "><img src='/images/crossclose.png' width=90% /></a>
</div>
<div id='fademail' class='black_overlay' onclick="document.getElementById('lightmail').style.display='none';document.getElementById('fademail').style.display='none' "></div>

			</div>
			</body>
</html>
