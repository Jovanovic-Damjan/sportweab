<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";

if (isset($_SESSION['idClient'])) {
    $idClient = $_SESSION['idClient'];
}
$panier = getCart($idClient);
$success = "";
$error = "";
$newSolde = 0;
$wallet = getWallet($idClient);
$sumCart = getSumCart($idClient);

if (isset($_POST['delete'])) {
    $idCommande = filter_input(INPUT_POST, 'idCommande', FILTER_VALIDATE_INT);
    $idArticle = filter_input(INPUT_POST, 'idArticle', FILTER_VALIDATE_INT);

    deleteArticleFromCart($idClient, $idCommande);
    updateStock($idArticle);

    header('Location: panier.php');
    die();
}

$allIdCommand = getIdCommand($idClient);

if (isset($_POST['payer'])) {
    $idCommande = filter_input(INPUT_POST, 'idCommande', FILTER_VALIDATE_INT);

    $solde = $wallet[0]['solde'];
    if ($solde >= $sumCart[0]['total']) {
        $newSolde = $solde - $sumCart[0]['total'];
        updateWallet($idClient, $newSolde);
        $numCommande = date("Y-m-d") . uniqid();
        checkoutCart($numCommande, $idClient);
        createBills($sumCart[0]['total'], $allIdCommand);
        $success = "Commande payée avec succès !";
        header('Location: panier.php');
        die();
    } else {
        $error = "Solde insuffisant !";
    }
}
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
<?php
if ($success != "") {
    echo '<div class="alert alert-success message">' . $success . '</div>';
}
if ($error !== "") {
    echo '<div class="alert alert-danger message">' . $error . '</div>';

}
$i = 0;
$totalCart = 0;
if (count($panier) > 0) {
    foreach ($panier as $key => $value) {

        echo '<form action="panier.php" method="post">
            <div class="row panier">
                <div class="col-xs-12 col-sm-6 col-md-2">
                <a href="article.php?id=' . $value['idArticle'] . '">
                    <img src="../img/' . $value['imageArticle'] . '" class="img-panier">
                    </a>
                </div>
                <div class="col-md-4">
                    <p><b>' . $value['nomArticle'] . ' - Taille : </b>' . $value['taille'] . '</p>
                </div>
                <div class="col-md-2">
                    <p><b>' . $value['prix'] . ' CHF</b></p>
                    <input type="text" name="idCommande" hidden  value="' . $value['idCommande'] . '">
                    <input type="text" name="idArticle" hidden  value="' . $value['idArticle'] . '">
                </div>
                <div class="col-md-4">
                    <input type="submit" name="delete" class="btn btn-danger" value="Supprimer l\'article" >
                </div>
                <div class="col-md-4">
                    <input type="text" name="idCommande" hidden value="' . $value['idCommande'] . '">
                </div>
            </div>
            </form>';
    }
} else {
    $info = "Aucun article dans votre panier !";
}

?>
    <div class="row total">
    <div class="col-md-4">
        Nombres d'articles dans le panier : <b><?= count($panier); ?></b></label>
    </div>
    <div class="col-md-4">
        <label>Total : <b><?= $sumCart[0]['total']; ?></b> CHF</label>
    </div>
    <div class="col-md-4">
<?php
if (count($panier) > 0) {
    echo '    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Payer la commande
    </button>';
    }?>


    <form method="post" action="panier.php">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Paiement de la commande</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Total de votre panier : <b><?= $sumCart[0]['total']; ?></b> CHF<br>
                        Total de votre porte-monnaie : <b><?= $wallet[0]['solde']; ?></b> CHF
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                        </button>
                        <input type="submit" name="payer" class="btn btn-primary" value="Payer la commande">
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    </div>
    </section>
    </article>
    </body>
    </html>
    <?php


    ?>