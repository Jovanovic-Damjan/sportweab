<?php
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
?>
<!doctype html>
<?php
$articles = getArticles();
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
    <h1>Nouveautés</h1>
    <section>
        <div class="row">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="../img/kaki.png" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../img/black.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../img/beige.png" alt="Third slide">
                    </div>
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
            <?php

            /* Boucle permettant d'afficher tout les articles*/
            foreach ($articles as $key => $value) { ?>

                <div class="col-md-4 container"><img class="img-article" src="../img/<?= $value['imageArticle'];?>">
                    <div class="middle">
                        <label><a href="article.php?id=<?= $value['idArticle']; ?>" class="produit-article"><?= $value['nomArticle']; ?></a></label>
                    </div>
                </div>
                <?php
                $rowCount++;
                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
            }
            ?>
        </div>
    </section>
</article>
</body>
</html>
