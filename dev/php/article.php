<?php
/**
 * Développeur: Jovanovic Damjan
 * Date: 11.05.2018
 * Page : article.php
 * Description : Page permettant d'afficher les informations d'un article.
 */
session_start();

require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
if (isset($_SESSION['idClient'])) {
    $idClient = $_SESSION['idClient'];
}
if (isset($_GET['id'])) {
    $idArticle = $_GET['id'];
    $getArticleInfo = getArticleInfo($idArticle);

}

$success = "";
if (isset($_POST['delete'])) {
    $image = filter_input(INPUT_POST, 'imageArticle', FILTER_SANITIZE_STRING);
    deleteArticle($_POST['idArticle']);
    unlink("../img/" . $image);
    header('Location: produits.php?page=1');
    die();
}

if (isset($_POST['ajoutPanier'])) {
    $taille = filter_input(INPUT_POST, 'taille', FILTER_SANITIZE_STRING);
    $idArticle = filter_input(INPUT_POST, 'idArticle', FILTER_VALIDATE_INT);
    $idPrixArticle = filter_input(INPUT_POST, 'idPrixArticle', FILTER_VALIDATE_INT);

    $idCommand = addArticleToCart($taille, $idClient, $idArticle, $idPrixArticle);
    CommandConcernArticle($idArticle, $idCommand);
    CommandConcernClient($idClient, $idCommand);
    header('Location: produits.php?page=1');
    die();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Article</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <link rel="icon" href="../img/small-logo.ico">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?= menu(); ?>
<header>
    <img src="../img/logo.jpg">
</header>
<article>
    <section>
        <?php
        if ($success !== "") {
            echo '<div class="alert alert-success message"><strong>' . $success . '</strong></br><a href="produits.php" class="message">Retour à la page des produits</a></div>';
        }
        /*Boucle permettant d'afficher tout les articles*/
        if (isset($_GET['id'])){
        foreach ($getArticleInfo

        as $key => $value) {
        ?>
        <h1><?= $value['nomArticle']; ?></h1>
        <form method="post" action="article.php">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="text-article">
                        <p>
                            <?= $value['descriptionArticle']; ?>
                        </p>
                        <p>
                            Envoyé depuis la Suisse.
                            Temps de livraison estimé à 3-4 jours après l'envoi.
                        </p>
                        <p>
                            Ne pas repasser directement sur les impressions.
                        </p>
                        <p>
                            Catégorie : <u><?= $value['nomCategorie']; ?></u>
                        </p>

                        <p>
                            Prix : <b><?= $value['prix']; ?></b> CHF
                        </p>
                        <p>
                            Nombre en stock : <b><?php if ($value['stock'] !== null && $value['stock'] > 0) {
                                    echo $value['stock'];
                                } elseif ($value['stock'] == 0) {
                                    echo "Rupture de stock";
                                } ?></b>
                        </p>
                        <?php

                        if (isset($_SESSION['typeUtilisateur']) && $_SESSION['typeUtilisateur'] == "Administrateur") {
                            echo '<p><a href="modifierProduit.php?id=' . $idArticle . '" class="btn btn-warning">Modifier l\'article</a></p>';
                            /* Code pour afficher une popup en Bootstrap */
                            echo "<!-- Button trigger modal -->
<!-- Button trigger modal -->
<p><button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">
  Supprimer l'article
</button></p>

<!-- Modal -->
<div class=\"modal fade\" id=\"exampleModalCenter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Attention !</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        Voulez-vous vraiment supprimer l'article ?
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Annuler</button>
        <!--<a href=\"produits.php?delete&id=$idArticle\"  class=\"btn btn-danger\">Supprimer</a>-->
        <button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Supprimer</button>
      </div>
    </div>
  </div>
</div>";
                        } elseif (isset($_SESSION['typeUtilisateur']) && $_SESSION['typeUtilisateur'] == "Utilisateur") {
                            echo '<p>
                            <select name="taille">
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </p>';
                            echo '<p><input type="submit" name="ajoutPanier" class="btn btn-primary" value="Ajouter au panier"></p>';
                        } elseif (!isset($_SESSION['typeUtilisateur'])) {
                            echo '<div class="alert alert-warning" role="alert">Veuillez vous connecter pour ajouter des articles dans votre panier.</div>';
                        }
                        ?>
                        <p>
                            <input type="text" hidden name="idArticle" value="<?= $value['idArticle']; ?>">
                            <input type="text" hidden name="idPrixArticle" value="<?= $value['idPrixArticle']; ?>">
                        </p>
                    </div>
                </div>
                <div class="col-md-8">
                    <img src="../img/<?= $value['imageArticle']; ?>" class="imageArticle">
                    <input type="text" hidden name="imageArticle" value="<?= $value['imageArticle']; ?>">
                </div>
            </div>
        </form>
    </section>
    <?php }
    } ?>
</article>
</body>
