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
if($co == 1 && $co1 == 1){header('Location: pageperso.php');}//si login/mdp trouvé redirection vers page principale
?>

<!-- Debut Page html -->
<html>
<head>
<meta name="viewport" content="width=device-width"/>
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
else if(stripos($_SERVER['HTTP_USER_AGENT'],'MSIE') != 0)
{header('Location: notie.php');}
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
<title>Cloudi</title>
<style>
label{
font-size: 20px;
}

input{
cursor:text;
font-size: 22px;
/*border-radius: 5px;*/
border:none;
border:1px solid #bdc3c7;
}

input:hover{
cursor: text;
}

input:focus{
cursor: text;
}
</style>
</head>

<body>

<div id="corps">

<img src='/images/cloudicon1bis.png' width=90 height=90 style='position:absolute;top:25;left:325;' />
<div style='margin:30px 0px 0px 0px;font-size:45px;font-style:italic;text-align:center;'>
Acces a Cloudi
</div><br/>


<!-- Formulaire Connexion -->
<fieldset>
<legend id="legendconnexion">Connexion</legend>
<center>
<form method="post" action="repindex.php">
<?php if($_SESSION['badlog']==11){ ?>
<p style='color:red;'>Mauvais login/mot de passe</p>
<?php } ?>
<table>
<tr>
<td><input type="text" name="securite1" placeholder="Pseudo" size="30" autofocus required /></td>
</tr>
<tr>
<td><input type="password" name="securite" placeholder="Mot de Passe" size="30" required /></td>
<td><input type="submit" class="mybutton" value="Connexion" /></td>
</tr>
</table>
</form>
</center>
</fieldset>

<!-- Formulaire Inscription -->
<fieldset>
<legend id="legendinscription">Inscription</legend>
<center>
<form method="post" action="cibleinscription.php">
<table>
<tr>
<td><input type="text" name="inscription1" placeholder="Pseudo" size="30" title="Pas d'accents, d'espaces ni de caracteres speciaux" required /><?php if($_SESSION['badpseudo']==11){ ?>&nbsp;&nbsp;<span style='color:red;'>Pseudo déjà utilisé</span><?php } ?></td>
</tr>
<tr>
<td><input type="password" name="inscription" placeholder="Mot de Passe" size="30" required /><?php if($_SESSION['badmdp']==11){ ?>&nbsp;&nbsp;<span style='color:red;'>Mauvais mot de passe</span><?php } ?></td>
</tr>
<tr>
<td><input type="password" name="inscriptionb" placeholder="Confirmer Mot de Passe" size="30" required /></td>
</tr>
<tr>
<td><input type="email" name="inscription7" placeholder="Email" size="30" required /><?php if($_SESSION['bademail']==11){ ?>&nbsp;&nbsp;<span style='color:red;'>Email déjà utilisé</span><?php } ?></td>
<td><input type="submit" class="mybutton" value="Inscription" /></td>
</tr>
</table>
</form>
</center>
</fieldset>

</div>

<!-- Footer -->
<p><center>&#169 2013 Cloudi Inc Copyright | <a style='color:black;text-decoration:none;' href='projet.php'>Projet</a> | <a href='#'><img src='images/social_facebook' /></a><img src='images/social_twiter' /><img src='images/social_linkedIn' /><img src='images/social_youtube' /></center> </p>

</body>
</html>
