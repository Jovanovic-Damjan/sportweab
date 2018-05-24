<?php
/**
 * Développeur: Jovanovic Damjan
 * Date: 24.05.2018
 * Page : historiqueCommande.php
 * Description : Page permettant de récupérer les informations d'une commande.
 */

session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";

if (isset($_SESSION['idClient'])) {
    $idClient = $_SESSION['idClient'];
} else {
    header("Location: index.php");
    die();
}

if (isset($_GET['numCommande'])) {
    $numCommande = $_GET['numCommande'];
} else {
    $numCommande = "";
}
$wallet = getWallet($idClient);
$command = getDetailsCommand($idClient, $numCommande);
$sumCart = getSumCart($idClient);
$total = 0;
?>
<!doctype html>
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
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Détails de la commande N°<?= $numCommande; ?></h1>


                    <table class="table table-striped table-dark" id="table-historic">
                        <thead>
                        <tr>
                            <th scope="col">Image de l'article</th>
                            <th scope="col">Nom de l'article</th>
                            <th scope="col">Taille</th>
                            <th scope="col">Prix</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($command as $key => $value) { ?>
                            <tr class="textAlignement">
                                <td id="img-historique"><img src="../img/<?= $value['imageArticle']; ?>"
                                                             class="img-historique"></td>
                                <td><?= $value['nomArticle']; ?></td>
                                <td><?= $value['taille']; ?></td>
                                <td><?= $value['prix'] ?></td>
                                <?php $total += $value['prix']; ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Total de la commande : <?= $total; ?> CHF</td>
                        </tr>
                        </tfoot>
                </div>
                <a href="user.php">Revenir en arrière</a>
            </div>
        </div>
    </section>
</article>
</body>
</html>
