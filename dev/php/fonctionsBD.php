<?php
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
function getRoles()
{
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * FROM utilisateur;");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
}

/* Fonction permettant d'afficher les rôles des utilisateurs */
function getCategories()
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM categories;");
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permettant d'afficher des articles*/
function getArticles()
{
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT DISTINCT idArticle, nomArticle, imageArticle, descriptionArticle,stock,nomCategorie,prix FROM articles, categories, prix WHERE articles.idPrix = prix.idPrix AND articles.idCategorie = categories.idCategorie ORDER BY idArticle DESC ;");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
}

/* Fonction permettant d'afficher les informations de l'article en fonction de l'id de l'article*/
function getArticleInfo($id){
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT DISTINCT articles.idArticle, articles.nomArticle, articles.imageArticle, articles.descriptionArticle, articles.stock, categories.nomCategorie, prix.prix FROM articles, categories, historiques_prix, prix WHERE articles.idCategorie = categories.idCategorie AND articles.idPrix = prix.idPrix AND articles.idArticle = :id;");
        $request->bindParam(':id', $id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}

/* Fonction permettant de se connecter  */
function login($login,$pwd)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM utilisateurs WHERE mailUtilisateur = :nom AND motPasse = :mdp;");
    $request->bindParam(':nom', $login, PDO::PARAM_STR);
    $request->bindParam(':mdp', $pwd, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

/* Fonction permettant de créer un client */
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

/* Fonction permettant de vérifier s'il y a déjà un utilisateur enregsitré dans la base de données avec le même e-mail*/
function user_exists($mail)
{
        $connexion = getConnexion();
        $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE mailUtilisateur = :email;");
        $requete->bindParam(':email', $mail, PDO::PARAM_STR);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
}


/* Fonction permettant de créer un utilisateur  */
function registerUser($mail, $password1)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `utilisateurs` (`mailUtilisateur`, `motPasse`) VALUES (:mail, :motPasse)");
    $request->bindParam(':mail', $mail, PDO::PARAM_STR);
    $request->bindParam(':motPasse', $password1, PDO::PARAM_STR);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant de s'enregistrer  */
function registerClient($nom, $prenom, $adresse, $codePostal, $ville, $pays, $telephone, $mail, $motPasse, $idUser)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `clients` (`nomClient`, `prenomClient`, `adresseClient`, `codePostal`, `ville`, `pays`, `telephone`, `mail`, `motPasse`, `idUtilisateur`) VALUES (:nom, :prenom, :adresse, :codePostal, :ville, :pays, :telephone, :mail, :motPasse, :idUtilisateur)");
    $request->bindParam(':nom', $nom, PDO::PARAM_STR);
    $request->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $request->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $request->bindParam(':codePostal', $codePostal, PDO::PARAM_INT);
    $request->bindParam(':ville', $ville, PDO::PARAM_STR);
    $request->bindParam(':pays', $pays, PDO::PARAM_STR);
    $request->bindParam(':telephone', $telephone, PDO::PARAM_STR);
    $request->bindParam(':mail', $mail, PDO::PARAM_STR);
    $request->bindParam(':motPasse', $motPasse, PDO::PARAM_STR);
    $request->bindParam(':idUtilisateur', $idUser, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant de s'enregistrer  */
function createWallet($idUser)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `portemonnaie` (`idUtilisateur`) VALUES (:idUtilisateur)");
    $request->bindParam(':idUtilisateur', $idUser, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant de recevoir les informations de l'utilisateur */
function getUserInformation($email)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM clients, utilisateurs WHERE clients.mail = :mail AND utilisateurs.mailUtilisateur = :mail");
    $request->bindParam(':mail', $email, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

/* Fonction permettant de voir le rôle de l'utilisateur */
function getUserRole($email)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM  utilisateurs WHERE mailUtilisateur = :mail;");
    $request->bindParam(':mail', $email, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

/* Fonction permettant de voir les utilisateurs non-validé */
function getNotValidateUsers()
{
        $connexion = getConnexion();
        $request = $connexion->prepare("SELECT * FROM utilisateurs WHERE typeUtilisateur = 'en attente';");
        $request->execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
}

/* Fonction permettant de voir un utilisateur non-validé */
function getNotValidateUser($email)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM utilisateurs WHERE  mailUtilisateur = :mail;");
    $request->bindParam(':mail', $email, PDO::PARAM_STR);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permetant de valider un utilisateur */
function validateUser($idUser)
{
        $connexion = getConnexion();
        $request = $connexion->prepare("UPDATE utilisateurs SET typeUtilisateur = 'Utilisateur' WHERE idUtilisateur = :id ;");
        $request->bindParam(':id', $idUser, PDO::PARAM_INT);
        $request->execute();
}

/* Fonction permettant d'ajouter un prix  */
function addPrice($prix)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `prix` (`prix`, `datePrix`) VALUES (:prix, CURRENT_DATE())");
    $request->bindParam(':prix', $prix, PDO::PARAM_STR);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant d'ajouter un prix  */
function addPriceHistoric($idPrix, $idArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `historiques_prix` (`idPrix`, `idArticle`) VALUES (:idPrix, :idArticle)");
    $request->bindParam(':idPrix', $idPrix, PDO::PARAM_INT);
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant de créer un utilisateur  */
function addArticle($nomArticle, $imageArticle, $descriptionArticle, $stock, $idCategorie, $idPrix)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `articles` (`nomArticle`, `imageArticle`, `descriptionArticle`, `stock`, `idCategorie`, `idPrix`) VALUES (:nomArticle, :imageArticle, :descriptionArticle, :stock, :idCategorie, :idPrix)");
    $request->bindParam(':nomArticle', $nomArticle, PDO::PARAM_STR);
    $request->bindParam(':imageArticle', $imageArticle, PDO::PARAM_STR);
    $request->bindParam(':descriptionArticle', $descriptionArticle, PDO::PARAM_STR);
    $request->bindParam(':stock', $stock, PDO::PARAM_INT);
    $request->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $request->bindParam(':idPrix', $idPrix, PDO::PARAM_INT);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant de modifier les données des utilisteurs */
function updateArticle($nomArticle,$imageArticle,$descriptionArticle,$stock,$idCategorie,$idPrix,$idArticle)
{
        $connexion = getConnexion();
        $request = $connexion->prepare("UPDATE articles SET nomArticle = :nomArticle, imageArticle = :imageArticle, descriptionArticle = :descriptionArticle, stock = :stock, idCategorie = :idCategorie, idPrix = :idPrix WHERE idArticle = :idArticle ;");
        $request->bindParam(':nomArticle', $nomArticle, PDO::PARAM_STR);
        $request->bindParam(':imageArticle', $imageArticle, PDO::PARAM_STR);
        $request->bindParam(':descriptionArticle', $descriptionArticle, PDO::PARAM_STR);
        $request->bindParam(':stock', $stock, PDO::PARAM_INT);
        $request->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
        $request->bindParam(':idPrix', $idPrix, PDO::PARAM_INT);
        $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $request->execute();
}

/* Fonction permettant de supprimer un article */
function deleteArticle($idArticle) {
        $connexion = getConnexion();
        $requete = $connexion->prepare("DELETE FROM articles WHERE articles.idArticle = :idArticle;");
        $requete->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $requete->execute();
}

/* Fonction permettant de modifier les données des utilisteurs */
function checkoutCart($nomArticle, $idClient)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE panier_commandes SET numCommande = :numCommande, dateCommande = CURRENT_DATE() WHERE idClient = :idClient ;");
    $request->bindParam(':nomArticle', $nomArticle, PDO::PARAM_STR);
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant d'ajouter un article dans son panier */
function addArticleToCart($taille, $idClient, $idArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE articles SET stock = stock - 1 WHERE idArticle = :idArticle AND stock > 0 ;");
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
    $request = $connexion->prepare("INSERT INTO `panier_commandes` (`taille`, `idClient`, `idArticle`) VALUES (:taille, :idClient, :idArticle)");
    $request->bindParam(':taille', $taille, PDO::PARAM_STR);
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant d'ajouter un prix  */
function CommandConcernArticle($idArticle, $idCommande)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `articles_concernant_commande` (`idArticle`, `idCommande`) VALUES (:idArticle, :idCommande)");
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant d'ajouter un prix  */
function CommandConcernClient($idClient, $idCommande)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `client_passant_commande` (`idClient`, `idCommande`) VALUES (:idClient, :idCommande)");
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $request->execute();
}

function getCart($idClient)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT DISTINCT panier_commandes.idCommande, articles.idArticle, articles.nomArticle, articles.imageArticle, taille, prix.prix FROM panier_commandes, articles, prix, historiques_prix, clients, client_passant_commande WHERE panier_commandes.idArticle = articles.idArticle AND panier_commandes.idClient = client_passant_commande.idClient AND articles.idPrix = prix.idPrix AND panier_commandes.idClient = :idClient;");
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function deleteArticleFromCart($idArticle, $idClient, $idCommande)
{
    $connexion = getConnexion();
    $requete = $connexion->prepare("DELETE FROM panier_commandes WHERE panier_commandes.idArticle = :idArticle AND panier_commandes.idClient = :idClient AND panier_commandes.idCommande = :idCommande;");
    $requete->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $requete->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $requete->execute();
    /*$requete = $connexion->prepare("DELETE FROM articles_concernant_commande WHERE idArticle = :idArticle AND idCommande = :idCommande;");
    $requete->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $requete->execute();
    $requete = $connexion->prepare("DELETE FROM client_passant_commande WHERE idClient = :idClient AND idCommande = :idCommande;");
    $requete->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $requete->execute();*/
}
?>
