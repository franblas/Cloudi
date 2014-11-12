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
<title>Store</title>
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
Store Actualites
</div><br/>


<!-- Menu store actualites -->
<fieldset>
<legend id="legendvirtu">Store Actus</legend>

<!-- AutoCompletion Flux RSS -->
 <script type="text/javascript" src="autocomplete2.js"></script>
<script type="text/javascript">
window.onload = function(){initAutoComplete(document.getElementById('form-test'),
document.getElementById('descactu'),document.getElementById('bouton-submit'))};
</script>
<center><form name="form-test" id="form-test" method='post' action="cibleactudescription.php" style="margin:10px;display:inline-block;">
<input type="text" name="descactu" id="descactu" size="20" placeholder='Recherche' autocomplete="off" style='font-size:22px;width:150%;border: 1px solid grey;' />
<!--input type="submit" id="bouton-submit"-->
</form></center>
<br/><br/>

<?php 
$nombreapplis="30";
//recuperation donnees applications
$reponsee = $bdd->prepare("SELECT * FROM tableActualite ORDER BY ID DESC");
$reponsee->execute(array($nombreapplis));
?>

<ul style='text-align:center;'>
<?php 
while($donneess = $reponsee->fetch()){
?>
<li style='display:inline-block;position:relative;'>
<div id='divact<?php echo $donneess['nomcommande']; ?>' style='background:#fff;border-radius:5px 5px 0px 0px;box-shadow:3px 3px 3px grey;'>
<form style="display:inline;margin:10px;" action="cibleactudescription.php" method="post">
<input type="hidden" value="<?php echo $donneess['nomcommande']; ?>" name="descactu" class="text">
<input type="image" src="/images/<?php echo $donneess['nomcommande']; ?>.png" width="90" height="90" style='margin-top:10px;' onMouseOver="document.getElementById('divact<?php echo $donneess['nomcommande']; ?>').style.opacity='0.6';this.style.opacity='0.6';document.getElementById('divact<?php echo $donneess['nomcommande']; ?>').style.boxShadow='3px 0px 3px grey';" onMouseOut="document.getElementById('divact<?php echo $donneess['nomcommande']; ?>').style.opacity='1';this.style.opacity='1';document.getElementById('divact<?php echo $donneess['nomcommande']; ?>').style.boxShadow='3px 3px 3px grey';">
</form>
</div>
<div style='background:#fff;margin-bottom:10px;text-align:center;border-radius:0px 0px 5px 5px;box-shadow:3px 3px 3px grey;'>
<?php echo $donneess['nom']; ?>
</div>
</li>
<?php 
}
$reponsee->closeCursor();
?>

</ul>
</fieldset>

</div>

<!-- Raccourci Gauche -->
<div id='raccourci' title='Raccourci Store' onclick="document.getElementById('raccourci2').style.display='block';document.getElementById('raccourcibis').style.display='block';document.getElementById('raccourci').style.display='none';">
<center><span style='font-size:20px;cursor:pointer;'>></span></center>
</div>
<div id='raccourcibis' style='display:none;' onclick="document.getElementById('raccourci2').style.display='none';document.getElementById('raccourci').style.display='block';document.getElementById('raccourcibis').style.display='none';">
<center><span style='font-size:20px;cursor:pointer;'><</span></center>
</div>

<div id='raccourci2'>
<center>
Store
<a href='store2.php'><img src='/images/iconactu' title='Store Actualites' onMouseOver="this.style.opacity=0.6;" onMouseOut="this.style.opacity=1;"/></a>
<a href='store.php'><img src='/images/iconappli' title='Store Applications' onMouseOver="this.style.opacity=0.6;" onMouseOut="this.style.opacity=1;"/></a>
</center>
</div>

</body>
</html>

