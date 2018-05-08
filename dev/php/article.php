<?php
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";

?>
<!doctype html>
<?php
$idArticle = $_GET['id'];
$getArticleInfo = getArticleInfo($id);

?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Article</title>
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
        <h1></h1>
    </section>
</article>
</body>
