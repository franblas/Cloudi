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
try{
	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');//connexion bdd 
}
catch(Exception $e){
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
		if(stripos($_SERVER['HTTP_USER_AGENT'],'Firefox') != 0){
		?>
			<link rel="stylesheet" href="stylefirefox.css" />
		<?php
		}
		else if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') != 0){
		?>
			<link rel="stylesheet" href="stylechrome.css" />
		<?php
		}
		else if(stripos($_SERVER['HTTP_USER_AGENT'],'msie') != 0){}
		else if(stripos($_SERVER['HTTP_USER_AGENT'],'Opera') != 0){}
		else if(stripos($_SERVER['HTTP_USER_AGENT'],'Safari') != 0){
		?>
			<link rel="stylesheet" href="stylechrome.css" />
		<?php
		}
		else{}
		?>
		<link rel="icon" href="images/favicon.ico" />

		<?php
		//chargement biblio flux RSS 
		require_once("rsslib.php");
		?>
		
		<title>Actualites</title>
		<style>
		option{
			cursor: pointer;
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
	while($donnees = $reponse->fetch()){
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
Actualites
</div><br/>

<!-- Actualités -->
<fieldset>
<legend id="legendactu">VirtuActu</legend>

<!-- Store Flux RSS -->
<!--form method='post' style="display:inline;" action="javascript:void(0)" onclick="document.getElementById('lightactu').style.display='block';document.getElementById('fadeactu').style.display='block'">
<input type="submit" class="mybutton" value="Open Store Actus" />
</form-->
<form method='post' style="display:inline;" action="store2.php">
<input type="submit" class="mybutton" value="Open Store Actus" />
</form><br/><br/>

<!-- Menu Flux RSS -->
<ul id="menu4" class="menus">
<?php 
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'pacoMySQL@35');//connexion bdd
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

$nombreapplis="30";
//recuperation donnees flux rss
$reponse = $bdd->prepare("SELECT * FROM tableActualite ORDER BY ID DESC LIMIT 0, 30");
$reponse->execute(array($nombreapplis));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
<?php 
//Verfication affichage
if($donnees["$session2"]!=0){//si flux rss dans les favoris
?>
<li>
<span>
<img src="images/<?php echo $donnees['nomcommande']; ?>.png" width="90" height="90" />
</span>

<!--form id="menuform" action="#menu4">
<input type="hidden" value="test" name="test" class="text">
<input type="submit" id="menuinput" value="<?php echo $donnees['nom']; ?>" class="text">
</form-->
<form id="menuform" method='post' action="javascript:void(0)" onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='block';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='block'">
<input type="submit" id="menuinput" value="<?php echo $donnees['nom']; ?>" />
</form>

<form id="menuform" method='post' action="cibleactudescription.php">
<input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="descactu" class="text">
<input type="submit" id="menuinput" value="Infos Actu" class="text">
</form>

<form id="menuform" action="actualite.php" method="POST">
<input type="hidden" value="<?php echo $donnees['rss']; ?>" name="dyn" class="text">
<input type="submit" id="menuinput" value="Lancer Infos" class="text" onclick="document.getElementById('loadmask').style.display='block';">
</form>

<form id="menuform" action="ciblevirtu4.php" method="POST">
<input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="actu" class="text">
<input type="submit" id="menuinput" value="Retirer Infos" class="text">
</form>

</li>
<?php
}
}
$reponse->closeCursor();
?>
</ul>
</fieldset>

<!-- Affichage du Flux RSS-->
<fieldset>
<legend id="legendrss">RSS</legend>
<!-- Ecran chargement -->
<div id='loadmask' style='display:none;'>
<img src='images/cloudload.gif' style='position:static;' /><br/>
<div style='position:static;'>Processus en cours...</div>
</div>
<?php

if (isset( $_POST ))
	$posted= &$_POST ;			
else
	$posted= &$HTTP_POST_VARS ;	


if($posted!= false && count($posted) > 0)
{	
	$url= $posted["dyn"];
	if($url != false)
	{
		echo RSS_Display($url, 15);
	}
}
?>
</fieldset>

<!--//////////////////////////////////////-->
<!--////////////// POPUP /////////////////-->
<!--//////////////////////////////////////-->
<?php 
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'pacoMySQL@35');//connexion bdd
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

$nombreactus="30";
//recuperation donnees actualites
$reponse = $bdd->prepare("SELECT * FROM tableActualite ORDER BY ID DESC LIMIT 0, 30");
$reponse->execute(array($nombreactus));
?>

<!-- POPUP store actu -->
<div id='lightactu' class='white_content'>
<?php while($donnees = $reponse->fetch()){?><!--span><img src="images/<?php echo $donnees['nomcommande']; ?>.png" width="90" height="90" /></span--><form style="display:inline;margin:25px;" action="ciblevirtu3.php" method="POST"><input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="actu" class="text"><!--input type="submit"  value="<?php echo $donnees['nom']; ?>" class="text"--><input type="image" src="/images/<?php echo $donnees['nomcommande']; ?>.png" width="90" height="90"></form><?php }$reponse->closeCursor();?><br/><br/>
<a class='closepopup' href='javascript:void(0)' onclick="document.getElementById('lightactu').style.display='none';document.getElementById('fadeactu').style.display='none' "><img src='/images/crossclose.png' width=90% /></a>
</div>
<div id='fadeactu' class='black_overlay' onclick="document.getElementById('lightactu').style.display='none';document.getElementById('fadeactu').style.display='none' "></div>

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

<!-- POPUP Rate Application -->
<?php
$nombreapplis="30";
//recuperation donnees actualite dans table favoris
$reponse = $bdd->prepare("SELECT * FROM tableActualite ORDER BY ID DESC");
$reponse->execute(array($nombreapplis));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
<?php 
//Verfication affichage 2
if($donnees["$session2"]!=0){//if favoris

//recuperation donnees applications dans table rate
$reponsee = $bdd->prepare("SELECT note FROM rateActualite2 WHERE utilisateur=? AND nomcommande=?");
$reponsee->execute(array($_SESSION['login'],$donnees["nomcommande"]));
$cot=$reponsee->rowCount();
if($cot != 1){
?>

<!-- Fenetre popup rate -->
<div id='<?php echo 'light';echo $_SESSION['login'];echo $donnees['nomcommande'];?>' class='white_content'>
<div id='<?php echo 'rate';echo $_SESSION['login'];echo $donnees['nomcommande'];?>'>
<center style="font-size:200%;font-weight:normal;">Noter ce flux</center> <br/><br/><br/>
<span style="font-size:150%;position:absolute;left:12%;">5</span><span style="font-size:150%;position:absolute;left:30%;">4</span> <span style="font-size:150%;position:absolute;left:48%;">3</span><span style="font-size:150%;position:absolute;left:66%;">2</span><span style="font-size:150%;position:absolute;left:84%;">1</span>

<!-- very good -->
<form  style="position:absolute;top:50%;left:6%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="actuactu" class="text">
<input type="hidden" value="5" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon1bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- good -->
<form style="position:absolute;top:50%;left:24%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="actuactu" class="text">
<input type="hidden" value="4" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon6bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- medium -->
<form style="position:absolute;top:50%;left:42%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="actuactu" class="text">
<input type="hidden" value="3" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon4bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- bad -->
<form style="position:absolute;top:50%;left:60%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="actuactu" class="text">
<input type="hidden" value="2" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon5bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- very bad -->
<form style="position:absolute;top:50%;left:78%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="actuactu" class="text">
<input type="hidden" value="1" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon3bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100><br/><br/>
</form>

</div>
<a class='closepopup' href='javascript:void(0)' onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='none' "><img src='/images/crossclose.png' width=90% /></a>
</div>
<div id='<?php echo 'fade';echo $_SESSION['login'];echo $donnees['nomcommande'];?>' class='black_overlay' onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='none' "></div>
<?php
}//if end non note
}//if end favoris
}//end 1st boucle
$reponse->closeCursor();
?>

</body>
</html>


