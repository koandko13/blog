<?php
session_start();
include '../config/config.php';
include '../librairies/db.lib.php';

$view = 'addArticles';
$title = 'Article';
$activeMenu = 'article';

    if(!isset($_SESSION['connected']) || $_SESSION['connected'] != true){
        header('Location: login.php'); exit();
    }

$titleArt = '';
$contentArt = '';
$imageArt = '';
$categoriesId='';
$error = '';

try{
        
    $dbh = connexion();
    $sth1 = $dbh ->prepare('SELECT id,name_categorie FROM categories');
    $sth1 ->execute();
    $categories = $sth1->fetchAll(PDO::FETCH_ASSOC);

    if (array_key_exists('title_art',$_POST)){
        $titleArt = $_POST['title_art'];
        $contentArt = $_POST['content_art'];
        $categoriesId = $_POST['name_categorie'];
        //$imageArt = $_POST['image_art'];
        
        $uploads_dir = '../uploads';
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["file"]["tmp_name"];
            
    // basename() peut empêcher les attaques de système de fichiers;
    // la validation/assainissement supplémentaire du nom de fichier peut être approprié
            $name = uniqid().basename($_FILES["file"]["name"]);
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            
        }
         
        $sth = $dbh->prepare("
            INSERT INTO article(title_art,create_date,content_art,image_art,categories_id)
            VALUES (:title_art,:date,:content_art,:image_art,:categories_id)
        ");
        $date = new DateTime();
        // $dateP = new DateTime();
        $sth->bindValue(':title_art',$titleArt);
        $sth->bindValue(':date',$date->format('Y-m-d H:i:s'));
        // $sth->bindValue(':published_date',$dateP->format('Y-m-d'));
        $sth->bindValue(':content_art',$contentArt);
        $sth->bindValue(':image_art',$name);
        $sth->bindValue(':categories_id',$categoriesId);
        $sth->execute();
        echo "Entrée ajoutée dans la table";
        
       header('Location: listArticles.php');
        //exit();
    }
       


}
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}    
include 'tpl/layout.phtml';
?>