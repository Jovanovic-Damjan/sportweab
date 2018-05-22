<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
?>
<!doctype html>
<?php
$articles = getImage();
$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Index</title>
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
        <div class="row">
            <h1>Nouveautés</h1>
        </div>
        <div class="row">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="../img/kaki.png" alt="First slide">
                    </div>
                    <?php foreach ($articles as $key => $value) { ?>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="../img/<?= $value['imageArticle'];?>">
                        </div>
                    <?php } ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="row">
            <h1>Les catégories</h1>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4 container">
                <img class="img-article" src="../img/t-shirt.jpg">
                <div class="middle">
                    <label><a href="produits.php?categorie=T-shirt" class="produit-article">T-shirt</a></label>
                </div>
            </div>
            <div class="col-md-4 container">
                <img class="img-article" src="../img/hoodie.jpg">
                <div class="middle">
                    <label><a href="produits.php?categorie=hoodie" class="produit-article">Hoodie</a></label>
                </div>
            </div>
            <div class="col-md-4 container">
                <img class="img-article" src="../img/casquette.jpg">
                <div class="middle">
                    <label><a href="produits.php?categorie=casquette" class="produit-article">Casquette</a></label>
                </div>
            </div>
        </div>
    </section>
</article>
</body>
</html>
