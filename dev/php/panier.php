<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";

if(isset($_SESSION['idClient'])) {
    $idClient = $_SESSION['idClient'];
}
$panier = getCart($idClient);

if (isset($_POST['delete'])) {
    $idArticle = filter_input(INPUT_POST, 'idArticle', FILTER_VALIDATE_INT);
    $idCommande = filter_input(INPUT_POST, 'idCommande', FILTER_VALIDATE_INT);
    deleteArticleFromCart($idArticle, $idClient, $idCommande);
    header('Location: panier.php');
    die();
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
            foreach ($panier as $key => $value) {
                echo '<form action="panier.php" method="post">
            <div class="row panier">
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <img src="../img/' . $value['imageArticle'] . '" class="img-panier">
                </div>
                <div class="col-md-4">
                    <p><b>' . $value['nomArticle'] . ' - Taille : </b>' . $value['taille'] . '</p>
                </div>
                <div class="col-md-2">
                    <p><b>' . $value['prix'] . ' CHF</b></p>
                    <input type="text" name="idCommande" hidden  value="'.$value['idCommande'].'">
                    <input type="text" name="idArticle" hidden  value="'.$value['idArticle'].'">
                </div>
                <div class="col-md-4">
                    <input type="submit" name="delete" class="btn btn-danger" value="Supprimer l\'article" >
                </div>
            </div>
            </form>';
            } ?>

            <div class="row total">
                <div class="col-md-4">
                    <label>1</label>
                </div>
                <div class="col-md-4">
                    <label>Total : 40 CHF</label>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-primary">Payer la commande</a>
                </div>
            </div>

        </section>
    </article>
    </body>
    </html>
<?php


?>