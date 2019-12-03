<?php
session_start();
include '../config/config.php';
include '../librairies/db.lib.php';

$view = 'listUser';
$title = 'Liste Users';
$activeMenu = 'liste';
try{
    $dbh = connexion();

    $sth = $dbh->prepare("SELECT * FROM users ORDER BY id");
    $sth->execute();   
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);

}
      
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}
include 'tpl/layout.phtml';

?>