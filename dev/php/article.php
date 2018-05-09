<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
?>
<!doctype html>
<?php
if(isset($_GET['id'])) {
    $idArticle = $_GET['id'];
    $getArticleInfo = getArticleInfo($idArticle);
}
?>
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
    <?php
    /*Boucle permettant d'afficher tout les articles*/
    foreach ($getArticleInfo as $key => $value) { ?>
    <h1><?= $value['nomArticle'];?></h1>
    <section>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <label class="text-article">
                <p >
                    <?= $value['descriptionArticle']; ?>
                </p>
                <p>
                    La coupe du tee shirt taille légèrement grand
                </p>
                <p>
                    Envoyé depuis la Suisse.
                    Temps de livraison estimé à 3-4 jours après l'envoi.
                </p>
                    <p>
                        <select name="taille">
                            <option value="xs">XS</option>
                            <option value="s">S</option>
                            <option value="m">M</option>
                            <option value="l">L</option>
                            <option value="xl">XL</option>
                        </select>
                    </p>
                    <p>
                        <input type="submit" class="btn btn-primary" name="ajoutPanier" value="Ajouter au panier">
                    </p>
                </label>
            </div>
            <div class="col-md-8">
                <img src="../img/<?= $value['imageArticle']; ?>" class="imageArticle">
            </div>
        </div>
    </section>
    <?php } ?>
</article>
</body>
