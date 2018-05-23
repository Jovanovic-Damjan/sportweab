<?php
define('DB_HOST', "127.0.0.1"); //adresse ip de la base.
define('DB_NAME', "sportweab"); //nom de la base de donnée.
define('DB_USER', "sportweab"); //utilisateur.
define('DB_PASS', "1202"); //mdp.
/* Fonction permettant la connexion à la base de données  */
function getConnexion()
{
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

/* Fonction permettant d'afficher les rôles des utilisateurs */
function getImage()
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT imageArticle FROM articles;");
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permettant d'afficher des articles*/
function getArticles($categorie,$order,$way)
{
    $query = "SELECT DISTINCT articles.idArticle, nomArticle, imageArticle, descriptionArticle,stock,nomCategorie, max(prixarticles.dateDebut), prixarticles.prix FROM articles, categories, prixarticles WHERE articles.idArticle = prixarticles.idArticle AND articles.idCategorie = categories.idCategorie AND articles.idPrixArticle = prixarticles.idPrixArticle ";
    switch ($categorie){
        case "Hoodie" : $query .= " AND nomCategorie = \"hoodie\" GROUP BY articles.idArticle ORDER BY ";
        break;
        case "Casquette" : $query .= " AND nomCategorie = \"casquette\" GROUP BY articles.idArticle ORDER BY ";
            break;
        case "T-shirt" : $query .= " AND nomCategorie = \"T-shirt\" GROUP BY articles.idArticle ORDER BY ";
            break;
        default : $query .= " GROUP BY articles.idArticle ORDER BY ";
    }
    switch ($order){
        case "prix" : $query .= " prix ";
            break;
        case "nomCategorie" : $query .= " nomCategorie ";
            break;
        default : $query .= " articles.idArticle DESC ";
    }
    switch ($way){
        case "ASC" : $query .= " ASC;";
        break;
        case "DESC" : $query .= " DESC;";
        break;
        default :$query .= ";";
    }
    $connexion = getConnexion();
    $request = $connexion->prepare($query);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permettant de voir un utilisateur non-validé */
function getArticleByCategories($categorie)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT articles.idArticle, nomArticle, prix, nomCategorie FROM articles, categories, prixarticles WHERE articles.idCategorie = categories.idCategorie AND articles.idPrixArticle = prixarticles.idPrixArticle AND nomCategorie = :categorie;");
    $request->bindParam(':categorie', $categorie, PDO::PARAM_STR);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permettant d'afficher les informations de l'article en fonction de l'id de l'article*/
function getArticleInfo($id)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT DISTINCT articles.idArticle, articles.nomArticle, articles.imageArticle, articles.descriptionArticle, articles.stock, categories.nomCategorie, articles.idPrixArticle, prixarticles.idPrixArticle, prixarticles.prix, MAX(dateDebut), dateFin FROM articles, categories INNER JOIN prixarticles WHERE articles.idPrixArticle = prixarticles.idPrixArticle AND articles.idCategorie = categories.idCategorie AND prixarticles.idArticle = :idArticle ORDER BY prixarticles.dateDebut ASC;");
    $request->bindParam(':idArticle', $id, PDO::PARAM_INT);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

/* Fonction permettant de se connecter  */
function login($login, $pwd)
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
function addPrice($prixArticle, $dateFin, $idArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `prixarticles` (`prix`, `dateDebut`, `dateFin`, `idArticle`) VALUES (:prix, CURRENT_DATE(), :dateFin, :idArticle)");
    $request->bindParam(':prix', $prixArticle, PDO::PARAM_STR);
    $request->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permetant de valider un utilisateur */
function updatePrice($idArticle, $idPrixArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE prixarticles SET dateFin = current_date() WHERE dateDebut = (SELECT MAX(dateDebut) WHERE idArticle = :idArticle AND idPrixArticle = :idPrixArticle);");
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->bindParam(':idPrixArticle', $idPrixArticle, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permetant de valider un utilisateur */
function updatePriceArticle($idArticle, $idPrixArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE prixarticles SET idArticle = :idArticle WHERE idPrixArticle = :idPrixArticle;");
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->bindParam(':idPrixArticle', $idPrixArticle, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant de créer un utilisateur  */
function addArticle($nomArticle, $imageArticle, $descriptionArticle, $stock, $idCategorie, $idPrixArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `articles` (`nomArticle`, `imageArticle`, `descriptionArticle`, `stock`, `idCategorie`, `idPrixArticle`) VALUES (:nomArticle, :imageArticle, :descriptionArticle, :stock, :idCategorie, :idPrixArticle)");
    $request->bindParam(':nomArticle', $nomArticle, PDO::PARAM_STR);
    $request->bindParam(':imageArticle', $imageArticle, PDO::PARAM_STR);
    $request->bindParam(':descriptionArticle', $descriptionArticle, PDO::PARAM_STR);
    $request->bindParam(':stock', $stock, PDO::PARAM_INT);
    $request->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $request->bindParam(':idPrixArticle', $idPrixArticle, PDO::PARAM_INT);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant de modifier les données des utilisteurs */
function updateArticle($nomArticle, $imageArticle, $descriptionArticle, $stock, $idCategorie, $idPrixArticle, $idArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE articles SET nomArticle = :nomArticle, imageArticle = :imageArticle, descriptionArticle = :descriptionArticle, stock = :stock, idCategorie = :idCategorie, idPrixArticle = :idPrixArticle WHERE idArticle = :idArticle;");
    $request->bindParam(':nomArticle', $nomArticle, PDO::PARAM_STR);
    $request->bindParam(':imageArticle', $imageArticle, PDO::PARAM_STR);
    $request->bindParam(':descriptionArticle', $descriptionArticle, PDO::PARAM_STR);
    $request->bindParam(':stock', $stock, PDO::PARAM_INT);
    $request->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $request->bindParam(':idPrixArticle', $idPrixArticle, PDO::PARAM_INT);
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant de supprimer un article */
function deleteArticle($idArticle)
{
    $connexion = getConnexion();
    $requete = $connexion->prepare("DELETE FROM articles WHERE articles.idArticle = :idArticle;");
    $requete->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $requete->execute();
}

/* Fonction permettant de modifier les données des utilisteurs */
function checkoutCart($numCommande, $idClient)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE panier_commandes SET numCommande = :numCommande WHERE idClient = :idClient AND numCommande IS NULL;");
    $request->bindParam(':numCommande', $numCommande, PDO::PARAM_STR);
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->execute();
}

/* Fonction permettant d'ajouter un article dans son panier */
function addArticleToCart($taille, $idClient, $idArticle, $idPrixArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE articles SET stock = stock - 1 WHERE idArticle = :idArticle AND stock > 0 ;");
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
    $request = $connexion->prepare("INSERT INTO `panier_commandes` (`dateCommande`, `taille`, `idClient`, `idPrixArticle`) VALUES (CURRENT_DATE(), :taille, :idClient, :idPrixArticle)");
    $request->bindParam(':taille', $taille, PDO::PARAM_STR);
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->bindParam(':idPrixArticle', $idPrixArticle, PDO::PARAM_INT);
    $request->execute();
    return $connexion->lastInsertId();
}

/* Fonction permettant d'ajouter un article dans son panier */
function updateStock($idArticle)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE articles SET stock = stock + 1 WHERE idArticle = :idArticle AND stock >= 0 ;");
    $request->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $request->execute();
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
    $request = $connexion->prepare("SELECT distinct panier_commandes.idCommande, articles.idArticle, articles.nomArticle, articles.imageArticle , prixarticles.prix, panier_commandes.taille,  prixarticles.dateDebut, prixarticles.dateFin, panier_commandes.dateCommande,panier_commandes.idClient FROM panier_commandes, articles, client_passant_commande, clients, prixarticles, articles_concernant_commande WHERE panier_commandes.idCommande = articles_concernant_commande.idCommande AND articles_concernant_commande.idArticle = articles.idArticle AND panier_commandes.idCommande = client_passant_commande.idCommande AND panier_commandes.idPrixArticle = prixarticles.idPrixArticle AND client_passant_commande.idClient = clients.idClient AND articles.idArticle = prixarticles.idArticle AND prixarticles.dateDebut <= panier_commandes.dateCommande AND (prixarticles.dateFin >= panier_commandes.dateCommande) AND numCommande IS NULL AND client_passant_commande.idClient = :idClient;");
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function getSumCart($idClient)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT sum(prixarticles.prix) as 'total' FROM panier_commandes, prixarticles, articles, articles_concernant_commande WHERE panier_commandes.idPrixArticle = prixarticles.idPrixArticle AND panier_commandes.idCommande = articles_concernant_commande.idCommande AND articles_concernant_commande.idArticle = articles.idArticle AND numCommande IS NULL AND panier_commandes.idClient = :idClient;");
    $request->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
}

function deleteArticleFromCart($idClient, $idCommande)
{
    $connexion = getConnexion();
    $requete = $connexion->prepare("DELETE FROM panier_commandes WHERE panier_commandes.idClient = :idClient AND panier_commandes.idCommande = :idCommande;");
    $requete->bindParam(':idClient', $idClient, PDO::PARAM_INT);
    $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $requete->execute();
}

function deleteCommandConcernArticle($idArticle, $idCommande)
{
    $connexion = getConnexion();
    $requete = $connexion->prepare("DELETE FROM articles_concernant_commande WHERE articles_concernant_commande.idArticle = :idArticle AND articles_concernant_commande.idCommande = :idCommande ;");
    $requete->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
    $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
    $requete->execute();
}

/* Fonction permettant de voir un utilisateur non-validé */
function getIdArticleFromCart($idClient)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT idCommande FROM panier_commandes WHERE  idClient = :idClient;");
    $request->bindParam(':idClient', $idClient, PDO::PARAM_STR);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permettant de voir un utilisateur non-validé */
function getWallet($idUser)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT * FROM portemonnaie WHERE idUtilisateur = :idUtilisateur;");
    $request->bindParam(':idUtilisateur', $idUser, PDO::PARAM_INT);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

/* Fonction permettant de modifier les données des utilisteurs */
function updateWallet($idUtilisateur, $solde)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("UPDATE portemonnaie SET solde = :solde WHERE idUtilisateur = :idUtilisateur;");
    $request->bindParam(':solde', $solde, PDO::PARAM_STR);
    $request->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
    $request->execute();
}

function createBills($montant, $allIdCommand)
{
    $values = null;
    foreach ($allIdCommand as $key => $idCommand)
    {
        $values .= '(:montant,'.$idCommand['idCommande'].' ),';
    }
    $values = substr($values,0,-1);
    $connexion = getConnexion();
    $request = $connexion->prepare("INSERT INTO `factures` (`montantTotal`, `idCommande`) VALUES $values");
    $request->bindParam(':montant', $montant, PDO::PARAM_STR);
    $request->execute();
}

function getIdCommand($idUser)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT idCommande FROM sportweab.panier_commandes WHERE idClient = :idUtilisateur;");
    $request->bindParam(':idUtilisateur', $idUser, PDO::PARAM_INT);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}


function getAllCommands($idUser)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT DISTINCT * FROM panier_commandes WHERE idClient = :idUtilisateur GROUP BY numCommande;");
    $request->bindParam(':idUtilisateur', $idUser, PDO::PARAM_INT);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getDetailsCommand($idClient,$numCommand)
{
    $connexion = getConnexion();
    $request = $connexion->prepare("SELECT distinct articles.idArticle, articles.nomArticle, imageArticle,panier_commandes.taille, prixarticles.prix FROM panier_commandes, prixarticles, articles, articles_concernant_commande , factures WHERE panier_commandes.idPrixArticle = prixarticles.idPrixArticle AND panier_commandes.idCommande = articles_concernant_commande.idCommande AND articles_concernant_commande.idArticle = articles.idArticle AND panier_commandes.idCommande = factures.idCommande AND panier_commandes.idClient = :idUtilisateur AND panier_commandes.numCommande = :numCommande AND panier_commandes.numCommande IS NOT NULL;");
    $request->bindParam(':idUtilisateur', $idClient, PDO::PARAM_INT);
    $request->bindParam(':numCommande', $numCommand, PDO::PARAM_STR);
    $request->execute();
    $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

?>