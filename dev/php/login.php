<?php
/**
 * Created by PhpStorm.
 * User: Damjan
 * Date: 11.03.2018
 * Time: 13:09
 */
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";

if (isset($_SESSION["connecté"]) == true) {
    header("location: index.php");
}
?>
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Index</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
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
        <section id="login">
            <form class="form-signin" action="login.php" method="post">
                <h2 class="form-signin-heading">Connexion</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Adresse mail" required="" autofocus="">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required="">
                <button class="btn btn-lg btn-primary btn-block" name="Submit" type="submit">Se connecter</button>
                <a href="register.php">Pas encore de compte ?</a>
            </form>
        </section>
    </article>
    </body>
    </html>
<?php
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
if (isset($_POST['Submit'])) {
    if ((isset($_POST["email"])) && (isset($_POST['password']))) {
        $pwd_hash = sha1($pwd);
        $utilisateur = login($email, $pwd_hash);
        $informationsClient = getUserInformation($email);

        if (!empty($informationsClient)) {
            if (count($informationsClient) > 0) {
                $_SESSION["connecté"] = true;
                $_SESSION["idUtilisateur"] = $informationsClient[0]["idUtilisateur"];
                $_SESSION["login"] = $informationsClient[0]["nomClient"] . " " . $informationsClient[0]["prenomClient"];
                $_SESSION["typeUtilisateur"] = $informationsClient[0]["typeUtilisateur"];
                header("location: index.php");
                exit();
            }
        } else {
            $error = "<div class=\"alert alert-danger\"><strong>Erreur ! </strong> Mauvaise informations de connexions !</div>";
        }
    }
}
?>