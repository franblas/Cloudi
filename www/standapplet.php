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
<!--DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html14/loose.dtd"-->
<html>
<head>
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
<title>Client SSH</title>
</head>
<body>
<div id="corps1">
<fieldset>
<center>
<p>***************************</p>
<p>BIENVENUE sur le client SSH</p>
<p>***************************</p>
</center>
<p>Un peu de patience avant que l'application se lance</p>
<p>Pour pouvoir benificier pleinement du client SSH (nottament le X11) veuillez accepter d'executer l'application "com.mindbright.application.Mindterm"</p>
<p>Si par erreur vous n'avez pas accepter, quittez le browser web et retentez la connexion</p>
<!--APPLET code='com.mindbright.application.MindTerm.class' ARCHIVE='mindterm241.weaversigned.jar' WIDTH='0' HEIGHT='0'-->
<object CODETYPE='application/java-archive' CLASSID='java:com.mindbright.application.MindTerm.class'
          ARCHIVE='mindterm241.weaversigned.jar'>
    <!--PARAM NAME='cabinets' value='mindterm_ie.cab'-->
    <PARAM NAME='sepframe' value='true' />
    <PARAM NAME='debug' value='true' />
    <PARAM NAME='protocol' value='ssh2' />
    <PARAM NAME='server' value='' />
    <PARAM NAME='port' value='22' />
    <PARAM NAME='alive' value='60' />
    <PARAM NAME='80x132-enable' value='true' />
    <PARAM NAME='80x132-toggle' value='true' />
    <PARAM NAME='bg-color' value='white' />
    <PARAM NAME='fg-color' value='black' />
    <PARAM NAME='cursor-color' value='i_black' />
    <PARAM NAME='geometry' value='125x30' />
    <PARAM NAME='x11-forward' value='true' />
  </object>
<input type='button' class='mybutton' value='Relancer' OnClick='javascript:window.location.reload()'>
</fieldset>
</div>
</body>
</html>
