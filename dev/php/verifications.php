<?php
/**
 * Développeur: Jovanovic Damjan
 * Date: 09.05.2018
 * Page : verifications.php
 * Description : Page permettant contenant des fonctions pour tester le type ou le contenu des variables.
 */

// Fonction permettant de vérifier que le nom
function checkNameLastName($var)
{
    $pattern = '/^[a-zA-Z]+(([\',. -][a-zA-Z ])?[a-zA-Z]*)*$/m';
    if (preg_match_all($pattern, $var, $matches, PREG_SET_ORDER, 0)) {
        return true;
    } else {
        return false;
    }
}


// Fonction permettant de vérifier si la variable passée en paramètre contient que des numéros
function OnlyNumbers($var)
{
    if (ctype_digit($var)) {
        return true;
    } else {
        return false;
    }
}

// Fonction permettant de vérifier si la variable contient plus que 4 caractères
function MinPwd($var)
{
    if (strlen($var) > 4) {
        return true;
    } else {
        return false;
    }
}


?>