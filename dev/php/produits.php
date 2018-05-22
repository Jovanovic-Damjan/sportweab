<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";


$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;



if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
}
else{
    $categorie = "";
}

if(isset($_GET['order']))
{
    $order = $_GET['order'];
}
else {
    $order = "";
}
if(isset($_GET['way']))
{
    $way = $_GET['way'];
}
else {
    $way = "";
}

$articles = getArticles($categorie,$order,$way);

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
    <h1>Nos produits</h1>
    <div id="filtre">
            Trier par <a href="produits.php?order=prix&way=<?php if($way == "ASC"){echo"DESC";}else{echo"ASC";}; ?><?php if($categorie != ""){echo "&categorie=".$categorie;}?>">Prix <img class="filter-ico" src="../open-iconic-master/svg/chevron-top.svg" alt="icon name"></a> ou par <a href="produits.php?order=nomCategorie&way=<?php if($way == "ASC"){echo"DESC";}else{echo"ASC";}; ?><?php if($categorie != ""){echo "&categorie=".$categorie;}?>">Catégorie</a>
    </div>
    <section>
        <div class="row">
            <?php
            /*Boucle permettant d'afficher tout les articles*/
            foreach ($articles as $key => $value) { ?>
                <div class="col-md-4 container"><img class="img-article" src="../img/<?= $value['imageArticle']; ?>">
                    <div class="middle">
                        <label><a href="article.php?id=<?= $value['idArticle']; ?>" class="produit-article"><?= $value['nomArticle'].'<br>'.$value['prix'] ?></a></label>
                    </div>
                </div>
                <?php
                $rowCount++;
                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
            }
            ?>
        </div>
<!--        --><?php
//        if(isset($_GET['categorie'])){
//            $categorie = $_GET['categorie'];
//
//            $articleByCategorie = getArticleByCategories($categorie);
//
//            foreach ($articleByCategorie as $key => $value)
//            {
//                echo '<div class="row">';
//                echo '        <div class="col-md-4 container"><img class="img-article" src="../img/'.$value['imageArticle'].'">
//                    <div class="middle">
/*                        <label><a href="article.php?id=<?= $value[\'idArticle\']; ?>" class="produit-article">'.$value['nomArticle'].'<br>'.$value['prix'].'</a></label>*/
//                    </div>
//                </div>';
//                echo '</div>';
//
//                $rowCount++;
//                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
//            }
//        }
//        ?>
    </section>
</article>
</body>
</html>
