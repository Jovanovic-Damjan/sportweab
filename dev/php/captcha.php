<?php
/**
 * Created by PhpStorm.
 * User: JOVANOVICD_INFO
 * Date: 09.05.2018
 * Time: 15:21
 */

function motListe()
{
    $liste = array('internet', 'captcha', 'robot', 'sport', 'école');
    return $liste[array_rand($liste)];
}

function captcha()
{
    $mot = motListe();
    $_SESSION['captcha'] = $mot;
    return $mot;
}

?>