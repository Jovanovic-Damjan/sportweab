<?php
/**
 * Created by PhpStorm.
 * User: JOVANOVICD_INFO
 * Date: 09.05.2018
 * Time: 15:39
 * Description : page php qui contient les fonctions de vérifications des entrées utilisateurs lors de l'inscription.
 */

function checkNameLastName($var)
{
    $pattern = '/^[a-zA-Z]+(([\',. -][a-zA-Z ])?[a-zA-Z]*)*$/m';
    if (preg_match_all($pattern, $var, $matches, PREG_SET_ORDER, 0)) {
        return true;
    } else {
        return false;
    }
}

function LettersNumbers($var)
{
    if (ctype_alnum($var)) {
        return true;
    } else {
        return false;
    }
}

function OnlyNumbers($var)
{
    if (ctype_digit($var)) {
        return true;
    } else {
        return false;
    }
}

function MinPwd($var)
{
    if (strlen($var) > 4) {
        return true;
    } else {
        return false;
    }
}



?>