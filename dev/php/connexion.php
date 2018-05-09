<?php
session_start();
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";
require_once "captcha.php";
$array_error = array();

if (isset($_POST['Submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ((!empty($_POST['email'])) && (!empty($_POST['password'])) && (!empty($_POST['captcha']))) {
        if ($_POST['captcha'] == $_SESSION['captcha']) {
            $pwd_hash = sha1($pwd);
            $utilisateur = login($email, $pwd_hash);
            if (count($utilisateur) !== 0) {
                $informationsClient = getUserInformation($email);

                if (!empty($informationsClient)) {
                    if (count($informationsClient) > 0) {
                        $_SESSION["connecte"] = true;
                        $_SESSION["idUtilisateur"] = $informationsClient[0]["idUtilisateur"];
                        $_SESSION["login"] = $informationsClient[0]["nomClient"] . " " . $informationsClient[0]["prenomClient"];
                        $_SESSION["typeUtilisateur"] = $informationsClient[0]["typeUtilisateur"];
                    }
                }
            } else {
                array_push($array_error, "Mauvaises informations de connexions !");
            }
        } else {
            array_push($array_error, "Captcha erroné !");
        }
    } else {
        array_push($array_error, "Veuillez remplir tous les champs !");
    }
}
if (isset($_SESSION['connecte']) && $_SESSION['connecte'] == true) {
    header("location: index.php");
    exit();
}
?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Index</title>
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
        <section id="login">
            <?php
            /* Test qui vérifie qu'il existe des erreurs et les affiche */
            if (count($array_error) > 0) {
                echo '<div class="alert alert-danger error">';
                for ($i = 0; $i < count($array_error); $i++) {
                    echo $array_error[$i];
                    echo '<br/>';
                };
                echo '</div>';
            }
            ?>
            <form class="form-signin" action="connexion.php" method="post">
                <h2 class="form-signin-heading">Connexion</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Adresse mail" required value="<?php if (isset($email)) {echo $email;} ?>" autofocus="">
                <input type="password" name="password" id="inputPassword" class="form-control"
                       placeholder="Mot de passe" required="">
                <label for="captcha" onselectstart='return false'>Recopiez le mot : "<?php echo captcha(); ?>"</label>
                <input type="text" name="captcha" required placeholder="captcha" class="form-control" id="captcha"/><br/>
                <button class="btn btn-lg btn-primary btn-block" name="Submit" type="submit">Se connecter</button>
                <a href="inscription.php">Pas encore de compte ?</a>
            </form>
        </section>
    </article>
    </body>
    </html>