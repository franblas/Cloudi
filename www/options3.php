<?php 
/*****************************
*
* Cloudi Version 0.1
* 
* Written by François Blas
* Last Modification : 11/01/14
* 
******************************/

header('Content-Type: text/xml;charset=utf-8');
echo "<?xml version='1.0' encoding='UTF-8' ?>";
echo utf8_encode("<options>");

if (isset($_GET['debut'])) {
    $debut = utf8_decode($_GET['debut']);
} else {
    $debut = "";
}
$debut = strtolower($debut);

$liste = array();

//recherche bdd 
try
{
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

//recuperation donnees actualites
$reponse = $bdd->prepare("SELECT * FROM Inscription");
$reponse->execute(array());

//Affichage des donnees
while($donnees = $reponse->fetch())
{

$liste[$donnees['ID']]=$donnees['pseudo'];

}
$reponse->closeCursor();
 
function generateOptions($debut,$liste) {
    $MAX_RETURN = 10;
    $i = 0;
    foreach ($liste as $element) {
        if ($i<$MAX_RETURN && substr($element, 0, strlen($debut))==$debut) {
            echo(utf8_encode("<option>".$element."</option>"));
            $i++;
        }
    }
}
 
generateOptions($debut,$liste);
 
echo("</options>");
?>

