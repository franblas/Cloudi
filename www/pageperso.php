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

//Variables de session
$_SESSION['connected']=1;
$_SESSION['heure']=date("H");
$_SESSION['jour']=date("d");
$_SESSION['mois']=date("m");
$_SESSION['annee']=date("Y");
$_SESSION['minute']=date("i");
$_SESSION['serveur']="10.193.244.194";
$_SESSION['port']="22";
$_SESSION['pathsftp']='';
$_SESSION['serveur_sftp']="10.193.244.194";
$_SESSION['port_sftp']="22";
$_SESSION['limiteRam']=1024; //1024 Mo
$_SESSION['limiteRom']=50; //50 Go
$_SESSION['limite_storagedata']=50000000;//50 Mo
//$_SESSION['serveur']=$_SERVER['SERVER_ADDR'];

//Connexion session
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php 
//Selection feuille de style
if(stripos($_SERVER['HTTP_USER_AGENT'],'Firefox') != 0)//si navigateur=firefox
{
?>
<link rel="stylesheet" href="stylefirefox.css" />
<?php
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') != 0)//si navigateur=chrome
{
?>
<link rel="stylesheet" href="stylechrome.css" />
<?php
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'MSIE') != 0)//si navigateur=ie
{}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Opera') != 0)//si navigateur=opera
{}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Safari') != 0)//si navigateur=safari
{
?>
<link rel="stylesheet" href="stylechrome.css" />
<?php
}
else
{}
?>
<link rel="icon" href="images/favicon.ico" />
<title>Accueil</title>
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

<!-- Ecran chargement -->
<div id='loadmask' style='display:none;'>
<img src='images/cloudload.gif' /><br/>
<div>Processus en cours...</div>
</div>

<body>
<?php
/*Calcul rom et ram restantes*/

$_SESSION['pasVM']=0; //il reste des ressources

$reponse = $bdd->prepare("SELECT * FROM tableVM WHERE utilisateur=?");
$reponse->execute(array($_SESSION['login'])); //recuperation infos dans tableVM

$compteRom = 0;
$compteRam = 0;

while($donnees = $reponse->fetch())
{
$compteRom = $compteRom + $donnees['harddisk'];//incrementation de la rom
$compteRam = $compteRam + $donnees['ram'];//incrementation de la ram
}
$reponse->closeCursor();

$limiteRom = $_SESSION['limiteRom']; //valeur limite de la rom (Go)
$limiteRam = $_SESSION['limiteRam'];//valeur limite de la ram (Mo)

$resteRom = $limiteRom - $compteRom;
$resteRam = $limiteRam - $compteRam;

if($resteRom<$limiteRom  && $resteRom>=10){$maxRom = $resteRom;}
else if($resteRom<10){$_SESSION['pasVM']=1;}//il ne reste plus de ressources 
else{$maxRom=$limiteRom;}

if($resteRam<$limiteRam && $resteRam>=256){$maxRam = $resteRam;}
else if($resteRam<256){$_SESSION['pasVM']=1;}//il ne reste plus de ressources
else{$maxRam=$resteRam;}

?>
<!--////////////////////////////////////////////////////////-->
<!--/////////////////// SCRIPT /////////////////////////////-->
<!--////////////////////////////////////////////////////////-->
<!--
<?php 
if($_SESSION['first_popup']!=1){ 
?>
<script type="text/javascript">
window.onload=function(){
document.getElementById('lightmsg').style.display='block';
document.getElementById('fademsg').style.display='block';
};
</script>
<?php 
$_SESSION['first_popup']=1;
} 
?>
-->

<div id="corps1">

<!-- Titre page -->
<div style='margin:30px 0px 0px 0px;font-size:45px;font-style:italic;text-align:center;'>
Bienvenue sur Cloudi <?php echo $_SESSION['login'];?>
</div><br/>

<?php
/*Statistiques dans bdd*/ 
if($_SESSION['firstco_ip']!=12){ //if first connexion

//variables de date
$heure=date("H");
$minute=date("i");
$seconde=date("s");
$jour=date("d");
$mois=date("m");
$annee=date("Y");

//IP country recherche
$country_v='none';
$IP_split = preg_split( '/[.]+/',$_SERVER['REMOTE_ADDR']);
$IP_val = (double) (16777216*$IP_split[0] + 65536*$IP_split[1] + 256*$IP_split[2] + $IP_split[3]);
$f_hndl = fopen('IP-country.csv','r');
while (($data = fgetcsv($f_hndl,'1000',';')) !== FALSE){
	if( ($IP_val >= $data[0]) && ($IP_val <= $data[1])) {$country_v = $data[2];break;}
}
fclose($f_hndl);

//Insertion adresse ip, date, pays, utilisateur dans bdd
$req = $bdd->prepare("INSERT INTO tableIP (Utilisateur, IPuser, pays,Jour,Mois,Annee,Heure,Minute,Seconde) VALUES(?, ?,?, ?,?,?,?,?,?)");
$req->execute(array($_SESSION['login'], $_SERVER['REMOTE_ADDR'],$country_v,$jour,$mois,$annee,$heure,$minute,$seconde));

$_SESSION['firstco_ip']=12;//annonce que ce n'est plus la 1ere connexion
}
?>
<!--///////////////////////////////////////////-->
<?php 
if($_SESSION['firstco_nav']!=14){//if first connexion

$name_nav='';

//selection navigateur
if(stripos($_SERVER['HTTP_USER_AGENT'],'Firefox') != 0)
{
$name_nav="Firefox";
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') != 0)
{
$name_nav="Chrome";
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'msie') != 0)
{
$name_nav="IE";
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Opera') != 0)
{
$name_nav="Opera";
}
else if(stripos($_SERVER['HTTP_USER_AGENT'],'Safari') != 0)
{
$name_nav="Safari";
}
else
{
$name_nav="Autres";
}


//Incrementation dans bdd
$req = $bdd->prepare("UPDATE Navigateur SET nbuse=nbuse+1 WHERE navigateur= ?");
$req->execute(array($name_nav));

$_SESSION['firstco_nav']=14;//annconce que ce n'est plus la 1ere connexion
}
?>

<!-- Menu Memos -->
<fieldset>
<legend id="legendmemo">Memo</legend>
<table>
<tr>
<td style='font-size:18px;'>
<p>
<!-- Ecriture date -->
Nous sommes le <?php print $_SESSION['jour'];?>

<?php
  switch($_SESSION['mois']) 
  {
   case 1:
   echo "Janvier"; 
   break;
   case 2:
   echo "Fevrier"; 
   break;
   case 3:
   echo "Mars"; 
   break;
   case 4:
   echo "Avril"; 
   break;
   case 5:
   echo "Mai"; 
   break;
   case 6:
   echo "Juin"; 
   break;
   case 7:
   echo "Juillet"; 
   break;
   case 8:
   echo "Aout"; 
   break;
   case 9:
   echo "Septembre"; 
   break;
   case 10:
   echo "Octobre"; 
   break;
   case 11:
   echo "Novembre"; 
   break;
   case 12:
   echo "Decembre"; 
   break;	
  }
?>
<!-- Script horloge -->
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
<?php print $_SESSION['annee'];?>, il est <font id="horloge" size="4" color="#000"></font><script>document.onload = UR_Start()</script> 
</p>
</td>
<td style='font-size:20px;text-align:center;'>
Vos Memos
</td>
</tr>
<tr>
<td style='border-right:solid 1px grey;padding:0px 40px 0px 0px;'>
<!-- Formulaire Memo -->
<form method="post" action="ciblememo.php">
<p>
<br />
<select type="select" name="jour">
	<option value="01" selected>01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
</select>
/
<select type="select" name="mois">
	<option value="01" selected>Janvier</option>
	<option value="02">Fevrier</option>
	<option value="03">Mars</option>
	<option value="04">Avril</option>
	<option value="05">Mai</option>
	<option value="06">Juin</option>
	<option value="07">Juillet</option>
	<option value="08">Aout</option>
	<option value="09">Septembre</option>
	<option value="10">Octobre</option>
	<option value="11">Novembre</option>
	<option value="12">Decembre</option>
</select>
/
<select type="select" name="annee">
	<option value="2014" selected>2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	<option value="2017">2017</option>
	<option value="2018">2018</option>
	<option value="2019">2019</option>
	<option value="2020">2020</option>
	<option value="2021">2021</option>
</select>
||
<select type="select" name="heure">
	<option value="00">00</option>	
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14" selected>14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
</select>
:
<select name="minute">
	<option value="00">00</option>
	<option value="05">05</option>
	<option value="10">10</option>
	<option value="15">15</option>
	<option value="20" selected>20</option>
	<option value="25">25</option>
	<option value="30">30</option>
	<option value="35">35</option>
	<option value="40">40</option>
	<option value="45">45</option>
	<option value="50">50</option>
	<option value="55">55</option>
</select>
<script type="text/javascript" src="calendar.js"></script>
<input type="image" src="/images/calendar.png" width=6% height=6% onclick="displayCalendarSelectBox(document.forms[0].annee,document.forms[0].mois,document.forms[0].jour,document.forms[0].heure,document.forms[0].minute,this)">
<br />
<textarea name="memo" rows="5" cols="40" placeholder="Votre memo" style='border:1px solid #ccc;' required>
</textarea>
<br /> 
<label for="envoyermemo"></label>
<input type="submit" class="mybutton" value="Enregistrer" />
</p>
</form>
</td>
<td style='padding:0px 0px 0px 60px;'>
<?php 
/* Recuperation des memos */

//Recuperation des memos
$reponse = $bdd->prepare("SELECT * FROM tableAgenda WHERE annee=? AND mois=? AND utilisateur=? AND jour>=?");
$reponse->execute(array($_SESSION['annee'],$_SESSION['mois'],$_SESSION['login'],$_SESSION['jour']));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
<p>Le <strong><?php print $donnees['Jour'];?>  
<?php
  switch($donnees['Mois']) 
  {
   case 1:
   echo "Janvier"; 
   break;
   case 2:
   echo "Fevrier"; 
   break;
   case 3:
   echo "Mars"; 
   break;
   case 4:
   echo "Avril"; 
   break;
   case 5:
   echo "Mai"; 
   break;
   case 6:
   echo "Juin"; 
   break;
   case 7:
   echo "Juillet"; 
   break;
   case 8:
   echo "Aout"; 
   break;
   case 9:
   echo "Septembre"; 
   break;
   case 10:
   echo "Octobre"; 
   break;
   case 11:
   echo "Novembre"; 
   break;
   case 12:
   echo "Decembre"; 
   break;	
  }
?> 
<?php print $donnees['Annee'];?></strong> a <strong><?php print $donnees['Heure'];?>h<?php print $donnees['Minute'];?> </strong> : <?php print $donnees['Memo']; ?></p>
<?php
}

$reponse->closeCursor();
?>
</td>
</tr>
</table>
</fieldset>

<!-- Applications -->
<fieldset id="champappli">
<legend id="legendvirtu">VirtuAppli</legend>
<!-- Store Applications -->
<!--form method='post' style="display:inline;" action="javascript:void(0)" onclick="document.getElementById('lightappli').style.display='block';document.getElementById('fadeappli').style.display='block'">
<input type="submit" class="mybutton" value="Open Store Actus" />
</form-->
<form method='post' style="display:inline;" action="store.php">
<input type="submit" class="mybutton" value="Open Store Applis" />
</form><br/><br/>

<!-- Menu Applications -->
<ul id="menu4" class="menus">
<?php 

$nombreapplis="30";
//recuperation donnees applications
$reponse = $bdd->prepare("SELECT * FROM tableApplication ORDER BY ID DESC");
$reponse->execute(array($nombreapplis));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
<?php 
//Verfication affichage
if($donnees["$session2"]!=0){//if dans les favoris
?>
<li>
<span>
<img src="images/<?php echo $donnees['nomcommande']; ?>.png" width="90" height="90" />
</span>

<!--form id="menuform" action="#menu4">
<input type="hidden" value="test" name="test" class="text">
<input type="submit" id="menuinput" value="<?php echo $donnees['nomappli']; ?>" class="text">
</form-->

<form id="menuform" method='post' action="javascript:void(0)" onclick="document.getElementById('<?php echo 'light';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='block';document.getElementById('<?php echo 'fade';echo $_SESSION['login'];echo $donnees['nomcommande'];?>').style.display='block'">
<input type="submit" id="menuinput" value="<?php echo $donnees['nomappli']; ?>" />
</form>


<form id="menuform" method='post' action="cibleapplidescription.php">
<input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="descappli" class="text">
<input type="submit" id="menuinput" value="Infos Appli" class="text">
</form>

<form id="menuform" action="pagecible.php" method="POST" target=_blank>
<input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="applications" class="text">
<input type="submit" id="menuinput" value="Lancer Appli" class="text">
</form>

<form id="menuform" action="ciblevirtu2.php" method="POST">
<input type="hidden" value="<?php echo $donnees['nomcommande']; ?>" name="appli" class="text">
<input type="submit" id="menuinput" value="Retirer Appli" class="text">
</form>

</li>
<?php
}
}

$reponse->closeCursor();
?>
</ul>
</fieldset>

<!-- Machines Virtuelles -->
<fieldset>
<legend id="legendvirtu">Vos VMs</legend>
<!-- Menu Machines Virtuelles -->
<ul id ="menu3" class="menus">
<?php 
/* Liste des VMs */
//Ouverture du fichier en mode lecture/reecriture
$nomfichier="/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testlistvm.sh"; 
$script=fopen($nomfichier,"w+");
//Identification bash
fputs($script,"#!/bin/bash");
fputs($script,"\n");
//Ajout au reseau de la VM
fputs($script,"# Liste des VMs");
fputs($script,"\n");
fputs($script,"vboxmanage list vms");
fputs($script,"\n");
fclose($script);
//Connexion au serveur SSH
$connection = ssh2_connect($_SESSION['serveur'],$_SESSION['port']);
//echo '[Connection OK]';echo '<br/>';
//Autentification login/mdp
if (!ssh2_auth_password($connection, $_SESSION['login'], $_SESSION['mdp'])) {
    header('Location: pageperso.php');//if login/mdp incorrect on renvoie sur la page principale
    exit();
}
//echo '[Auth OK]';echo '<br/>';
//Creation ressource SSH
if (!$stream = ssh2_exec($connection,"/home/paco/Script".$_SESSION['login'].'/'.$_SESSION['login']."testlistvm.sh")) {
    echo 'nop';//header('Location: pageperso.php');//if ressource inexistante on renvoie a la page principale
    exit();
}
//echo '[Exec OK]';echo '<br/>';

//Affichage output commande over ssh
stream_set_blocking($stream,true);
$out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
$printssh = stream_get_contents($out);

preg_match_all("~\"(.*?)\"~",$printssh,$reallistvms);
//print_r($reallistvms);
//echo $reallistvms[1][0];
//echo count($reallistvms[1]); //nombre de vms

fclose($stream);
?>

<?php 
//Recuperation des VMs créées en fonction de l'utilisateur connecte
$reponse = $bdd->prepare("SELECT * FROM tableVM WHERE utilisateur= ?");
$reponse->execute(array($_SESSION['login']));

//Affichage des donnees
while($donnees = $reponse->fetch())
{

for($yy=0;$yy<count($reallistvms[1]);$yy++){
if($donnees['nomVM']===$reallistvms[1][$yy]){

?>
<li>
<span>
<img src="images/<?php 
if($donnees['ostype']=="xppro" || $donnees['ostype']=="xpfamilial"){echo "xp_logo.png";}
elseif($donnees['ostype']=="fedora"){echo "fedora.png";}
elseif($donnees['ostype']=="ubuntu"){echo "ubuntu.png";}
elseif($donnees['ostype']=="opensuse"){echo "opensuse.png";}?>" width="90" height="90" />
</span>

<form id="menuform" action="ciblelancervm.php" method="POST" target=_blank>
<input type="hidden" value="<?php echo $donnees['nomVM']; ?>" name="nomVM3" class="text">
<input type="submit" id="menuinput" value="Lancer VM" class="text">
</form>

<form id="menuform" method='post' action="javascript:void(0)" onclick="document.getElementById('<?php echo 'light';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='block';document.getElementById('<?php echo 'fade';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='block'">
<input type="submit" id="menuinput" value="Infos VM" />
</form>

<form id="menuform" action="<?php 
if($donnees['reseau']=="nat"){echo "cibleajoutvmresint.php";}
else{echo "cibleajoutvmnat.php";}?>" method="POST">
<input type="hidden" value="<?php echo $donnees['nomVM']; ?>" name="<?php 
if($donnees['reseau']=="nat"){echo "nomVM5";}
else{echo "nomVM6";}?>" class="text">
<input type="submit" id="menuinput" value="<?php 
if($donnees['reseau']=="nat"){echo "Reseau Interne";}
else{echo "Reseau NAT";}?>" class="text">
</form>

<form id="menuform" action="ciblesupprimervm.php" method="POST">
<input type="hidden" value="<?php echo $donnees['nomVM']; ?>" name="nomVM4" class="text">
<input type="submit" id="menuinput" value="Supprimer VM" class="text" onclick="document.getElementById('loadmask').style.display='block';document.getElementById('corps1').style.display='none';document.getElementById('menu1').style.display='none';document.getElementById('raccourci').style.display='none'">
</form>
</li>

<?php
}}
}
$reponse->closeCursor();
?>

</ul>
</fieldset>

<!-- Machines Virtuelles Bis -->
<?php if($_SESSION['pasVM']==0){ //si creation VM autorisee (ressources non depassees)?>
<fieldset>
<legend id="legendvirtu">VirtuVM</legend>
<?php 
$pourcRom = ($compteRom/$limiteRom)*100;//rom utilisée en pourcentage
$pourcRam = ($compteRam/$limiteRam)*100;//ram utilisée en pourcentage
?>
<!-- Affichage ressources -->
<table>
<tr>
<td></td>
<td>Utilisation</td>
<td>Reste</td>
</tr>
<tr>
<td>ROM</td>
<td>
<div class='graph'>
<strong class='bar' style="width: <?php echo $pourcRom;?>%;"><span><?php echo $pourcRom;?>%</span></strong>
</div>
</td>
<td>
<?php echo $resteRom; ?> Go
</td>
</tr>
<tr>
<td>RAM</td>
<td>
<div class='graph'>
<strong class='bar' style="width: <?php echo $pourcRam;?>%;"><span><?php echo $pourcRam;?>%</span></strong>
</div>
</td><td>
<?php echo $resteRam; ?> Mo
</td>
</tr>
</table>

<!-- Formulaire creation de VMs -->
<!--p>*** Attention le nom ne doit pas comporter d'espace ni de caracteres speciaux ***</p-->
<table>
<tr style='text-align:center;font-size:28px;'><td>Creer</td><td>Importer</td><tr>
<tr>
<td style='padding:0px 50px 0px 0px;border-right:solid 1px grey;'>
<form method="post" action="ciblecreationvm.php">
<label for="nomVM">Nom de la VM </label>
<input type="text" name="nomVM" placeholder="newVM" size="30" title="Les caracteres speciaux, accents et espaces sont automatiquement corriges" required />
<br />
<label for="ostype">Choix de l'OS </label>
<select name="ostype">
    <optgroup label="Windows">
	<option title="Version : ?
Configuration Minimum 
Memoire Vive : 256 Mo
Disque Dur : 10 Go
Configuration Conseillee 
Memoire Vive : >512 Mo
Disque Dur : >80 Go" 
		value="xppro" selected>XP Pro</option>
	<option title="Version : ?
Configuration Minimum 
Memoire Vive : 256 Mo
Disque Dur : 10 Go
Configuration Conseillee 
Memoire Vive : >512 Mo
Disque Dur : >80 Go"
		value="xpfamilial">XP Familial</option>
    </optgroup>
    <optgroup label="Linux">
        <option title="Version : 12.04 LTS
Configuration Minimum 
Memoire Vive : 256 Mo
Disque Dur : 10 Go
Configuration Conseillee 
Memoire Vive : >512 Mo
Disque Dur : >80 Go"
		value="ubuntu">Ubuntu</option>
	<option title="Version : ?
Configuration Minimum 
Memoire Vive : 256 Mo
Disque Dur : 10 Go
Configuration Conseillee 
Memoire Vive : >512 Mo
Disque Dur : >80 Go"
		value="fedora">Fedora</option>
	<option title="Version : ?
Configuration Minimum 
Memoire Vive : 256 Mo
Disque Dur : 10 Go
Configuration Conseillee 
Memoire Vive : >512 Mo
Disque Dur : >80 Go"
		value="opensuse">OpenSUSE</option>
    </optgroup>
</select>
<br />
<label for="ram">Memoire vive </label>
<input name="ram" type="range" min="256" max="<?php echo $maxRam;?>" step="1" value="256" oninput="document.getElementById('AffichageRange2').textContent=value" />
<span id="AffichageRange2">256</span><span> Mo</span>
<br />
<label for="harddisk">Taille disque dur </label>
<input name="harddisk" type="range" min="10" max="<?php echo $maxRom;?>" step="1" value="10" oninput="document.getElementById('AffichageRange').textContent=value" />
<span id="AffichageRange">10</span><span> Go</span>
<br />
<!--label for="envoyerr">C'est parti ! </label-->
<input type="submit" class="mybutton" value="Creer" onclick="document.getElementById('loadmask').style.display='block';document.getElementById('corps1').style.display='none';document.getElementById('menu1').style.display='none';document.getElementById('raccourci').style.display='none'" />
</form>
</td>
<td style='padding:0px 0px 0px 50px;'>
<!-- Formulaire importation de VMs -->
<form method="post" action="cibleimportvm.php">
<label for="nomVM9">Nom de la VM </label>
<input type="text" name="nomVM9" placeholder="newVM" size="30" title="Les caracteres speciaux, accents et espaces sont automatiquement corriges" required />
<br />
<label for="importVM">Choix de la VM </label>
<select name="importVM">
    <optgroup label="Windows">
	<option value="xppro_import_10" selected>XP Pro/10 Go</option>
    </optgroup>
    <optgroup label="Linux">
        <option value="ubuntu_import_10">Ubuntu/10 Go</option>
	<option value="fedora_import_10">Fedora/10 Go</option>
    </optgroup>
</select>
<br />
<!--label for="envoyerr">C'est parti ! </label-->
<input type="submit" class="mybutton" value="Importer" onclick="document.getElementById('loadmask').style.display='block';document.getElementById('corps1').style.display='none';document.getElementById('menu1').style.display='none';document.getElementById('raccourci').style.display='none'" />
</form>
</td>
</tr></table>
</fieldset>
<?php 
}
else if($_SESSION['pasVM']==1){//si limites ressources atteintes
?>
<fieldset>
<legend id="legendvirtu">VirtuVM</legend>
<?php 
if($maxRam<256){echo 'RAM insuffisante';echo '<br/>';}
if($maxRom<10){echo 'ROM insuffisante';echo '<br/>';}
?>
Limite atteinte !!
Supprimer une VM ou modifier la RAM pour libérer des ressources
</fieldset>
<?php 
}
?>

<!--//////////////////////////////////////////////////-->

<?php
//Menu supplémentaire
if($_SESSION['login']=="testsftp")
{
?>
<fieldset>
<legend id="legendvirtu">Client SSH</legend>
<p>Lancer le <a href="standapplet.php">Client SSH</a></p>
<p>Page <a href="pagevideo.php">Test</a></p>
<p>Page <a href="dashboard.php">Dashboard</a></p>
</fieldset>
<?php
}
?>

</div>

<!--p><center>&#169 2013 Cloudi Inc Copyright | Projet</center></p-->

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

<!--//////////////////////////////////////-->
<!--////////////// POPUP /////////////////-->
<!--//////////////////////////////////////-->

<?php 
//Recuperation des VMs créées en fonction de l'utilisateur connecte
$reponse3 = $bdd->prepare("SELECT * FROM tableVM WHERE utilisateur= ?");
$reponse3->execute(array($_SESSION['login']));

//Affichage des donnees
while($donnees = $reponse3->fetch())
{
?>
<!-- POPUP VM -->
<div id='<?php echo 'light';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>' class='white_content'>
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
<td>
<form method="post" action="ciblemodifram.php"><br/>
<input type="hidden" value="<?php echo $donnees['nomVM']; ?>" name="nomVM7" class="text">
<input name="rama" type="range" min="256" max="<?php if($donnees['ram']>$maxRam){echo $donnees['ram'];}else{echo $maxRam+$donnees['ram'];}?>" step="1" value="256" oninput="document.getElementById('AffichageRange<?php echo $donnees['nomVM'];$donnees['utilisateur'];?>4').textContent=value" />
<span id="AffichageRange<?php echo $donnees['nomVM'];$donnees['utilisateur'];?>4">256</span><span> Mo</span>
<input type="submit" class="mybutton" value="Modifier" onclick="document.getElementById('loadmask').style.display='block';document.getElementById('corps1').style.display='none';document.getElementById('menu1').style.display='none';document.getElementById('<?php echo 'light';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none';document.getElementById('raccourci').style.display='none'" />
</form>
</td>
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
<td style='text-align:center;'> <span style='font-size:25px;margin:0px 12px 0px 0px;'>Exporter la VM </span></td>
<td> 
<form method="post" action="cibleexportvm.php"><br/>
<input type="hidden" value="<?php echo $donnees['nomVM']; ?>" name="nomVM8" class="text">
<input type="submit" class="mybutton" value="Exporter" onclick="document.getElementById('loadmask').style.display='block';document.getElementById('corps1').style.display='none';document.getElementById('menu1').style.display='none';document.getElementById('<?php echo 'light';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none';document.getElementById('raccourci').style.display='none'" />
</form>
</td>
</tr>
</table>
<a class='closepopup' href='javascript:void(0)' onclick="document.getElementById('<?php echo 'light';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none' "><img src='/images/crossclose.png' width=90% /></a>
</div>
<div id='<?php echo 'fade';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>' class='black_overlay' onclick="document.getElementById('<?php echo 'light';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none';document.getElementById('<?php echo 'fade';echo $donnees['utilisateur'];echo $donnees['nomVM'];?>').style.display='none' "></div>
<?php
}
$reponse->closeCursor();
?>

<!-- POPUP Rate Application -->
<?php
$nombreapplis="30";
//recuperation donnees applications dans table favoris
$reponse = $bdd->prepare("SELECT * FROM tableApplication ORDER BY ID DESC");
$reponse->execute(array($nombreapplis));

//Affichage des donnees
while($donnees = $reponse->fetch())
{
?>
<?php 
//Verfication affichage 2
if($donnees["$session2"]!=0){//if favoris

//recuperation donnees applications dans table rate
$reponsee = $bdd->prepare("SELECT note FROM rateApplication2 WHERE utilisateur=? AND nomcommande=?");
$reponsee->execute(array($_SESSION['login'],$donnees["nomcommande"]));
$cot=$reponsee->rowCount();
if($cot != 1){
?>

<!-- Fenetre popup rate -->
<div id='<?php echo 'light';echo $_SESSION['login'];echo $donnees['nomcommande'];?>' class='white_content'>
<div id='<?php echo 'rate';echo $_SESSION['login'];echo $donnees['nomcommande'];?>'>
<center style="font-size:200%;font-weight:normal;">Noter cette application</center> <br/><br/><br/>
<span style="font-size:150%;position:absolute;left:12%;">5</span><span style="font-size:150%;position:absolute;left:30%;">4</span> <span style="font-size:150%;position:absolute;left:48%;">3</span><span style="font-size:150%;position:absolute;left:66%;">2</span><span style="font-size:150%;position:absolute;left:84%;">1</span>

<!-- very good -->
<form  style="position:absolute;top:50%;left:6%;" method='post' action='ciblerateapp.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="appapp" class="text">
<input type="hidden" value="5" name="rateapp" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon1bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- good -->
<form style="position:absolute;top:50%;left:24%;" method='post' action='ciblerateapp.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="appapp" class="text">
<input type="hidden" value="4" name="rateapp" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon6bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- medium -->
<form style="position:absolute;top:50%;left:42%;" method='post' action='ciblerateapp.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="appapp" class="text">
<input type="hidden" value="3" name="rateapp" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon4bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- bad -->
<form style="position:absolute;top:50%;left:60%;" method='post' action='ciblerateapp.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="appapp" class="text">
<input type="hidden" value="2" name="rateapp" class="text">
<input type='image' src='/images/cloudicon2bis.png' onMouseOver="this.src='/images/cloudicon5bis.png'" onMouseOut="this.src='/images/cloudicon2bis.png'" width=100 height=100>
</form>

<!-- very bad -->
<form style="position:absolute;top:50%;left:78%;" method='post' action='ciblerateapp.php'>
<input type="hidden" value="<?php echo $donnees['nomcommande'];?>" name="appapp" class="text">
<input type="hidden" value="1" name="rateapp" class="text">
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
