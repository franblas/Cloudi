<?php
/*****************************
*
* Cloudi Version 0.1
* 
* Written by François Blas
* Last Modification : 11/01/14
* 
******************************/
?>

<!-- Debut Page html -->
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<link rel="icon" href="images/favicon.ico" />
<title>Cloudi - Browser</title>
<style>
body{
background:#ccc;
}
#corps{
border: 1px solid #000;
padding-bottom: 300px;
background:#fff;
}
#titre{
font-size:60px;
}
#firefox{
position:absolute;
left:10%;
}
#chrome{
position:absolute;
left:40%;
}
#safari{
position:absolute;
left:72%;
}
a img{
border:none;
}
</style>
</head>

<body>
<div id='corps'>
<center><span id='titre'>Choisir un autre Web Browser</span></center><br/><br/><br/><br/>
<div id='firefox'>
<a href='https://download.mozilla.org/?product=firefox-stub&os=win&lang=en-US'><img src='images/firefox.png' title='Firefox' width=200 height=200 /></a>
</div>

<div id='chrome'>
<a href='https://www.google.com/intl/en/chrome/browser/'><img src='images/chrome.png' title='Chrome' width=200 height=200 /></a>
</div>

<div id='safari'>
<a href='http://support.apple.com/kb/dl1531'><img src='images/safari.png' title='Safari' width=200 height=200 /></a>
</div>

</div>
</body>
</html>
