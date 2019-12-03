<?php
session_start();
include('config/config.php');
include('librairies/db.lib.php');

$activeMenu = 'articles';
$view = 'articles';
$id = $_GET['id'];

try{

    $dbh = connexion();
    
    $sth = $dbh->prepare("SELECT * FROM article WHERE id = :id");

    $sth->bindValue(':id',$id);
    
    $sth->execute();   
    $articles = $sth->fetch(PDO::FETCH_ASSOC);
    }

catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
}
    
include 'tpl/layout.phtml';

?>