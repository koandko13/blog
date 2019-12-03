<?php
session_start();
include '../config/config.php';
include '../librairies/db.lib.php';


$view = 'addCategories';
$title = "Catégories";
$activeMenu = 'categories';

$categorie = '';
$ordre = '';
$error = '';
try{
     if(array_key_exists ('name_categorie',$_POST)){
        $categorie = $_POST['name_categorie'];
        $ordre = $_POST['ordre'];

        $dbh = connexion();
        $sth = $dbh->prepare("
            INSERT INTO categories(name_categorie, ordre)
            VALUES (:name_categorie, :ordre)
        ");
        $sth->bindValue(':name_categorie',$categorie);
        $sth->bindValue(':ordre',$ordre);

        $sth->execute(); 

        header('Location: listCategories.php');
    }
}
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}
include 'tpl/layout.phtml';
?>