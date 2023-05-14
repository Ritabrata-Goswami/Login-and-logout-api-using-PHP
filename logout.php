<?php
session_start();

header("content-type:application/json");
header("Access-Control-Allow-Methods: GET");

try{
    unset($_SESSION['user_id']);
    // header("Location:login.php"); //for successful logout redirection.
    print(json_encode(array("message"=>"Logout Successful!")));
}
catch(Exception $e){
    print(json_encode(array("message"=>$e->getMessage())));
}
?>