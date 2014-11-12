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
<title><?php echo $session2;?></title>
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
Informations Personnelles
</div><br/>

<!-- Menu infos personnelles -->
<fieldset>
<legend id="legendinscription">InfosPerso</legend>
<div id='ftp2menu'> 
<ul>
<?php 

//Recuperation des infos
$reponse = $bdd->prepare("SELECT * FROM Inscription WHERE pseudo=?");
$reponse->execute(array($session2));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
   <li class='has-sub'><a href='#'>Email</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['email'];?></a></li>
      </ul>
   <li class='has-sub'><a href='#'>Pseudo</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['pseudo'];?></a></li>
      </ul>	
   <li class='has-sub'><a href='#'>Mot de Passe</a>
      <ul>
         <li class='active'><a href='#'>********</a></li>
      </ul>
   <li class='has-sub'><a href='#'>Nom</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['nom'];?></a></li>
         <li class='active'><a href='infosperso.php?nommodif=true'>Modifier</a></li>
      </ul>
   <li class='has-sub'><a href='#'>Prenom</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['prenom'];?></a></li>
         <li class='active'><a href='infosperso.php?prenommodif=true'>Modifier</a></li>
      </ul>
   <li class='has-sub'><a href='#'>Age</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['age'];?> ans</a></li>
         <li class='active'><a href='infosperso.php?agemodif=true'>Modifier</a></li>
      </ul>
   <li class='has-sub'><a href='#'>Ville</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['ville'];?></a></li>
         <li class='active'><a href='infosperso.php?villemodif=true'>Modifier</a></li>
      </ul>
   <li class='has-sub'><a href='#'>Pays</a>
      <ul>
         <li class='active'><a href='#'><?php echo $donnees['pays'];?></a></li>
         <li class='active'><a href='infosperso.php?paysmodif=true'>Modifier</a></li>
      </ul>
<?php
}
$reponse->closeCursor();
?>
</ul>
</div>
</fieldset>

<?php 
//action bouton modifier nom
if(isset($_GET['nommodif'])){
?>
<fieldset>
<legend id="legendinscription">Modification Nom</legend>
<form method="post" action="infosperso.php">
<input type="text" name="nommod" placeholder="newname" size="30" required />
<input type="submit" class="mybutton" value="Modifier" />
</form>
</fieldset>
<?php
}//fin isset

if(!empty($_POST['nommod'])){
//modification nom
$req = $bdd->prepare("UPDATE Inscription SET nom = :newres WHERE pseudo = :pseudo");
$req->execute(array('newres' => $_POST['nommod'],'pseudo' => $_SESSION['login']));
header('Location: infosperso.php');
exit();
}
?>

<?php 
//action bouton modifier prenom
if(isset($_GET['prenommodif'])){
?>
<fieldset>
<legend id="legendinscription">Modification Prenom</legend>
<form method="post" action="infosperso.php">
<input type="text" name="prenommod" placeholder="newname" size="30" required />
<input type="submit" class="mybutton" value="Modifier" />
</form>
</fieldset>
<?php
}//fin isset

if(!empty($_POST['prenommod'])){
//modification prenom
$req = $bdd->prepare("UPDATE Inscription SET prenom = :newres WHERE pseudo = :pseudo");
$req->execute(array('newres' => $_POST['prenommod'],'pseudo' => $_SESSION['login']));
header('Location: infosperso.php');
exit();
}
?>

<?php 
//action bouton modifier age
if(isset($_GET['agemodif'])){
?>
<fieldset>
<legend id="legendinscription">Modification Age</legend>
<form method="post" action="infosperso.php">
<input name="agemod" type="range" min="1" max="100" step="1" value="23" oninput="document.getElementById('AgeRange').textContent=value" />
<span id="AgeRange">23</span><span> ans</span>
<input type="submit" class="mybutton" value="Modifier" />
</form>
</fieldset>
<?php
}//fin isset

if(!empty($_POST['agemod'])){
//modification age
$req = $bdd->prepare("UPDATE Inscription SET age = :newres WHERE pseudo = :pseudo");
$req->execute(array('newres' => $_POST['agemod'],'pseudo' => $_SESSION['login']));
header('Location: infosperso.php');
exit();
}
?>

<?php 
//action bouton modifier ville
if(isset($_GET['villemodif'])){
?>
<fieldset>
<legend id="legendinscription">Modification Ville</legend>
<form method="post" action="infosperso.php">
<input type="text" name="villemod" placeholder="newcity" size="30" required />
<input type="submit" class="mybutton" value="Modifier" />
</form>
</fieldset>
<?php
}//fin isset

if(!empty($_POST['villemod'])){
//modification ville
$req = $bdd->prepare("UPDATE Inscription SET ville = :newres WHERE pseudo = :pseudo");
$req->execute(array('newres' => $_POST['villemod'],'pseudo' => $_SESSION['login']));
header('Location: infosperso.php');
exit();
}
?>

<?php 
//action bouton modifier pays
if(isset($_GET['paysmodif'])){
?>
<fieldset>
<legend id="legendinscription">Modification Pays</legend>
<form method="post" action="infosperso.php">
<input type="text" name="paysmod" placeholder="newcountry" size="30" required />
<input type="submit" class="mybutton" value="Modifier" />
</form>
</fieldset>
<?php
}//fin isset

if(!empty($_POST['paysmod'])){
//modification pays
$req = $bdd->prepare("UPDATE Inscription SET pays = :newres WHERE pseudo = :pseudo");
$req->execute(array('newres' => $_POST['paysmod'],'pseudo' => $_SESSION['login']));
header('Location: infosperso.php');
exit();
}
?>
<br/>
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


