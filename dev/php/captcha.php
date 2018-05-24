<?php
/**
 * Développeur: Jovanovic Damjan
 * Date: 11.05.2018
 * Page : captcha.php
 * Description : Page permettant de générer un mot pour la vérification d'inscription et de connexion.
 */

// Fonction pour sélectionner un mot aléatoire dans le tableau
function motListe()
{
    $liste = array('internet', 'captcha', 'robot', 'sport', 'école', 'monde', 'youtube');
    return $liste[array_rand($liste)];
}

// Fonction permettant de mettre le mot du tableau dans une variable de session
function captcha()
{
    $mot = motListe();
    $_SESSION['captcha'] = $mot;
    return $mot;
}

?>