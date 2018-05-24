<?php
/**
 * Développeur: Jovanovic Damjan
 * Date: 23.05.2018
 * Page : user.php
 * Description : Page permettant d'afficher le solde du porte-monnaie ainsi que ses précédentes commandes.
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
$wallet = getWallet($idClient);
$command = getAllCommands($idClient);


?>
<!doctype html>
<?php

?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Utilisateur</title>
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
                    <h1>Solde</h1>
                    Solde de votre porte-monnaie : <b><?= $wallet[0]['solde']; ?></b> CHF
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1>Historiques de vos commandes</h1>
                    <table class="table table-striped table-dark" id="tableCommande">
                        <thead>
                        <tr>
                            <th scope="col">Numéro de commande</th>
                            <th scope="col">Date de la commande</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($command as $key => $value) { ?>
                            <tr>
                                <td>
                                    <a href="historiqueCommande.php?numCommande=<?= $value['numCommande']; ?>"><?= $value['numCommande']; ?></a>
                                </td>
                                <td><?= $value['dateCommande']; ?></td>
                            </tr>
                        <?php } ?>
                </div>

            </div>

        </div>
    </section>
</article>
</body>
</html>
