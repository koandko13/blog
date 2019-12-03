<?php
session_start();
include('config/config.php');
include('librairies/db.lib.php');


$view = 'index';

try{

$dbh = connexion();

$sth = $dbh->prepare("SELECT c.id as idCat, a.id as idArt,a.title_art,a.create_date,a.published_date,a.content_art,a.image_art,c.name_categorie,c.ordre  FROM article a INNER JOIN categories c ON (a.categories_id = c.id)");

$sth->execute();   
$articles = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}

include 'tpl/layout.phtml';

?>