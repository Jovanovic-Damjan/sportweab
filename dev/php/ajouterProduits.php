<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
if(isset($_SESSION['typeUtilisateur']) && $_SESSION['typeUtilisateur'] !== "Administrateur")
{
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter des produits</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?= menu(); ?>
<header>
    <img src="../img/logo.jpg">
    <h1>Administration</h1>
    <h2>Ajouter des produits</h2>
</header>
<article id="containerAjoutProduit">
    <section>
        <form>
            <div class="form-group">
                <label for="nomArticle">Nom de l'article</label>
                <input type="text" class="form-control" id="nomArticle" aria-describedby="nomArticle" placeholder="Le nom de l'article">
                <small id="nomArticle" class="form-text text-muted">Exemple : "T-shirt Blanc"</small>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Image de l'article</label>
                <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Nom de l'image</small>
            </div>
            <div class="form-group">
                <label for="exampleTextarea">Description de l'article</label>
                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="descriptionArticle">Prix de l'article de l'article</label>
                <input type="text" class="form-control" id="descriptionArticle" aria-describedby="descriptionArticle" placeholder="Description de l'article">
                <small id="descriptionArticle" class="form-text text-muted">Exemple : "T-shirt Blanc"</small>
            </div>
            <div class="form-group">
                <label for="example-number-input">Number</label>
                <div class="col-10">
                    <input class="form-control" type="number" value="42" id="example-number-input">
                </div>
            </div>
        </form>
    </section>
</article>
</body>
</html>