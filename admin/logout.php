<?php
session_start();
$_SESSION['connected'] = false;
unset($_SESSION['user']);
// var_dump($_SESSION['user']);
header("Location:login.php");
$view = 'logout';
include 'tpl/layout.phtml';
?>