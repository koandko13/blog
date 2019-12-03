<?php
session_start();

include '../config/config.php';
include '../librairies/db.lib.php';

$view = 'login';
$title = 'LogIn';
$activeMenu = 'login';
$error = '';


try{
    if(array_key_exists ('email',$_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $dbh = connexion();

        $sth = $dbh->prepare("SELECT id,email,username,password,firstname,lastname,role FROM users WHERE email = :email");
        $sth->bindValue(':email',$email);
        $sth->execute(); 
        
        $users = $sth->fetch(PDO::FETCH_ASSOC);

        $passwordVerify = password_verify($password,$users['password']);
        if($passwordVerify == true){
            $_SESSION['connected'] = true;
            $_SESSION['user'] = ['id'=>$users['id'],'email'=>$users['email'],'username'=>$users['username'],'firstname'=>$users['firstname'],'lastname'=>$users['lastname'],'role'=>$users['role']];
            header('Location:index.php');
        }
        else{
            $error = 'Identifiants incorrect';
        }
    }
}
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}
include 'tpl/login.phtml';
?>































<!-- $error='';
$dbh = connexion();
if(isset($_POST['submit'])){
    if(isset($_POST['email'])&& isset($_POST['password'])){
        if(!empty($_POST['email'])&& !empty($_POST['password'])){
            $email=htmlspecialchars($_POST['email']);
            $password=htmlspecialchars($_POST['password']);

            $sth = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $sth->execute(array($email,$passwordHash)); 
            if($sth->rowCount() == 1){
                $users = $sth->fetchAll(PDO::FETCH_ASSOC); 
                $_SESSION ['users'] = $users;
            }
            else{
                $error = "Email ou password incorrect";
            }
        }        
    }
    else{
        $error="Erreur";
    }
} -->