<?php
session_start();
include '../config/config.php';
include '../librairies/db.lib.php';

$view = 'listCategories';
$title = 'Liste des catégories';
$activeMenu = 'listCategories';
try{
    $dbh = connexion();
    
    $sth = $dbh->prepare("SELECT * FROM categories ORDER BY id");
    $sth->execute();   
    $category = $sth->fetchAll(PDO::FETCH_ASSOC);

}
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}
include 'tpl/layout.phtml';
?>