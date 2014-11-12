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
<link href="../jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" />
<title>Dashboard</title>
<style>
td.value {
	background-image: url(images/gridline58.gif);
	background-repeat: repeat-x;
	background-position: left top;
	border-left: 1px solid #e5e5e5;
	border-right: 1px solid #e5e5e5;
	padding:0;
	border-bottom: none;
	background-color:transparent;
}
td {
	padding: 4px 6px;
	border-bottom:1px solid #e5e5e5;
	border-left:1px solid #e5e5e5;
	background-color:#fff;
}

td.value img {
	vertical-align: middle;
	margin: 5px 5px 5px 0;
}
th {
	text-align: left;
	vertical-align:top;
}
td.last {
	border-bottom:1px solid #e5e5e5;
}
td.first {
	border-top:1px solid #e5e5e5;
}
.auraltext
{
   position: absolute;
   font-size: 0;
   left: -1000px;
}
table {
	/*background-image:url(bg_fade.png);
	background-repeat:repeat-x;
	background-position:left top;*/
	width: 33em;
}
caption {
	font-size:100%;
	font-style:italic;
}
</style>
</head>

<!-- Menu Navigation -->
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
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

$mm="Minichat";
//Recuperation des messages postes
$reponse23 = $bdd->prepare("SELECT * FROM tabletest WHERE too=?");
$reponse23->execute(array($_SESSION['login']));
//Affichage des messages 
while($donnees = $reponse23->fetch())
{
?>
 <li <?php if($donnees['lu']==0){print "style='background:#0063a4;'";$mm="New Message";} ?>>
<?php
}

$reponse23->closeCursor();
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
<fieldset>
<legend id="legendvirtu">DashBoard</legend>
<!-- Infos diverses -->
<p>Adresse IP user: <?php echo $_SERVER['REMOTE_ADDR'];?></p>
<p>Port user : <?php echo $_SERVER['REMOTE_PORT'];?></p>
<p>Adresse IP serveur : <?php echo $_SERVER['SERVER_ADDR'];?></p>
<p>Port serveur : <?php echo $_SERVER['SERVER_PORT'];?></p>
<p>Nom serveur : <?php echo $_SERVER['SERVER_NAME'];?></p>
<p>Protocole Communication: <?php echo $_SERVER['SERVER_PROTOCOL'];?></p>
<p>Serveur software : <?php echo $_SERVER['SERVER_SOFTWARE'];?></p>
<p>Nombre d'inscrits : 
<?php 

$nombreapplis="30";
//recuperation pseudos
$reponse = $bdd->prepare("SELECT pseudo FROM Inscription ORDER BY ID DESC");
$reponse->execute(array($nombreapplis));

$boucle_pseudo=0;

//Affichage des donnees
while($donnees = $reponse->fetch())
{
$boucle_pseudo++;//incrementation du compteur de pseudo
}
echo $boucle_pseudo;//affichage du nombre
?>
</p>

<!-- Statistiques Applications -->
<p>
<?php 

$nombreapplis="30";
//recuperation donnees VMs
$reponse = $bdd->prepare("SELECT * FROM tableVM ORDER BY ID DESC");
$reponse->execute(array($nombreapplis));

$boucle_vm=0;

//Affichage des donnees
while($donnees = $reponse->fetch())
{
$boucle_vm++;
}

//Variables statistiques
$boucle_vlc=0;
$boucle_gedit=0;
$boucle_firefox=0;
$boucle_arduino=0;
$boucle_eagle=0;
$boucle_blender=0;
$boucle_codeblocks=0;
$boucle_fraqtive=0;
$boucle_geogebra=0;
$boucle_gelemental=0;
$boucle_gimp=0;
$boucle_googleearth=0;
$boucle_libreoffice=0;
$boucle_marble=0;
$boucle_minetest=0;
$boucle_netbeans=0;
$boucle_rhythmbox=0;
$boucle_skype=0;
$boucle_stellarium=0;
$boucle_uvision4=0;
$boucle_pspice=0;
$boucle_filezilla=0;
$boucle_gba=0;

$nombreapplis="30";
//recuperation donnees utilisateurs
$reponsee = $bdd->prepare("SELECT * FROM Inscription");
$reponsee->execute(array($nombreapplis));

while($donnees1=$reponsee->fetch())
{
$pseu=$donnees1['pseudo'];//stockage pseudo dans variable

//recuperation donnees applications
$reponse = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse->execute(array("VLC"));

//si application dans favoris pour l'utilisateur on incremente la variable pour l'application
while($donnees = $reponse->fetch())
{
if($donnees[$pseu]==1){$boucle_vlc++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Gedit"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_gedit++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Firefox"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_firefox++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Arduino"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_arduino++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Eagle"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_eagle++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Blender"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_blender++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("CodeBlocks"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_codeblocks++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Fraqtive"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_fraqtive++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Geogebra"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_geogebra++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Gelemental"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_gelemental++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Gimp"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_gimp++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Google Earth"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_googleearth++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("LibreOffice"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_libreoffice++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Marble"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_marble++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Minetest"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_minetest++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Netbeans"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_netbeans++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Rhythmbox"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_rhythmbox++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Skype"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_skype++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("Stellarium"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_stellarium++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("uVision4"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_uvision4++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("PSpice"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_pspice++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("GBA"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_gba++;}
}

//------------------------------------------------------
//recuperation donnees applications
$reponse2 = $bdd->prepare("SELECT * FROM tableApplication WHERE nomappli=?");
$reponse2->execute(array("FileZilla"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
if($donnees2[$pseu]==1){$boucle_filezilla++;}
}

}//fin boucle utilisateur

?>
</p>

<!-- Dashboard Applications -->
<p>
<table cellspacing="0" cellpadding="0" summary="Dashboard favoris">
      <caption align="top">DashBoard Favoris Applications<br /><br /></caption>
      <tr>
        <th scope="col"><span class="auraltext">Favoris</span> </th>
        <th scope="col"><span class="auraltext">Pourcentages de favoris sur page perso</span> </th>
      </tr>
      <tr>
        <td class="first">Gedit</td>
        <td class="value first"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_gedit/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_gedit/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>VLC</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_vlc/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_vlc/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Firefox</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_firefox/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_firefox/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Arduino</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_arduino/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_arduino/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Eagle</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_eagle/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_eagle/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Blender</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_blender/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_blender/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>CodeBlocks</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_codeblocks/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_codeblocks/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Fraqtive</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_fraqtive/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_fraqtive/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Geogebra</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_geogebra/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_geogebra/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Gelemental</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_gelemental/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_gelemental/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Gimp</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_gimp/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_gimp/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Google Earth</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_googleearth/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_googleearth/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Libre Office</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_libreoffice/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_libreoffice/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Marble</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_marble/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_marble/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Minetest</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_minetest/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_minetest/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Netbeans</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_netbeans/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_netbeans/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Rhythmbox</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_rhythmbox/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_rhythmbox/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
<tr>
        <td>Skype</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_skype/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_skype/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
<tr>
        <td>Stellarium</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_stellarium/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_stellarium/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
<tr>
        <td>uVison4</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_uvison4/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_uvison4/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
<tr>
        <td>PSpice</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_pspice/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_pspice/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
<tr>
        <td>FileZilla</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_filezilla/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_filezilla/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
<tr>
        <td>GBA</td>
        <td class="value last"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_gba/$boucle_pseudo)*200,0);?>" height="16" /><?php echo number_format(($boucle_gba/$boucle_pseudo)*100,0);echo '%';?></td>
      </tr>
    </table>
</p>

<!-- Statistiques VMs -->
<p>
<?php
$boucle_xppro=0;
$boucle_xpfamilial=0;
$boucle_ubuntu=0;
$boucle_fedora=0;
$boucle_opensuse=0;

//------------------------------------------------------
//recuperation donnees VMs
$reponse2 = $bdd->prepare("SELECT * FROM tableVM WHERE ostype=?");
$reponse2->execute(array("xppro"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
$boucle_xppro++;
}

//------------------------------------------------------
//recuperation donnees VMs
$reponse2 = $bdd->prepare("SELECT * FROM tableVM WHERE ostype=?");
$reponse2->execute(array("xpfamilial"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
$boucle_familial++;
}

//------------------------------------------------------
//recuperation donnees VMs
$reponse2 = $bdd->prepare("SELECT * FROM tableVM WHERE ostype=?");
$reponse2->execute(array("ubuntu"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
$boucle_ubuntu++;
}

//------------------------------------------------------
//recuperation donnees VMs
$reponse2 = $bdd->prepare("SELECT * FROM tableVM WHERE ostype=?");
$reponse2->execute(array("fedora"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
$boucle_fedora++;
}

//------------------------------------------------------
//recuperation donnees VMs
$reponse2 = $bdd->prepare("SELECT * FROM tableVM WHERE ostype=?");
$reponse2->execute(array("opensuse"));

//Affichage des donnees
while($donnees2 = $reponse2->fetch())
{
$boucle_opensuse++;
}
?>

<!-- DashBoard VMs -->
<table cellspacing="0" cellpadding="0" summary="Dashboard favoris">
      <caption align="top">DashBoard Favoris Systeme d'Exploitation VMs<br /><br /></caption>
      <tr>
        <th scope="col"><span class="auraltext">Favoris</span> </th>
        <th scope="col"><span class="auraltext">Pourcentages de favoris sur page perso</span> </th>
      </tr>
      <tr>
        <td class="first">XP pro</td>
        <td class="value first"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_xppro/$boucle_vm)*200,0);?>" height="16" /><?php echo number_format(($boucle_xppro/$boucle_vm)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>XP familial</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_xpfamilial/$boucle_vm)*200,0);?>" height="16" /><?php echo number_format(($boucle_xpfamilial/$boucle_vm)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Ubuntu</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_ubuntu/$boucle_vm)*200,0);?>" height="16" /><?php echo number_format(($boucle_ubuntu/$boucle_vm)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Fedora</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_fedora/$boucle_vm)*200,0);?>" height="16" /><?php echo number_format(($boucle_fedora/$boucle_vm)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Open Suse</td>
        <td class="value last"><img src="images/bar.png" alt="" width="<?php echo number_format(($boucle_opensuse/$boucle_vm)*200,0);?>" height="16" /><?php echo number_format(($boucle_opensuse/$boucle_vm)*100,0);echo '%';?></td>
      </tr>
    </table>

</p>

<!-- Statistiques Navigateurs -->
<p>
<?php
$nav_firefox=0;
$nav_safari=0;
$nav_chrome=0;
$nav_ie=0;
$nav_opera=0;
$nav_autres=0;

$nav_total=0;

//recuperation donnees navigateur
$reponse3 = $bdd->prepare("SELECT * FROM Navigateur WHERE navigateur=?");
$reponse3->execute(array("Firefox"));

//Affichage des donnees
while($donnees2 = $reponse3->fetch())
{
$nav_firefox=$donnees2['nbuse'];
}

//recuperation donnees navigateur
$reponse3 = $bdd->prepare("SELECT * FROM Navigateur WHERE navigateur=?");
$reponse3->execute(array("Safari"));

//Affichage des donnees
while($donnees2 = $reponse3->fetch())
{
$nav_safari=$donnees2['nbuse'];
}

//recuperation donnees navigateur
$reponse3 = $bdd->prepare("SELECT * FROM Navigateur WHERE navigateur=?");
$reponse3->execute(array("Chrome"));

//Affichage des donnees
while($donnees2 = $reponse3->fetch())
{
$nav_chrome=$donnees2['nbuse'];
}

//recuperation donnees navigateur
$reponse3 = $bdd->prepare("SELECT * FROM Navigateur WHERE navigateur=?");
$reponse3->execute(array("IE"));

//Affichage des donnees
while($donnees2 = $reponse3->fetch())
{
$nav_ie=$donnees2['nbuse'];
}

//recuperation donnees navigateur
$reponse3 = $bdd->prepare("SELECT * FROM Navigateur WHERE navigateur=?");
$reponse3->execute(array("Opera"));

//Affichage des donnees
while($donnees2 = $reponse3->fetch())
{
$nav_opera=$donnees2['nbuse'];
}

//recuperation donnees applications
$reponse3 = $bdd->prepare("SELECT * FROM Navigateur WHERE navigateur=?");
$reponse3->execute(array("Autres"));

//Affichage des donnees
while($donnees2 = $reponse3->fetch())
{
$nav_autres=$donnees2['nbuse'];
}

$nav_total=$nav_firefox+$nav_safari+$nav_chrome+$nav_opera+$nav_ie+$nav_autres;

?>

<!-- DashBoard Navigateurs -->
<table cellspacing="0" cellpadding="0" summary="Dashboard favoris">
      <caption align="top">DashBoard Navigateurs<br /><br /></caption>
      <tr>
        <th scope="col"><span class="auraltext">Navigateurs</span> </th>
        <th scope="col"><span class="auraltext">Pourcentages d'utilisation des navigateurs</span> </th>
      </tr>
      <tr>
        <td class="first">Firefox</td>
        <td class="value first"><img src="images/bar.png" alt="" width="<?php echo number_format(($nav_firefox/$nav_total)*200,0);?>" height="16" /><?php echo number_format(($nav_firefox/$nav_total)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Chrome</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($nav_chrome/$nav_total)*200,0);?>" height="16" /><?php echo number_format(($nav_chrome/$nav_total)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Safari</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($nav_safari/$nav_total)*200,0);?>" height="16" /><?php echo number_format(($nav_safari/$nav_total)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Opera</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($nav_opera/$nav_total)*200,0);?>" height="16" /><?php echo number_format(($nav_opera/$nav_total)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Internet Explorer</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($nav_ie/$nav_total)*200,0);?>" height="16" /><?php echo number_format(($nav_ie/$nav_total)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>Autres</td>
        <td class="value last"><img src="images/bar.png" alt="" width="<?php echo number_format(($nav_autres/$nav_total)*200,0);?>" height="16" /><?php echo number_format(($nav_autres/$boucle_total)*100,0);echo '%';?></td>
      </tr>
    </table>
</p>

<!-- Statistiques IP country -->
<script src="../jqvmap/jquery.min.js" type="text/javascript"></script>
<script src="../jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="../jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="../jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

<?php 
//recuperation donnees ip user
$reponse4 = $bdd->prepare("SELECT * FROM tableIP");
$reponse4->execute(array());

$paysuser=array();
$mm=0;
while($donnees = $reponse4->fetch())
{
$paysuser[$mm]=$donnees['pays'];
$mm++;
}
$reponse4->closeCursor();
$paysusernomb = count($paysuser);
?>

<?php
$bbb=0;
$france=0;$none=0;$russie=0;$usa=0;

for($bbb=0;$bbb<=$paysusernomb;$bbb++){
if($paysuser[$bbb]==='France'){$france=$france+1;} 
if($paysuser[$bbb]==='none'){$none=$none+1;} 
if($paysuser[$bbb]==='Russian Federation'){$russie=$russie+1;} 
if($paysuser[$bbb]==='United States'){$usa=$usa+1;} 
}
?>

<!-- DashBoard IP country -->
<table cellspacing="0" cellpadding="0" summary="Pays Utilisateurs">
      <caption align="top">Pays Utilisateurs<br /><br /></caption>
      <tr>
        <th scope="col"><span class="auraltext">Pays</span> </th>
        <th scope="col"><span class="auraltext">Pourcentages des provenances utilisateurs par pays</span> </th>
      </tr>
      <tr>
        <td class="first">France</td>
        <td class="value first"><img src="images/bar.png" alt="" width="<?php echo number_format(($france/$paysusernomb)*200,0);?>" height="16" /><?php echo number_format(($france/$paysusernomb)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>USA</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($usa/$paysusernomb)*200,0);?>" height="16" /><?php echo number_format(($usa/$paysusernomb)*100,0);echo '%';?></td>
      </tr>
      <tr>
        <td>Russie</td>
        <td class="value"><img src="images/bar.png" alt="" width="<?php echo number_format(($russie/$paysusernomb)*200,0);?>" height="16" /><?php echo number_format(($russie/$paysusernomb)*100,0);echo '%';?></td>
      </tr>
	<tr>
        <td>None</td>
        <td class="value last"><img src="images/bar.png" alt="" width="<?php echo number_format(($none/$paysusernomb)*200,0);?>" height="16" /><?php echo number_format(($none/$paysusernomb)*100,0);echo '%';?></td>
      </tr>
    </table>

<!-- Map IP country -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#vmap').vectorMap({
		    map: 'world_en',
		    //backgroundColor: '#333333',
		    backgroundColor: '#eef2ff',
		    color: '#ffffff',
		    hoverOpacity: 0.4,
		    selectedColor: '#666666',
		    enableZoom: true,
		    showTooltip: true,
		    values: sample_data,
		    scaleColors: ['#C8EEFF', '#006491'],
		    normalizeFunction: 'polynomial',
		    onLabelShow: function(event, label, code)
		    {
		    	if(code=='fr'){label.text("France : "+'<?php echo number_format(($france/$paysusernomb)*100,0); ?>'+' %');}
			if(code=='us'){label.text("USA : "+'<?php echo number_format(($usa/$paysusernomb)*100,0); ?>'+' %');}
			if(code=='ru'){label.text("Russie : "+'<?php echo number_format(($russie/$paysusernomb)*100,0); ?>'+' %');}
		    }
		});
	});
</script>
</br>
<div id="vmap" style="width: 600px; height: 400px;"></div>


</div>
<!--p><center>&#169 2013 Cloudi Inc Copyright | Projet</center></p-->
</body>
</html>

