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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<title>Description</title>
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

<?php
/* NOTES */
$res_rate=0;$boucle_rate=0;$boucle_pseudo=0;
//rate et pseudo
$reponse = $bdd->prepare("SELECT note FROM rateActualite2 WHERE nomcommande=?");
$reponse->execute(array($_SESSION['descactu']));
//Affichage des messages 
while($donnees = $reponse->fetch())
{
$boucle_rate=$boucle_rate+$donnees['note'];
$boucle_pseudo++;
}
$reponse->closeCursor();

$res_rate = number_format(($boucle_rate/$boucle_pseudo),1);
?>

<!-- Avis deja donne -->
<?php
$dejanote=0;
$repp1 = $bdd->prepare("SELECT ID FROM avisActualite WHERE utilisateur=? AND nomcommande=?");
$repp1->execute(array($_SESSION['login'],$_SESSION['descactu']));
$coo1=$repp1->rowCount();
if($coo1 == 1){$dejanote=1;}//si deja note
?>

<?php
$mm="Minichat";
//Recuperation des donnees actu
$reponse2 = $bdd->prepare("SELECT * FROM tableActualite WHERE nomcommande=?");
$reponse2->execute(array($_SESSION['descactu']));
//Affichage des donnees 
while($donnees = $reponse2->fetch())
{
?>

<!-- Titre page -->
<div style='margin:30px 0px 0px 0px;font-size:45px;font-style:italic;text-align:center;'>
<?php echo $donnees['nom']; ?>
</div><br/>


<script src="jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="jquery.cycle.lite.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#myslides').cycle({
		fit: 1, pause: 1, timeout: 2000
	});
});
</script>

<style>
#myslides
{
height:400px;
width:600px;
}
</style>



<!-- Description Actu -->
<fieldset>
<legend id="legendvirtu"><?php echo $donnees['nom']; ?></legend>
<img src='/images/<?php echo $donnees['nomcommande']; ?>.png' width=180 height=180 style='float:left;margin: 0 10px 10px 0;' />
<div style='border-bottom:1px solid #000;'>
<span style='font-size: 300%;'><?php echo $donnees['nom']; ?></span><br/>
<?php echo $donnees['redacteur']; ?>, Cree en <?php echo $donnees['creation']; ?><br/>
<?php echo $donnees['categorie']; ?><br/> 
<a href='<?php echo $donnees['lien']; ?>' target=_blank ><?php echo $donnees['lien']; ?></a><br/>
<form action="ciblevirtu3.php" method="post"><input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="actu" class="text"><input type="submit" class='mybutton' style='margin-top: 10px;' value="Ajouter  <?php echo $donnees['nom']; ?>" class="text"></form>
<form method='post' style='display:inline;' action="javascript:void(0)" onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $_SESSION['descactu'];?>').style.display='block';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $_SESSION['descactu']?>').style.display='block'">
<input type="submit" class="mybutton" value="Noter" />
</form>
<br/> <br/> <br/> 

</div>
<br/>
<span style='font-size: 150%;'>Description</span>  <br/>
<?php echo $donnees['description']; ?> <br/> <br/>
<span style='font-size: 150%;'>Images</span>  <br/>
<br/>

<?php
/* SlideShow *//*
$directory = 'images/slideshow/'.$donnees['nomcommande'].'/'; 	
try {    	
	// Styling for images	
	echo '<div id="myslides">';	
	foreach ( new DirectoryIterator($directory) as $item ) {			
		if ($item->isFile()) {
			$path = $directory . '/' . $item;	
			echo '<img src="' . $path . '"/>';	
		}
	}	
	echo '</div>';
}	
catch(Exception $e) {
	echo 'No images found for this slideshow.<br />';	
}*/
?>

 <br/>
<span style='font-size: 150%;'>Notes</span>  <br/>
<span style='font-size:65px;'>
<?php
echo $res_rate; 
?>
</span>
<span>
 <?php
if($res_rate==0){
?>
<img src='/images/cloudicon2bis.png' title='Non Note' style='margin:0px 0px 0px 15px;' width=60 height=60 />
<span style='margin:0px 0px 0px 15px;font-size: 20px;'>Aucun votes</span>
<?php
}
if($res_rate<=1.5 && $res_rate>0){
?>
<img src='/images/cloudicon3bis.png' title='Tres Mauvaise' style='margin:0px 0px 0px 15px;' width=60 height=60 />
<span style='margin:0px 0px 0px 15px;font-size: 20px;'><?php echo $boucle_pseudo; ?> votes au total</span>
<?php
}
if($res_rate<=2.2 && $res_rate>1.5){
?>
<img src='/images/cloudicon5bis.png' title='Mauvaise' style='margin:0px 0px 0px 15px;' width=60 height=60 />
<span style='margin:0px 0px 0px 15px;font-size: 20px;'><?php echo $boucle_pseudo; ?> votes au total</span>
<?php
}
if($res_rate<=3.2 && $res_rate>2.2){
?>
<img src='/images/cloudicon4bis.png' title='Moyenne' style='margin:0px 0px 0px 15px;' width=60 height=60 />
<span style='margin:0px 0px 0px 15px;font-size: 20px;'><?php echo $boucle_pseudo; ?> votes au total</span>
<?php
}
if($res_rate>3.2 && $res_rate<4.2){
?>
<img src='/images/cloudicon6bis.png' title='Bonne' style='margin:0px 0px 0px 15px;' width=60 height=60 />
<span style='margin:0px 0px 0px 15px;font-size: 20px;'><?php echo $boucle_pseudo; ?> votes au total</span>
<?php
}
if($res_rate>=4.2){
?>
<img src='/images/cloudicon1bis.png' title='Excellente' style='margin:0px 0px 0px 15px;' width=60 height=60 />
<span style='margin:0px 0px 0px 15px;font-size: 20px;'><?php echo $boucle_pseudo; ?> votes au total</span>
<?php
}
?>
</span>
<br/>
</fieldset>

<?php 
if($dejanote!=1){
?>
<fieldset>
<legend id="legendvirtu">Avis</legend>
<form action="cibleavisactu" method="post">
<input type="hidden" name="nomactu" value="<?php echo $donnees['nomcommande']; ?>" class="text">
<textarea type="text" name="avisactu" rows="5" cols="40" placeholder="Votre avis" required ></textarea><br /> 
<input type="submit" class="mybutton" value="Poster" />
</form>
</fieldset>
<?php 
}
if($dejanote==1){}
?>

<fieldset>
<legend id="legendvirtu">Avis</legend>
<?php
//Recuperation des 
$reponsee = $bdd->prepare("SELECT * FROM avisActualite WHERE nomcommande=?");
$reponsee->execute(array($donnees['nomcommande']));
//Affichage des 
while($donneese = $reponsee->fetch())
{
if($donneese['utilisateur']!==$_SESSION['login']){
echo $donneese['utilisateur'];echo'<br/>';echo $donneese['avis'];echo '<br/>';
}
?>

<?php 
}
$reponsee->closeCursor();
?>
</fieldset>

<?php
}
$reponse2->closeCursor();
?>

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

<!-- POPUP Rate Actualite -->
<?php
//recuperation donnees actualites dans table rate
$reponsee = $bdd->prepare("SELECT note FROM rateActualite2 WHERE utilisateur=? AND nomcommande=?");
$reponsee->execute(array($_SESSION['login'],$_SESSION['descactu']));
$cot=$reponsee->rowCount();
if($cot != 1){
?>

<!-- Fenetre popup rate -->
<div id='<?php echo 'light';echo $_SESSION['login'];echo $_SESSION['descactu'];?>' class='white_content'>
<div id='<?php echo 'rate';echo $_SESSION['login'];echo $_SESSION['descactu'];?>'>
<center style="font-size:200%;font-weight:normal;">Noter ce flux</center> <br/><br/><br/>
<span style="font-size:150%;position:absolute;left:12%;">5</span><span style="font-size:150%;position:absolute;left:30%;">4</span> <span style="font-size:150%;position:absolute;left:48%;">3</span><span style="font-size:150%;position:absolute;left:66%;">2</span><span style="font-size:150%;position:absolute;left:84%;">1</span>

<!-- very good -->
<form  style="position:absolute;top:50%;left:6%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $_SESSION['descactu'];?>" name="actuactu" class="text">
<input type="hidden" value="5" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon1bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- good -->
<form style="position:absolute;top:50%;left:24%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $_SESSION['descactu'];?>" name="actuactu" class="text">
<input type="hidden" value="4" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon6bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- medium -->
<form style="position:absolute;top:50%;left:42%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $_SESSION['descactu'];?>" name="actuactu" class="text">
<input type="hidden" value="3" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon4bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- bad -->
<form style="position:absolute;top:50%;left:60%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $_SESSION['descactu'];?>" name="actuactu" class="text">
<input type="hidden" value="2" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon5bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- very bad -->
<form style="position:absolute;top:50%;left:78%;" method='post' action='ciblerateactu.php'>
<input type="hidden" value="<?php echo $_SESSION['descactu'];?>" name="actuactu" class="text">
<input type="hidden" value="1" name="rateactu" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon3bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100><br/><br/>
</form>

</div>
<a class='closepopup' href='javascript:void(0)' onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $_SESSION['descactu'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $_SESSION['descactu'];?>').style.display='none' "><img src='/images/crossclose.png' width=90% /></a>
</div>
<div id='<?php echo 'fade';echo $_SESSION['login'];echo $_SESSION['descactu'];?>' class='black_overlay' onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $_SESSION['descactu'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $_SESSION['descactu'];?>').style.display='none' "></div>
<?php
}//if end non note
?>

</body>
</html>

