<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";


$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;


if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
} else {
    $categorie = "";
}

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = "";
}
if (isset($_GET['way'])) {
    $way = $_GET['way'];
} else {
    $way = "";
}

$articles = getArticles($categorie, $order, $way);

$nbrElements = count($articles);
$nbrElementsPerPage = 12;

$page = $_GET['page'];


?>
<!doctype html>
<?php

?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Produits</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
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
    <h1><?php if (isset($_GET['categorie'])) {
            echo $_GET['categorie'];
        } else {
            echo "Nos produits";
        }
        ?>
    </h1>
    <div id="filtre">
        Trier par <a href="produits.php?<?php if(isset($_GET['page'])){echo 'page='.$_GET['page'].'&';}?>order=prix&way=<?php if ($way == "ASC") {
            echo "DESC";
        } else {
            echo "ASC";
        }; ?><?php if ($categorie != "") {
            echo "&categorie=" . $categorie;
        } ?>">Prix</a> ou par <a href="produits.php?<?php if(isset($_GET['page'])){echo 'page='.$_GET['page'].'&';}?>order=nomCategorie&way=<?php if ($way == "ASC") {
            echo "DESC";
        } else {
            echo "ASC";
        }; ?><?php if ($categorie != "") {
            echo "&categorie=" . $categorie;
        } ?>">Catégorie</a>

    </div>
    <section>
        <div class="row">
            <?php

            for ($i = $nbrElementsPerPage * ($page - 1); $i < $nbrElementsPerPage * $page; $i++) {
                if (isset($articles[$i])) {
                    echo '<div class="col-md-4 container"><img class="img-article" src="../img/' . $articles[$i]['imageArticle'] . '">
                   <div class="middle">
                        <label><a href="article.php?id=' . $articles[$i]['idArticle'] . '" class="produit-article">' . $articles[$i]['nomArticle'] . '<br>' . $articles[$i]['prix'] . '</a></label>
                   </div>
              </div>';
                }

            }
            ?>
        </div>
        <!-- Pagination -->
        <div class="row" id="pagination">
            <?php
            $pagesTotales = ceil($nbrElements / $nbrElementsPerPage);
            echo '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
            for ($j = 1; $j <= $pagesTotales; $j++) {
                if ($j == $page) {
                    echo '<li class="page-item disabled"><a class="page-link" href="produits.php?page='.$j.'">'.$j.' '.'</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="produits.php?page='.$j.'">'.$j.'</a></li>';
                }
            }
            echo '</ul></nav>';
            ?>
        </div>

    </section>
</article>
</body>
</html>
