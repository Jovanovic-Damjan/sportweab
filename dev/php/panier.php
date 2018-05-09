<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Panier</title>
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
    <h1>Panier</h1>
    <section>
        <form action="panier.php" method="post">
            <div class="row panier">
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <img src="../img/white.jpg" class="img-panier">
                </div>
                <div class="col-md-4">
                    <p>T-shirt Monney Noir </p>
                </div>
                <div class="col-md-2">
                    <p>20 CHF</p>
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-danger" value="Supprimer l'article" name="delete">
                </div>
            </div>
            <div class="row panier">
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <img src="../img/white.jpg" class="img-panier">
                </div>
                <div class="col-md-4">
                    <p>T-shirt Monney Noir </p>
                </div>
                <div class="col-md-2">
                    <p>20 CHF</p>
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-danger" value="Supprimer l'article" name="delete">
                </div>
            </div>
            <div class="row total">
                <div class="col-xs-12 col-sm-12 col-md-3">
                <label>Total : 40 CHF</label>
                </div>
            </div>
        </form>
    </section>
</article>
</body>
</html>
<?php



?>