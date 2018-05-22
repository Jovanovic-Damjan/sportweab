SELECT idPrixArticle,prix,MAX(dateDebut), dateFin FROM prixArticles WHERE idArticle = 1;
UPDATE prixarticles SET dateFin = current_date() WHERE dateDebut = (SELECT MAX(dateDebut) WHERE idArticle = 1 AND idPrixArticle = 26);

SELECT DISTINCT articles.idArticle, articles.nomArticle, articles.imageArticle, articles.descriptionArticle, articles.stock, categories.nomCategorie,prixarticles.idPrixArticle, prixarticles.prix 
FROM articles, categories, prixarticles 
WHERE articles.idCategorie = categories.idCategorie 
AND articles.idArticle = prixarticles.idArticle 
AND articles.idArticle = 10 
ORDER BY prixarticles.dateDebut DESC LIMIT 1;

SELECT * FROM sportweab.prixarticles WHERE idArticle=11 ORDER BY dateDebut DESC;


SELECT DISTINCT articles.idArticle, articles.nomArticle, articles.imageArticle, articles.descriptionArticle, articles.stock, categories.nomCategorie, articles.idPrixArticle, prixarticles.idPrixArticle, prixarticles.prix, MAX(dateDebut), dateFin
FROM articles, categories
INNER JOIN prixarticles WHERE articles.idPrixArticle = prixarticles.idPrixArticle
AND articles.idCategorie = categories.idCategorie
AND prixarticles.idArticle = 11
ORDER BY prixarticles.dateDebut ASC;