<?php
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
if(isset($_SESSION["typeUtilisateur"]) != "Administrateur")
{
    header('location: index.php');
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
<article>
    <section>
        <table>
            <tr>
                <td><label>Nom du produit :</label></td>
                <td><input type="text" name="nomProduit" class="form-control" placeholder="Numéro de téléphone"></td>
            </tr>
            <tr>
                <td><label>Description du produit :</label></td>
                <td><textarea name="nomProduit" class="form-control" placeholder="Description du produit"></textarea></td>
            </tr>
            <tr>

            </tr>
        </table>
    </section>
</article>
</body>
</html>