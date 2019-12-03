<?php
session_start();
include '../config/config.php';
include '../librairies/db.lib.php';


$delArticle='';

if(isset($_POST['id']))
{       $dbh = connexion();
    //recuperation de l'id de l'article a supprimer
        $id  = $_POST['id'] ;
    // on supprime l'artcle dans la base de donnee
        $delArticle = $dbh->prepare('DELETE FROM article WHERE id = :id');

        $delArticle->bindValue(':id',$id);
        $delArticle->execute();
        
}
else
{
      header('Location:index.php');
}