<?php
session_start();

header("content-type:application/json");
header("Access-Control-Allow-Methods: POST");

$conn_obj = new mysqli('127.0.0.1:3310','root','','demo');

if(!$conn_obj){
    print(json_encode(array("message"=>"connection is not established! ".$conn_obj->connect_error)));
}

$get_json_context = file_get_contents('php://input');
$json_decoded = json_decode($get_json_context);

$user_id = $json_decoded->email;
$pass = $json_decoded->pass;


if($user_id==" " || $pass==" ")
{
    print(json_encode(array("message"=>"Empty fields not allowed!")));
}
else
{
    $user_id = filter_var($json_decoded->email,FILTER_SANITIZE_EMAIL);
    $pass = filter_var($json_decoded->pass,FILTER_SANITIZE_STRING);

    $prepare_stmt_obj = $conn_obj->prepare("CALL user_login(?,?)");
    $prepare_stmt_obj->bind_param('ss',$user_id,$pass);

    if($prepare_stmt_obj->execute())
    {
        $prepare_stmt_obj->bind_result($id,$name,$email,$passw,$photo);
        $get_row = $prepare_stmt_obj->fetch();
        if($get_row===true)
        {
            $_SESSION['user_id'] = $email;
            //header("Location:display.php"); //for successful login redirect.
            print(json_encode(array("message"=>"Login Successful!","get_row"=>$get_row)));
        }
        else
        {
            print(json_encode(array("message"=>"Login Not Successful!","get_row"=>$get_row)));
        }
    }
    else
    {
        print(json_encode(array("message"=>"Something went wrong!","error_message"=>$conn_obj->error)));
    }
}

?>