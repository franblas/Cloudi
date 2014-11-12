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

<?php
//chargement biblio poids dossier
require_once("lecturedossier.php");
?>

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
<title>Fichiers</title>
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
Fichiers
</div><br/>

<fieldset>
<legend id="legendvirtu">Virtu SFTP</legend>
<div id='ftp2menu'> 
<ul>
<?php
//Connexion au serveur SFTP
$connection = ssh2_connect($_SESSION['serveur_sftp'],$_SESSION['port_sftp']);
 
//Autentification login/mdp
if (!ssh2_auth_password($connection, $_SESSION['login'], $_SESSION['mdp'])) {
    header('Location: pageperso.php');//if login/mdp incorrect on renvoie sur la page principale
    exit();
}
 
//Creation ressource SFTP
if (!$sftp = ssh2_sftp($connection)) {
    header('Location: pageperso.php');//if ressource inexistante on renvoie a la page principale
    exit();
}
 
//Liste des fichiers/dossiers
$files = array();
$dirHandle = opendir("ssh2.sftp://$sftp/".$_SESSION['pathsftp']);
 
//On scanne l'ensemble des fichiers/dossiers en ignorant les dossiers '.' et '..'
while (false !== ($file = readdir($dirHandle))) {
    if ($file != '.' && $file != '..' && stripos($file,'.')!==0) {
        $files[] = $file;
    }
}

//calcul taille dossier /home/user 
$limite_storagedata=$_SESSION['limite_storagedata'];// limite : 50Mo
$reslim = number_format(((poids("ssh2.sftp://$sftp/")-poids("ssh2.sftp://$sftp/VirtualBox VMs/"))/$limite_storagedata)*100,0);
?>
<div class='graph'>
Utilisation Espace Stockage<strong class='bar' style="width: <?php echo $reslim;?>%;"><span><?php echo $reslim;?>%</span></strong>
</div>
<li class='has-sub'><a href='#'>Navigation</a>
      <ul>
         <li class='active'><a href='fichier.php?racinesftp=true'>Racine</a></li>
	 <li class='active'><a href='fichier.php?precsftp=true'>Dossier prec</a></li>
      </ul><br/>
<?php
//action bouton racine
if(isset($_GET['racinesftp'])){
$_SESSION['pathsftp']='';
header('Location: fichier.php');
exit();
}//fin isset

//action bouton precedent dossier
if(isset($_GET['precsftp'])){
$endpath=substr_replace($_SESSION['pathsftp'],'',strrpos($_SESSION['pathsftp'],'/'));
$ennd=substr_replace($endpath,'',strrpos($endpath,'/'));
$ennd=$ennd.'/';
$_SESSION['pathsftp']=$ennd;
header('Location: fichier.php');
exit();
}//fin isset

//Creation du menu pour les fichiers
$tre=0;
if (count($files)) {
    foreach ($files as $fileName) {
if(is_file("ssh2.sftp://$sftp/".$_SESSION['pathsftp']."$fileName")==true){//si c'est un fichier
?>

<li class='has-sub'><a href='#'><?php echo $fileName;?></a>
      <ul>
         <li class='active'><a href='fichier.php?<?php echo $tre;?>=true'>Telecharger</a></li>
         <li class='active'><a href='fichier.php?<?php echo $tre;?>b=true'>Supprimer</a></li>
      </ul>
<?php
//action bouton supprimer
if(isset($_GET[''.$tre.'b'])){
unlink("ssh2.sftp://$sftp/".$_SESSION['pathsftp']."$fileName");
header('Location: fichier.php');
exit();
}//fin isset

//action bouton telecharger

if(isset($_GET[''.$tre.''])){
	$filee = "ssh2.sftp://$sftp/".$_SESSION['pathsftp']."$fileName";
	if (file_exists($filee)) {
		session_write_close();
    		header('Content-Description: File Transfer');
    		header('Content-Type: application/octet-stream');
    		header('Content-Disposition: attachment; filename="'.basename($filee).'"');
    		header('Content-Transfer-Encoding: binary');
    		header('Expires: 0');
		header('Cache-Control: must-revalidate');
    		header('Pragma: public');
    		header('Content-Length: '.filesize($filee));
		ob_clean();
    		flush();
		set_time_limit(0);
    		readfile($filee);
    		exit;
	}//fin fileexist
}//fin isset
$tre++;
}//fin if isfile

else if(!is_file("ssh2.sftp://$sftp/".$_SESSION['pathsftp']."$fileName")){//si c'est un dossier
if($fileName!=="VirtualBox VMs"){//Ne pas afficher dossier VMs
?>
<li class='has-sub'><a href='#' style="background-color:black;"><?php echo $fileName;?></a>
      <ul>
         <li class='active'><a href='fichier.php?<?php echo $tre;?>c=true'>Ouvrir</a></li>
         <li class='active'><a href='fichier.php?<?php echo $tre;?>a=true'>Supprimer</a></li>
      </ul>
<?php
//action bouton supprimer
if(isset($_GET[''.$tre.'a'])){
rmdir("ssh2.sftp://$sftp/".$_SESSION['pathsftp']."".$fileName);
header('Location: fichier.php');
exit();
}//fin isset

//action bouton ouvrir
if(isset($_GET[''.$tre.'c'])){
$_SESSION['pathsftp']=$_SESSION['pathsftp']."".$fileName."/";
header('Location: fichier.php');
exit();
}//fin isset
}//fin ifVirtualbox
}//fin elseifdir

    }//fin foreach
}//fin ifcount
?>
</ul>
</div>
</fieldset>

<?php 
if($reslim <= 100){//s'il reste de la mémoire dans espace de stockage 
?>
<!-- Formulaire Ajout Dossier -->
<fieldset>
<legend id="legenddossier">Ajout Dossier</legend>
<form method="post" action="fichier.php" >
<input type="text" name="newfolder" placeholder="folder" size="30" autofocus required />
<input type="submit" class="mybutton" value="New Folder" />
</form>
<?php 
if(!empty($_POST['newfolder'])){
mkdir("ssh2.sftp://$sftp/".$_SESSION['pathsftp']."".$_POST['newfolder']);
header('Location: fichier.php');
exit();
}
?>
</fieldset>

<!-- Formulaire Upload Fichier -->
<fieldset>
<legend id="legendupload">Upload Fichier</legend>
<form method="post" action="fichier.php" enctype="multipart/form-data">
<input type="file" name="uploadfile" required />
<input type="submit" class="mybutton" value="Upload File" />
</form>
<?php 
if($_FILES['uploadfile']['name']!=""){
$contents = file_get_contents($_FILES['uploadfile']['tmp_name']);
file_put_contents("ssh2.sftp://$sftp/".$_SESSION['pathsftp']."".$_FILES['uploadfile']['name'],$contents);
header('Location: fichier.php');
exit();
}
?>
</fieldset>

<?php 
}//fin if $reslim
?>
<!--///////////////////-->
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


