<?php
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Produits</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
            <div class="col-xs-12 col-md-4"><img class="img-article" src="../img/white.jpg">
                <label>T-shirt "monney"</label><br>
                <input type="submit" class="btn btn-primary" value="Ajouter au panier">
            </div>
            <div class="col-md-4"><img class="img-article" src="../img/white.jpg">
                <label>T-shirt "monney"</label><br>
                <input type="submit" class="btn btn-primary" value="Ajouter au panier">
            </div>
            <div class="col-md-4"><img class="img-article" src="../img/white.jpg">
                <label>T-shirt "monney"</label><br>
                <input type="submit" class="btn btn-primary" value="Ajouter au panier">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><img class="img-article" src="../img/white.jpg"></div>
            <div class="col-xs-12 col-md-4"><img class="img-article" src="../img/white.jpg"></div>
            <div class="col-md-4"><img class="img-article" src="../img/white.jpg"></div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4"><img class="img-article" src="../img/white.jpg"></div>
            <div class="col-md-4"><img class="img-article" src="../img/white.jpg"></div>
            <div class="col-md-4"><img class="img-article" src="../img/white.jpg"></div>
        </div>
    </section>
</article>
</body>
</html>
