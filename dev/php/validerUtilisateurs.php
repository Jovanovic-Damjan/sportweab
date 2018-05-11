<?php
session_start();

require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
$success = "";

if (isset($_POST['valider'])) {
    $idUser = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $validate = validateUser($idUser);
    $success = "Utilisateur validé avec succès !";
}

if(isset($_SESSION['typeUtilisateur']) && $_SESSION['typeUtilisateur'] !== "Administrateur")
{
    header("location: index.php");
    exit();
}
$usersToValidate = getNotValidateUsers();

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Valider des utilisateurs</title>
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
    <h2>Valider des utilisateurs</h2>
</header>
<article>
    <section>
        <table class="table-striped">
            <th>E-mail</th>
            <th>Action</th>
            <?php
            foreach ($usersToValidate as $key => $value) { ?>
                <form method="post" action="validerUtilisateurs.php">
                    <tr>
                        <td class="users"><?= $value['mailUtilisateur']; ?></td>
                        <td class="users"><input type="submit" class="btn btn-info" name="valider" value="Valider"></td>
                        <td><input hidden type="text" name="id" value="<?= $value['idUtilisateur'] ?>"></td>
                    </tr>
                </form>
            <?php } ?>
            <tr>
                <td colspan="4"><a href="administration.php">Retour à l'administration</a></td>
            </tr>
        </table>
        <?php
        if ($success != "") {
            echo '<div class="alert alert-success message" role="alert">';
            echo $success;
            echo '</div>';
        }?>
    </section>
</article>
</body>
</html>