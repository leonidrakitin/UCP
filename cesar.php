<?php


function CesarArray()
{
    return array('?', '!', '_', 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ':', ' ', '&', '|', '+', '-', '.', ',', '"', "'", '/', '\\', '(', ')', '^', '%', '*', '$', '#', '@', '<', '>', ';', '№', '~', '`', '#', '@');
}
function Cesar($X, $num=2)
{
    $prealph=CesarArray();
    $N=count($prealph);
    $alph = array();
    for($i=0; $i<$N; $i++) array_push($alph, $prealph[$i]);
    for($i=0; $i<$N; $i++) array_push($alph, $prealph[$i]);
    //*/

    $b="";
    $n=strlen($X);

    for($i=0;$i<$n;$i++)
    {
        for($j=0;$j<count($alph);$j++)
        {
            if($X[$i]==$alph[$j])
            {
                $b .=  $alph[($j+$num)];
                break;
            }

        }

    }
    return $b ;
}
function UnCesar($X, $num=2)
{
    $prealph=CesarArray();
    $N=count($prealph);
    $alph = array();
    for($i=0; $i<$N; $i++) array_push($alph, $prealph[$i]);
    for($i=0; $i<$N; $i++) array_push($alph, $prealph[$i]);

    $b="";
    $n=strlen($X); //Возвращает длину строки

    for($i=0;$i<$n;$i++)
        for($j=count($alph);$j>=0;$j--)
        {
            if($X[$i]==$alph[$j])
            {
                $b= $b . $alph[ ($j-$num)];
                break;
            }
        }

    return $b ;
}
?>