<?php
require_once "fonctionsBD.php";
require_once "htmlToPhp.php";

if (isset($_SESSION["connecté"]) == true) {
    header("location: ../index.php");
}
?>
<!doctype html>
<?php
$array_error = array();
$success = "";
if(isset($_POST['register'])) {
    if ((!empty($_POST['nom'])) && (!empty($_POST['prenom'])) && (!empty($_POST['email'])) && (!empty($_POST['password'])) && (!empty($_POST['confirmPassword'])) && (!empty($_POST['adresse'])) && (!empty($_POST['ville'])) && (!empty($_POST['pays'])) && (!empty($_POST['codePostal'])) && (!empty($_POST['telephone']))) {

        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING);

        $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_STRING);
        $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_STRING);
        $pays = filter_input(INPUT_POST, 'pays', FILTER_SANITIZE_STRING);
        $codePostal = filter_input(INPUT_POST, 'codePostal', FILTER_VALIDATE_INT);
        $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);


        function checkNameLastName($var)
        {
            $pattern = '/^[a-zA-Z]+(([\',. -][a-zA-Z ])?[a-zA-Z]*)*$/m';
            if (preg_match_all($pattern, $var, $matches, PREG_SET_ORDER, 0)) {
                return true;
            } else {
                return false;
            }
        }

        function LettersNumbers($var)
        {
            if (ctype_alnum($var)) {
                return true;
            } else {
                return false;
            }
        }

        function OnlyNumbers($var)
        {
            if (ctype_digit($var)) {
                return true;
            } else {
                return false;
            }
        }

        function MinMaxPwd($var)
        {
            if (count($var) > 4 || count($var) < 16) {
                return true;
            } else {
                return false;
            }
        }

        if (!checkNameLastName($nom)) {
            $error = "Le nom ne doit contenir que des charactères de A à Z";
        }
        if (!checkNameLastName($prenom)) {
            $error = "Le prénom ne doit contenir que des caractères de A à Z";
        }
        if (!MinMaxPwd($password)) {
            $error = "Le mot de passe doit être composé au minimum de 4 caractères";
        } else {
            $password1 = sha1($password);
        }
        if (!MinMaxPwd($confirmPassword)) {
            $error = "LLe mot de passe doit être composé au minimum de 4 caractères";
        } else {
            $password2 = sha1($confirmPassword);
        }

        if ($password1 == $password2) {
            if (user_exists($email) == false) {
                if ($array_error == null) {
                    $idUser = registerUser($email, $password1);
                    registerClient($nom, $prenom, $adresse, $codePostal, $ville, $pays, $telephone, $email, $password1, $idUser);
                    $success = "Enregistrement avec succès !";
                }
            } else {
                array_push($array_error, "Un compte existe déjà avec l'email : " . $email);
            }
        } else {
            array_push($array_error, "Les mots de passe ne correspondent pas.");
        }
    } else {
        array_push($array_error, "Veuillez remplir tous les champs.");
    }
}
?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
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
    <section id="register">
        <form method="post" action="register.php">
            <h4>Vos données personnelles</h4>
            <input type="text" name="nom" required class="form-control" placeholder="Nom">
            <input type="text" name="prenom" required class="form-control" placeholder="Prénom">
            <input type="email" name="email" required class="form-control" placeholder="Adresse mail">
            <input type="password" name="password" required class="form-control" placeholder="Votre mot de passe">
            <input type="password" name="confirmPassword" required class="form-control"
                   placeholder="Confirmer le mot de passe">
            <h4>Informations de livraisons</h4>
            <input type="text" name="adresse" required class="form-control" placeholder="Adresse">
            <input type="text" name="ville" required class="form-control" placeholder="Ville">
            <input type="text" name="pays" required class="form-control" placeholder="Pays">
            <input type="text" name="codePostal" required class="form-control" placeholder="Code postal">
            <input type="text" name="telephone" required class="form-control" placeholder="Numéro de téléphone">
            <input type="submit" name="register" class="btn btn-lg btn-primary btn-block">
        </form>
        <?php
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
    </section>
</article>
</body>
</html>

