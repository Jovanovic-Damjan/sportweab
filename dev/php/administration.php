<?php
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
if(isset($_SESSION['typeUtilisateur']) != "Administrateur")
{
    header('location: index.php');
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Administration</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?= menu(); ?>
<header>
    <img src="../img/logo.jpg">
    <h1>Administration</h1>
</header>
<article>
    <section>
        <div class="row administration">
            <a href="ajouterProduits.php" class="btn btn-info">Ajouter des produits</a>
            <a href="validerUtilisateurs.php" class="btn btn-info">Valider des utilisateurs</a>
        </div>

       <!-- <table id="tableAdmin">
            <tr>
                <td><a href="ajouterProduits.php" class="btn btn-info">Ajouter des produits</a></td>
            </tr>
            <tr>
                <td><a href="validerUtilisateurs.php" class="btn btn-info">Valider des utilisateurs</a></td>
            </tr>
        </table>-->
    </section>
</article>
</body>
</html>