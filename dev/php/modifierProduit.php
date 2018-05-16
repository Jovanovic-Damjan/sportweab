<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
$idArticle = -1;
if (isset($_GET['id'])) {
    $idArticle = $_GET['id'];
    $getArticleInfo = getArticleInfo($idArticle);
}

if (isset($_SESSION['typeUtilisateur']) && ($_SESSION['typeUtilisateur'] !== "Administrateur")) {
    header("Location: produits.php");
    die();
}

$categories = getCategories();

$array_error = array();
$success = "";

// Fonction qui permet de poster des images
if (isset($_POST['modification'])) {
    if ((!empty($_POST['nomArticle'])) && (!empty($_POST['descriptionArticle'])) && (!empty($_POST['prixArticle'])) && (!empty($_POST['categorie'])) && (!empty($_POST['nbStock']))) {

        $nomArticle = filter_input(INPUT_POST, 'nomArticle', FILTER_SANITIZE_STRING);
        $descriptionArticle = filter_input(INPUT_POST, 'descriptionArticle', FILTER_SANITIZE_STRING);
        $prixArticle = filter_input(INPUT_POST, 'prixArticle', FILTER_VALIDATE_FLOAT);
        $idCategorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_STRING);
        $stock = filter_input(INPUT_POST, 'nbStock', FILTER_VALIDATE_INT);
        $idArticle = filter_input(INPUT_POST, 'idArticle', FILTER_VALIDATE_INT);
        $imageActuelle = filter_input(INPUT_POST, 'imageActuelle', FILTER_SANITIZE_STRING);

        $extensions_autorisees = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/JPG');
        if (($stock > 0) && ($stock <= 100)) {
            if (($prixArticle > 0) && ($prixArticle <= 150)) {
                if (($_FILES['uploadImageArticle']['size'] !== 0)) {
                    // Variable qui contient un identifiant unique qui sera par la suite ajouté au nom de fichier pour que le nom de fichier soit unique
                    $uniqId = uniqid();
                    $count = explode('.', $_FILES['uploadImageArticle']['name']);
                    $count2 = strlen($count[1]);
                    $extension = substr($_FILES['uploadImageArticle']['name'], -$count2);

                    // On ajoute l'identifiant unique au nom de l'image qu'on stocke dans une variable
                    $imageArticle = $uniqId . "." . $extension;

                    if (in_array($_FILES['uploadImageArticle']['type'], $extensions_autorisees)) {
                        // La fonction permet de transférer les fichiers sélectionné dans un répertoire
                        move_uploaded_file($_FILES['uploadImageArticle']['tmp_name'], "../img/$imageArticle");
                        if (!is_uploaded_file($_FILES['uploadImageArticle']['tmp_name'])) {
                            // On finit par ajouter les fichiers dans la base de données
                            $idPrix = addPrice($prixArticle);
                            updateArticle($nomArticle, $imageArticle, $descriptionArticle, $stock, $idCategorie, $idPrix, $idArticle);
                            header('Location: produits.php');
                            die();

                        }
                    } else {
                        array_push($array_error, "Veuillez sélectionner que des images !");
                    }
                } else {
                    $idPrix = addPrice($prixArticle);
                    updateArticle($nomArticle, $imageActuelle, $descriptionArticle, $stock, $idCategorie, $idPrix, $idArticle);
                    header('Location: produits.php');
                    die();
                }
            } else {
                array_push($array_error, "Veuillez entrer une valeur entre 1 et 150 pour le prix!");
            }
        } else {
            array_push($array_error, "Veuillez entrer une valeur entre 1 et 100 pour le stock!");
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
    <title>Modifier un produit</title>
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
    <h2>Modification d'un produit</h2>
</header>
<article id="containerAjoutProduit">
    <section>
        <?php
        if ($success != "") {
            echo '<div class="alert alert-success" role="alert">';
            echo $success;
            echo '<br>';
            echo '<a href="produits.php">retour à la page des produits</a>';
            echo '</div>';
        }
        ?>
        <form method="post" action="modifierProduit.php" enctype="multipart/form-data">
            <?php
            if (isset($_GET['id'])) {
                foreach ($getArticleInfo as $key => $value) { ?>
                    <div class="form-group">
                        <label for="nomArticle"><b>Nom de l'article</b></label>
                        <input type="text" class="form-control" required value="<?= $value['nomArticle']; ?>"
                               name="nomArticle" placeholder="Le nom de l'article">
                    </div>
                    <div class="form-group">
                        <label for="imageArticle"><b>Image de l'article</b></label>
                        <img src="../img/<?= $value['imageArticle']; ?>">
                        <input type="text" hidden name="imageActuelle" value="<?= $value['imageArticle']; ?>">
                        <input type="file" class="form-control-file" accept="image/*" name="uploadImageArticle">
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea"><b>Description de l'article</b></label>
                        <textarea class="form-control" required name="descriptionArticle"
                                  rows="3"><?= $value['descriptionArticle']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="example-number-input"><b>Prix de l'article</b></label>
                        <div class="col-10">
                            <input class="form-control oklm" required value="<?= $value['prix']; ?>" name="prixArticle"
                                   type="number" min="1" max="100">
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
                            <input class="form-control oklm" name="nbStock" value="<?= $value['stock']; ?>"
                                   type="number"
                                   min="1" max="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-10">
                            <input class="form-control oklm" name="idArticle" value="<?= $idArticle; ?>" type="hidden">
                        </div>
                    </div>

                    <?php
                }
            }
            ?>
            <div class="form-group">
                <button type="submit" name="modification" class="btn btn-primary">Modifier le produit</button>
            </div>
        </form>
    </section>
</article>
</body>
</html>