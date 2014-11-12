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

<?php

function poids($rep)
{
    $r = @opendir($rep);
    while( $dir=@readdir($r) )
    {
        if( !in_array($dir, array("..", ".")) )
        {
            if( is_dir("$rep/$dir") )
            {
                $t += poids("$rep/$dir");
            }
            else
            {
                $t += @filesize("$rep/$dir");
            }
        }
    }
    @closedir($r);
    return $t;
}

function unitebis($valeur)
{
    if( $valeur >= pow(1024, 3) )
    {
        $valeur = round( $valeur / pow(1024, 3), 2);
        return $valeur;
    }
    elseif( $valeur >=  pow(1024, 2) )
    {
        $valeur = round( $valeur / pow(1024, 2), 2);
        return $valeur;
    }
    else
    {
        $valeur = round( $valeur / 1024, 2);
        return $valeur;
    }
}

function unite($valeur)
{
    if( $valeur >= pow(1024, 3) )
    {
        $valeur = round( $valeur / pow(1024, 3), 2);
        return $valeur . ' Go';
    }
    elseif( $valeur >=  pow(1024, 2) )
    {
        $valeur = round( $valeur / pow(1024, 2), 2);
        return $valeur . ' Mo';
    }
    else
    {
        $valeur = round( $valeur / 1024, 2);
        return $valeur . ' Ko';
    }
}

?>

