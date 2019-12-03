<?php
session_start();
include '../config/config.php';
include '../librairies/db.lib.php';


$view = 'addUser';
$title = 'Formulaire';
$activeMenu = 'users';



$username = '';
$email = '';
$password = '';
$firstname = '';
$lastname = '';
$bio = '';
$avatar = '';
$role = '';
$password_again = '';
$error = '';


/******   FORMULAIRE ******** */
// if (!empty($username)
// && strlen($username) <= 50
// && preg_match("^[A-Za-z '-]+$",$username)
// && !empty($email)
// && filter_var($email, FILTER_VALIDATE_EMAIL)){}

try{
 
    if(array_key_exists ('username',$_POST)){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $bio = $_POST['bio'];
        $avatar = $_POST['avatar'];
        $role = $_POST['role'];
        $password_again = $_POST['password_again'];



    
        /* Verification du password */
        if($password !=$password_again){
            $error = 'Enter the same password';
        }
        // if (isset($_FILES['avatar']['tmp_name'])) {
        //     $retour = copy($_FILES['avatar']['tmp_name'], $_FILES['avatar']['name']);
        //     if($retour) {
        //         echo '<p>La photo a bien été envoyée.</p>';
        //         echo '<img src="' . $_FILES['avatar']['name'] . '">';
        //     }
        // }
        else{
    
        $dbh = connexion();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);   
        $sth = $dbh->prepare("
            INSERT INTO users(username,email,password,firstname,lastname,bio,create_date,role,avatar)
            VALUES (:username, :email, :password, :firstname, :lastname, :bio,:date,:role,:avatar)
        ");
        $date = new DateTime();
        $sth->bindValue(':username',$username);
        $sth->bindValue(':email',$email);
        $sth->bindValue(':password',$passwordHash);
        $sth->bindValue(':firstname',$firstname);
        $sth->bindValue(':lastname',$lastname);
        $sth->bindValue(':bio',$bio);
        $sth->bindValue(':date',$date->format('Y-m-d H:i:s'));
        $sth->bindValue(':role',$role);
        $sth->bindValue(':avatar',$avatar);
        $sth->execute();    
        echo "Entrée ajoutée dans la table";

        header('Location: listUser.php');
        }
    }
    
}
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}

include 'tpl/layout.phtml';
?>