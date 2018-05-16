<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
if (isset($_SESSION['typeUtilisateur']) && $_SESSION['typeUtilisateur'] !== "Administrateur") {
    header("Location: index.php");
    die();
}

$categories = getCategories();
$dateActuelle = date("Y-m-d");

$array_error = array();
$success = "";


// Fonction qui permet de poster des images
if (isset($_POST['ajoutProduit'])) {
    if ((!empty($_POST['nomArticle'])) && ($_FILES['imageArticle']['size'] !== 0) && ($_FILES['imageArticle']['error'] == 0) && (!empty($_POST['descriptionArticle'])) && (!empty($_POST['prixArticle'])) && (!empty($_POST['categorie'])) && (!empty($_POST['nbStock']))) {

        $nomArticle = filter_input(INPUT_POST, 'nomArticle', FILTER_SANITIZE_STRING);
        $descriptionArticle = filter_input(INPUT_POST, 'descriptionArticle', FILTER_SANITIZE_STRING);
        $prixArticle = filter_input(INPUT_POST, 'prixArticle', FILTER_VALIDATE_FLOAT);
        $idCategorie = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);
        $nombreStock = filter_input(INPUT_POST, 'nbStock', FILTER_VALIDATE_INT);

        $extensions_autorisees = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/JPG');
        if (($nombreStock > 0) && ($nombreStock <= 100)) {
            if (($prixArticle > 0) && ($prixArticle <= 150)) {
                // Variable qui contient un identifiant unique qui sera par la suite ajouté au nom de fichier pour que le nom de fichier soit unique
                $uniqId = uniqid();

                $count = explode('.', $_FILES['imageArticle']['name']);
                $count2 = strlen($count[1]);
                $extension = substr($_FILES['imageArticle']['name'], -$count2);

                // On ajoute l'identifiant unique au nom de l'image qu'on stocke dans une variable
                $imageArticle = $uniqId . "." . $extension;

                if (in_array($_FILES['imageArticle']['type'], $extensions_autorisees)) {
                    // La fonction permet de transférer les fichiers sélectionné dans un répertoire
                    move_uploaded_file($_FILES['imageArticle']['tmp_name'], "../img/$imageArticle");
                    if (!is_uploaded_file($_FILES['imageArticle']['tmp_name'])) {
                        // On finit par ajouter les fichiers dans la base de données
                        $idPrix = addPrice($prixArticle, $dateActuelle);
                        $idArticle = addArticle($nomArticle, $imageArticle, $descriptionArticle, $nombreStock, $idCategorie, $idPrix);
                        addPriceHistoric($idPrix, $idArticle);
                        header('Location: ajouterProduits.php');
                        die();
                    }
                } else {
                    array_push($array_error, "Veuillez sélectionner que des images !");
                }
            } else {
                array_push($array_error, "Veuillez entrer une valeur entre 1 et 100 pour le stock!");
            }
        } else {
            array_push($array_error, "Veuillez entrer une valeur entre 1 et 150 pour le prix!");
        }
    } else {
        array_push($array_error, "Veuillez remplir tous les champs !");
    }
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
        <?php
        /* Test qui permet d'afficher les messages d'erreurs ou les messages de succès */
        if (count($array_error) > 0) {
            echo '<div class="alert alert-danger error">';
            for ($i = 0; $i < count($array_error); $i++) {
                echo $array_error[$i];
                echo '<br/>';
            };
            echo '</div>';
        }
        if ($success != "") {
            echo '<div class="alert alert-success" role="alert">';
            echo $success;
            echo '</div>';
        }
        ?>
        <form method="post" action="ajouterProduits.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nomArticle"><b>Nom de l'article</b></label>
                <input type="text" class="form-control" required name="nomArticle"
                       value="<?php if (isset($nomArticle)) {
                           echo $nomArticle;
                       } ?>" placeholder="Le nom de l'article">
            </div>
            <div class="form-group">
                <label for="imageArticle"><b>Image de l'article</b></label>
                <input type="file" class="form-control-file" accept="image/*" required name="imageArticle">
            </div>
            <div class="form-group">
                <label for="exampleTextarea"><b>Description de l'article</b></label>
                <textarea class="form-control" required name="descriptionArticle"
                          rows="3"><?php if (isset($descriptionArticle)) {
                        echo $descriptionArticle;
                    } ?></textarea>
            </div>
            <div class="form-group">
                <label for="example-number-input"><b>Prix de l'article</b></label>
                <div class="col-10">
                    <input class="form-control oklm" required name="prixArticle" value="<?php if (isset($prixArticle)) {
                        echo $prixArticle;
                    } ?>" type="number" min="1" max="100">
                </div>
            </div>
            <div class="form-group">
                <label for="inputState"><b>Catégorie</b></label>
                <select name="categorie" required class="form-control">
                    <?php getSelectCategories(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="example-number-input"><b>Nombre de stock</b></label>
                <div class="col-10">
                    <input class="form-control oklm" name="nbStock" value="<?php if (isset($nombreStock)) {
                        echo $nombreStock;
                    } ?>" type="number" min="1" max="100">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" name="ajoutProduit" class="btn btn-primary">Ajouter le produit</button>
            </div>
            <p>
                <a href="administration.php">retour à l'administration</a>
            </p>
        </form>
    </section>
</article>
</body>
</html>