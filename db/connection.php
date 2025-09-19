<?php
require_once __DIR__ . '/../config.php';



// establish connection


// try{
// $con = new mysqli($servername, $username, $password, $dbname);
// // echo " Connection Successfull";
// // $sql = "SELECT * FROM user_data";
// // $user_info = $con->query($sql);
// // echo "<pre>";
// // print_r($user_info->fetch_object());
// } catch (Exception $ex){
//     echo "Connection Failed".$ex->getMessage();
// }
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}





?>