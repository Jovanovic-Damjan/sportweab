<?php
/**
 * Created by PhpStorm.
 * User: Damja
 * Date: 03.04.2018
 * Time: 15:16
 */


function menu()
{
    if (isset($_SESSION['idClient'])) {
        $idClient = $_SESSION['idClient'];
    }
    $panier = getCart($idClient);

    echo "<nav class='navbar navbar-expand-lg navbar-light bg-white'>
    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>

    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='index.php'>Accueil</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='produits.php'>Produits</a>
            </li>";
    if ((isset($_SESSION["login"])) && ($_SESSION["typeUtilisateur"] == "Administrateur")) {
        echo "<li class='nav-item'><a class='nav-link' href='administration.php'>Administration</a></li>";
        echo "<li class='nav-item'><a class='nav-link' href='deconnexion.php'>Logout</a></li>";
    } elseif ((isset($_SESSION["login"])) && ($_SESSION["typeUtilisateur"] == "Utilisateur")) {
        echo "<li class='nav-item'>" . $_SESSION["login"] . "</li>";
        echo "<li class='nav-item'><a class='nav-link' href='panier.php'>Panier<span class=\"badge badge-pill badge-dark\">".count($panier)."</span></a></li>";
        echo "<li class='nav-item'><a class='nav-link' href='deconnexion.php'>Logout</a></li>";
    } elseif (!isset($_SESSION["login"])) {
        echo "<li class='nav-item'><a class='nav-link' href='connexion.php'>Login</a></li>";
    }
    echo "</ul>
    </div>
</nav>";
}

function getSelectCategories(){
    $categories = getCategories();
    if(isset($_GET['id'])){
        $actualCategorie = getArticleInfo($_GET['id'])[0]['idCategorie'];
        foreach ($categories as $key => $value) {
            if ($value['idCategorie'] == $actualCategorie){
                echo '<option selected value='.$value['idCategorie'].'>'. $value['nomCategorie'] . '</option>';
            }
            else {
                echo '<option value=' . $value['idCategorie'] . '>' . $value['nomCategorie'] . '</option>';
            }
        }
    }
    else{
        foreach ($categories as $key => $value) {
                echo '<option value=' . $value['idCategorie'] . '>' . $value['nomCategorie'] . '</option>';
        }
    }
}


?>