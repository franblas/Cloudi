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
//on efface les variables de session
session_unset();
//on detruit la session
session_destroy();
//on renvoit a la page principale
header('Location: index.php');
?>
