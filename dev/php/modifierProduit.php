<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
$idArticle = -1;
if(isset($_GET['id']) or ) {
    $idArticle = $_GET['id'];
    $getArticleInfo = getArticleInfo($idArticle);
}

if(isset($_SESSION['typeUtilisateur']) && $_SESSION['typeUtilisateur'] !== "Administrateur")
{
    header("Location: index.php");
    exit();
}

$categories = getCategories();
$dateActuelle = date("Y-m-d");

$array_error = array();
$success = "";

// Fonction qui permet de poster des images
if (isset($_POST['modification'])) {
    if ((!empty($_POST['nomArticle'])) && ($_FILES['imageArticle']['size'] !== 0) && ($_FILES['imageArticle']['error'] == 0) && (!empty($_POST['descriptionArticle'])) && (!empty($_POST['prixArticle'])) && (!empty($_POST['categorie'])) && (!empty($_POST['nbStock']))) {

        $nomArticle = filter_input(INPUT_POST, 'nomArticle', FILTER_SANITIZE_STRING);
        $descriptionArticle = filter_input(INPUT_POST, 'descriptionArticle', FILTER_SANITIZE_STRING);
        $prixArticle = filter_input(INPUT_POST, 'prixArticle', FILTER_VALIDATE_FLOAT);
        $idCategorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_STRING);
        $stock = filter_input(INPUT_POST, 'nbStock', FILTER_VALIDATE_INT);

        // Variable qui contient un identifiant unique qui sera par la suite ajouté au nom de fichier pour que le nom de fichier soit unique
        $uniqId = uniqid();

        $count = explode('.', $_FILES['imageArticle']['name']);
        $count2 = strlen($count[1]);
        $extension = substr($_FILES['imageArticle']['name'], -$count2);

        // On ajoute l'identifiant unique au nom de l'image qu'on stocke dans une variable
        $imageArticle = $uniqId . "." . $extension;

        // La fonction permet de transférer les fichiers sélectionné dans un répertoire
        move_uploaded_file($_FILES['imageArticle']['tmp_name'], "../img/$imageArticle");
        if (!is_uploaded_file($_FILES['imageArticle']['tmp_name'])) {
            // On finit par ajouter les fichiers dans la base de données
            $idPrix = addPrice($prixArticle,$dateActuelle);
            updateArticle($nomArticle,$imageArticle,$descriptionArticle,$stock,$idCategorie,$idPrix,$idArticle);
            $statut = "Article modifié avec succès !";

        }
    }
    else{
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
            echo '</div>';
        }
        ?>
        <form method="post" action="modifierProduit.php" enctype="multipart/form-data">
            <?php foreach($getArticleInfo as $key => $value){ ?>
            <div class="form-group">
                <label for="nomArticle"><b>Nom de l'article</b></label>
                <input type="text" class="form-control" required value="<?= $value['nomArticle'];?>" name="nomArticle" placeholder="Le nom de l'article">
            </div>
            <div class="form-group">
                <label for="imageArticle"><b>Image de l'article</b></label>
                <input type="file" class="form-control-file" accept="image/*" required name="imageArticle">
            </div>
            <div class="form-group">
                <label for="exampleTextarea"><b>Description de l'article</b></label>
                <textarea class="form-control" required  name="descriptionArticle" rows="3"><?= $value['descriptionArticle'];?></textarea>
            </div>
            <div class="form-group">
                <label for="example-number-input"><b>Prix de l'article</b></label>
                <div class="col-10">
                    <input class="form-control oklm" required value="<?= $value['prix'];?>" name="prixArticle" type="number" min="1" max="100" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputState"><b>Catégorie</b></label>
                <select name="categorie" required  class="form-control">
                    <?php getSelectCategories(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="example-number-input"><b>Nombre de stock</b></label>
                <div class="col-10">
                    <input class="form-control oklm" name="nbStock" value="<?= $value['stock'];?>" type="number" min="1" max="100">
                </div>
            </div>

                <div class="form-group">
                    <div class="col-10">
                        <input class="form-control oklm"  name="nbStock" value="<?= $idArticle; ?>" type="hidden">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <button type="submit" name="modification" class="btn btn-primary">Modifier le produit</button>
            </div>
        </form>
    </section>
</article>
</body>
</html>