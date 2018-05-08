<?php
session_start();
define('DB_HOST', "127.0.0.1"); //adresse ip de la base.
define('DB_NAME', "sportweab"); //nom de la base de donnée.
define('DB_USER', "sportweab"); //utilisateur.
define('DB_PASS', "1202"); //mdp.
/* Fonction permettant la connexion à la base de données  */
function getConnexion() {
    static $dbb = null;
    if ($dbb === null) {
        try {
            $connectionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '';
            $dbb = new PDO($connectionString, DB_USER, DB_PASS);
            $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbb->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $dbb;
}
/* Fonction permettant d'afficher les rôles des utilisateurs */
function getRoles(){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * FROM utilisateur;");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        throw $e;
    }
}
/* Fonction permettant d'afficher des articles*/
function getArticles(){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT DISTINCT idArticle, nomArticle, imageArticle, descriptionArticle,stock,nomCategorie,prix FROM articles, categories, prix WHERE articles.idPrix = prix.idPrix AND articles.idCategorie = categories.idCategorie ORDER BY idArticle DESC ;");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        throw $e;
    }
}

function getArticleInfo($id){
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT DISTINCT idArticle, nomArticle, imageArticle, descriptionArticle,stock,nomCategorie,prix FROM articles, categories, prix WHERE articles.idPrix = prix.idPrix AND articles.idCategorie = categories.idCategorie and idArticle = :id;");
        $request->bindParam(':id', $id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}

/* Fonction permettant de se connecter  */
function login($login,$pwd)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM utilisateurs where mailUtilisateur = :nom and motPasse = :mdp");
    $request->bindParam(':nom', $login, PDO::PARAM_STR);
    $request->bindParam(':mdp', $pwd, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function createUser($nom, $prenom, $adresse, $codePostal, $ville, $telephone, $mail, $motPasse)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `clients` (`nom`, `prenom`, `adresse`, `codePostal`, `ville`, `telephone`, `mail`, `motPasse`) VALUES (:nom, :prenom, :adresse, :codePostal, :ville, :telephone, :mail, :motPasse)");
    $request->bindParam(':nom', $nom, PDO::PARAM_STR);
    $request->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $request->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $request->bindParam(':codePostal', $codePostal, PDO::PARAM_INT);
    $request->bindParam(':ville', $ville, PDO::PARAM_STR);
    $request->bindParam(':telephone', $telephone, PDO::PARAM_INT);
    $request->bindParam(':mail', $mail, PDO::PARAM_STR);
    $request->bindParam(':motPasse', $motPasse, PDO::PARAM_STR);
    $request->execute();
    return $connexion->lastInsertId();
}

function user_exists($mail){
    try {
        $connexion = getConnexion();
        $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE mailUtilisateur = :email;");
        $requete->bindParam(':email', $mail, PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        throw $e;
    }
}


/* Fonction permettant de s'enregistrer  */
function registerUser($mail, $password)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `utilisateurs` (`mailUtilisateur`, `motPasse`) VALUES (:mail, :motPasse)");
    $request->bindParam(':mail', $mail, PDO::PARAM_STR);
    $request->bindParam(':motPasse', $password, PDO::PARAM_STR);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant de s'enregistrer  */
function registerClient($nom, $prenom, $adresse, $codePostal, $ville, $pays, $telephone, $mail, $motPasse, $idUser)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `clients` (`nom`, `prenom`, `adresse`, `codePostal`, `ville`, `pays`,`telephone`, `mail`, `motPasse`, `idUtilisateur`) VALUES (:nom, :prenom, :adresse, :codePostal, :ville, :pays, :telephone, :mail, :motPasse, :idUtilsateur)");
    $request->bindParam(':nom', $nom, PDO::PARAM_STR);
    $request->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $request->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $request->bindParam(':codePostal', $codePostal, PDO::PARAM_INT);
    $request->bindParam(':ville', $ville, PDO::PARAM_STR);
    $request->bindParam(':pays', $pays, PDO::PARAM_STR);
    $request->bindParam(':telephone', $telephone, PDO::PARAM_INT);
    $request->bindParam(':mail', $mail, PDO::PARAM_STR);
    $request->bindParam(':motPasse', $motPasse, PDO::PARAM_STR);
    $request->bindParam(':idUtilisateur', $idUser, PDO::PARAM_INT);
    $request->execute();
}

function getUserInformation($email)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM clients, utilisateurs WHERE clients.mail = :mail AND utilisateurs.mailUtilisateur = :mail");
    $request->bindParam(':mail', $email, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function getUserRole($email)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM  utilisateurs WHERE mailUtilisateur = :mail;");
    $request->bindParam(':mail', $email, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function getNonValidateUser(){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * FROM utilisateurs WHERE typeUtilisateur = '';");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        throw $e;
    }
}

function getValidateUser(){
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * FROM utilisateur WHERE typeUtilisateur = 'Utilisateur';");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        throw $e;
    }
}

function validateUser($idUser) {
    try {
        $connexion = getConnexion();
        $request = $connexion->prepare("UPDATE utilisateurs SET typeUtilisateur = 'Utilisateur' WHERE idUtilisateur = :id ;");
        $request->bindParam(':id', $idUser, PDO::PARAM_INT);
        $request->execute();
    } catch (PDOException $e) {
        throw $e;
    }
}



?>
