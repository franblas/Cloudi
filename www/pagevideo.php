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
if($_SESSION['login']!="testsftp"){header('Location: index.php');}
?>
<html>
<head>
<?php
require_once("lecturedossier.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width"/>
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
<title>Tests</title>
</head>

<header>
<ul id="menu1" class="menus">
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
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');//connexion bdd
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}
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

<center>
<object type="application/x-shockwave-flash" data="player_flv_multi.swf" width="512" height="384">
<param name="movie" value="player_flv_multi.swf" />
<param name="allowFullScreen" value="true" />
<param name="flashvars" value="flv=DaocTrailer.flv|moskau.flv&amp;title=DaocTrailer|Moskau&amp;showstop=1&amp;showvolume=1&amp;showfullscreen=1&amp;showmouse=autohide&amp;showiconplay=1&amp;autonext=0&amp;buttonovercolor=333333&amp;sliderovercolor=333333&amp;titlecolor=000000&amp;loadingcolor=ffffff&amp;playlisttextcolor=333333&amp;currentflvcolor=ffffff&amp;" />
</object>
</center>
<!--///////////////////////////////////////////-->
<p>Navigateur = 
<?php 
if(stripos($_SERVER['HTTP_USER_AGENT'],'Firefox') != 0)
{echo "Firefox";}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') != 0)
{echo "Chrome";}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'msie') != 0)
{echo "Internet Explorer";}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Opera') != 0)
{echo "Opera";}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Safari') != 0)
{echo "Safari";}
else
{echo "Navigateur inconnu";}
?>
</p>
<!--//////////////////////////////////////////////////////////-->
<p>
<!--?php
$dir = '/home/' . $session2;
echo 'Taille du dossier de ';
echo $session2;
echo ' : ' . unite(poids($dir));
?-->
</p>

<fieldset>
<legend>Test creation colonne</legend>
<p>
<form method="post" action="ciblevideo.php" >
<input type="text" name="test1" placeholder="user" size="30" autofocus required />
<input type="submit" value="New Colonne" />
</form>
</p>
<!--///////////////////////////////////////////////////-->
<p>
<form method="post" action="ciblevideo.php" >
<!--input type="number" /-->
<label for="rom">Taille Disque Dur</label>
<input name="rom" type="range" min="10" max="50" step="1" value="20" oninput="document.getElementById('AffichageRange').textContent=value" />
<span id="AffichageRange">20</span><span> Go</span>
<br />
<label for="ram">Mémoire vive</label>
<input name="ram" type="range" min="256" max="2048" step="1" value="512" oninput="document.getElementById('AffichageRange2').textContent=value" />
<span id="AffichageRange2">512</span><span> Mo</span>
<input type="submit" value="Test" />
</form>
</p>
</fieldset>
<br/>
<fieldset>
<div id='ftp2menu'>
<ul>
   <li class='active'><a href='#'>Racine</a></li>
   <li class='has-sub'><a href='#'>éàgkljmkfmkfmzlfmezjfpzpfkjaùfkakùakfak.jpeg</a>
      <ul>
         <li class='active'><a href='#'>Telecharger</a></li>
         <li class='active'><a href='#'>Aperçu</a></li>
	 <li class='active'><a href='#'>Supprimer</a></li>
      </ul>	
   <li class='has-sub'><a href='#'>Fichier2</a>
      <ul>
         <li class='active'><a href='#'>Telecharger</a></li>
	 <li class='active'><a href='#'>Aperçu</a></li>
         <li class='active'><a href='#'>Supprimer</a></li>
      </ul>
   <li class='active'><a href='#'>Dossier1</a></li>
   <li class='has-sub'><a href='#'>Fichier3</a>
      <ul>
         <li class='active'><a href='#'>Telecharger</a></li>
	 <li class='active'><a href='#'>Aperçu</a></li>
         <li class='active'><a href='#'>Supprimer</a></li>
      </ul>
   <li class='has-sub'><a href='#'>Fichier4</a>
      <ul>
         <li class='active'><a href='#'>Telecharger</a></li>
         <li class='active'><a href='#'>Aperçu</a></li>
         <li class='active'><a href='#'>Supprimer</a></li>
      </ul>
</ul>
</div>
</fieldset>



<fieldset>
<legend>Test limitation ressources</legend>
<p>
<?php $str= unite(poids('./images/'));echo $str;?>
</p>
<!--/////////////////////////////////////////-->
<p>
<?php
/*script php a mettre en debut de pageperso.php*/
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

$reponse = $bdd->prepare("SELECT * FROM tableVM WHERE utilisateur=?");
$reponse->execute(array($_SESSION['login']));

$compteRom = 0;
$compteRam = 0;

while($donnees = $reponse->fetch())
{
$compteRom = $compteRom + $donnees['harddisk'];
$compteRam = $compteRam + $donnees['ram'];
}
$reponse->closeCursor();
echo 'Rom = ';echo $compteRom;echo '  ';
echo 'Ram = ';echo $compteRam;

$limiteRom = 50;
$limiteRam = 1024;

$resteRom = $limiteRom - $compteRom;
$resteRam = $limiteRam - $compteRam;

/*$_SESSION['pasVM']=0;*/

if($resteRom<50 && $resteRom>=10){$maxRom = $resteRom;}
else if($resteRom<10){/*enlever possibilité creation VM*/ /*$_SESSION['pasVM']=1;*/}
else{$maxRom=50;}

if($resteRam<512 && $resteRam>=256){$maxRam = $resteRam;}
else if($resteRam<256){/*enlever possibilité creation VM*/ /*$_SESSION['pasVM']=1;*/}
else{$maxRam=512;}

?>
</p>

<label for="rom">Taille Disque Dur</label>
<input name="rom" type="range" min="10" max="<?php echo $maxRom;?>" step="1" value="10" oninput="document.getElementById('AffichageRangee').textContent=value" />
<span id="AffichageRangee">10</span><span> Go</span>
<br />
<label for="ram">Mémoire vive</label>
<input name="ram" type="range" min="256" max="<?php echo $maxRam;?>" step="1" value="256" oninput="document.getElementById('AffichageRangee2').textContent=value" />
<span id="AffichageRangee2">256</span><span> Mo</span>

<p>memoire vive</p>
<p>disque dur vm</p>
</fieldset>

<fieldset>
<legend>Test autocompletion</legend>
 <script type="text/javascript" src="autocomplete.js"></script>
<script type="text/javascript">
window.onload = function(){initAutoComplete(document.getElementById('form-test'),
document.getElementById('champ-texte'),document.getElementById('bouton-submit'))};
</script>

<!--script>
var tata = document.getElementById('champ-texte')
</script-->
<!--?php
$Titre = "<script>document.write(tata.value);</script>";
echo $Titre;
?-->

<form name="form-test" id="form-test" method='post' action="pagevideo.php" style="margin-left: 50px; margin-top:20px">
            <input type="text" name="champ-texte" id="champ-texte" size="20" autocomplete="off" />
            <input type="submit" id="bouton-submit">
</form>

<?php 
echo $_POST['champ-texte'];
?>

<!--script>
window.onload=function(){
document.getElementById('lightactu').style.display='block';
document.getElementById('fadeactu').style.display='block';
};
</script-->
<!--script>
function f()
{
   var obj = document.getElementById("champ-texte")
   //alert('le champ a pour valeur : "'+obj.value+"'");
}
</script-->
<!--?php
$Titre = "<script>document.write(obj.value);</script>";
echo $Titre;
?-->

<a href='options.php?debut=f'>Applications debutants par f</a>
<p>
<?php echo ''.$_SESSION['login'].'/'.$_SESSION['login'].''; ?>
</p>
</fieldset>
<fieldset>
<legend>Test horloge</legend>
<script type="text/javascript">
function UR_Start() 
{
	UR_Nu = new Date;
	UR_Indhold = showFilled(UR_Nu.getHours()) + ":" + showFilled(UR_Nu.getMinutes()) + ":" + showFilled(UR_Nu.getSeconds());
	document.getElementById("horloge").innerHTML = UR_Indhold;
	setTimeout("UR_Start()",1000);
}
function showFilled(Value) 
{
	return (Value > 9) ? "" + Value : "0" + Value;
}
</script>
<font id="horloge" size="4" color="#000"></font> 
<script>document.onload = UR_Start()</script>
</fieldset>

<fieldset>
<legend>test path</legend>
<?php 
$essairac='/hh/hh/lol/';
//$enl = strrpos($essairac,'/');
$end=substr_replace($essairac,'',strrpos($essairac,'/'));
$ennd=substr_replace($end,'',strrpos($end,'/'));
$ennd=$ennd.'/';
echo $ennd;
;?>
</fieldset>

<fieldset>
<legend>test x11 ssh2.exec</legend>
<?php 
/*
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
if (!$stream = ssh2_exec($connection,"vboxmanage showvminfo ahoui")) {
    echo 'nop';//header('Location: pageperso.php');//if ressource inexistante on renvoie a la page principale
    exit();
}
echo '[Exec OK]';echo '<br/>';


//Affichage output commande over ssh
stream_set_blocking($stream,true);
$out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
echo stream_get_contents($out);


fclose($stream);
*/
?>
</fieldset>

<fieldset>
<legend>test import vm</legend>
<?php 
/*
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
if (!$stream = ssh2_exec($connection,"vboxmanage import /home/paco/Documents/fedora_import_10.ova --vsys 0 --vmname newubunt --unit 10 --disk VirtualBox\ VMs/newubunt/newubunt.vmdk")) {
    echo 'nop';//header('Location: pageperso.php');//if ressource inexistante on renvoie a la page principale
    exit();
}
echo '[Exec OK]';echo '<br/>';


//Affichage output commande over ssh
stream_set_blocking($stream,true);
$out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
echo stream_get_contents($out);

fclose($stream);
*/
?>
</fieldset>




<fieldset>
<legend>test rating</legend>
<!--img src='/images/cloudicon1.png' width=4% height=4% />
<img src='/images/cloudicon2.png' width=4% height=4% /-->

<!-- Bouton Fenetre popup rate -->
<form method='post' style="display:inline;" action="javascript:void(0)" onclick="document.getElementById('lightappli').style.display='block';document.getElementById('fadeappli').style.display='block'">
<input type="submit" id="menuinput" class="text" value="Open Store Actus" />
</form>

<!-- Fenetre popup rate -->
<div id='lightappli' class='white_content'>
<center style="font-size:200%;font-weight:normal;">Rate this application</center> <br/>
<span style="font-size:150%;position:absolute;left:20%;">Good</span><span style="font-size:150%;position:absolute;right:43%;">Medium</span> <span style="font-size:150%;position:absolute;right:20%;">Bad</span>

<!-- good -->
<form style="position:absolute;top:50%;left:17%;" method='post' action='ciblevideo.php' >
<input type="hidden" value="3" name="test" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon1bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=50% height=50%>
</form>

<!-- medium -->
<form style="position:absolute;top:50%;left:44%;" method='post' action='ciblevideo.php'>
<input type="hidden" value="2" name="test" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon4bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=50% height=50%>
</form>

<!-- bad -->
<form style="position:absolute;top:50%;left:70%" method='post' action='ciblevideo.php'>
<input type="hidden" value="1" name="test" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon3bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=50% height=50%><br/><br/>
</form>

<a class='closepopup' href='javascript:void(0)' onclick="document.getElementById('lightappli').style.display='none';document.getElementById('fadeappli').style.display='none' "><img src='/images/crossclose.png' width=90% /></a>
</div>
<div id='fadeappli' class='black_overlay' onclick="document.getElementById('lightappli').style.display='none';document.getElementById('fadeappli').style.display='none' "></div>

</fieldset>

<p><a href="pageperso.php">Page Perso</a></p>
</div>
</body>
</html>
