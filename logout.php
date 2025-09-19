<?php
session_start();
require_once('db/connection.php');

if(!isset($_SESSION['user_details'])){
    header('Location:login.php');
    exit;
}

unset($_Session['user_details']);
session_destroy();
header('Location:login.php');
exit;

?>