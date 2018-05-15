<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
?>
<!doctype html>
<?php
$articles = getArticles();
$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
}

/*if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteArticle($id);
}*/

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
    <h1>Nos produits</h1>
    <section>
        <div class="row">
            <?php
            /*Boucle permettant d'afficher tout les articles*/
            foreach ($articles as $key => $value) { ?>
                <div class="col-md-4 container"><img class="img-article" src="../img/<?= $value['imageArticle']; ?>">
                    <div class="middle">
                        <label><a href="article.php?id=<?= $value['idArticle']; ?>"
                                  class="produit-article"><?= $value['nomArticle']; ?></a></label>
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
