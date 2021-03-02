<?php 
//the user is re-directed to this file after clicking the link received by email and aiming at providing they own the new email address
//signup link contains two get parameters: email and activation key
session_start();
include('connection.php');


?> 

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>New email activation</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        h1{
            color: purple;
        }
    </style>
    
    
    </head>
    <body>
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Email Activation</h1>
                <?php
                
                //if email, newemial and activation key is missing show an error

if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
    echo'<div class="alert alert-danger">there was an error. please click on you received by email.</div>';exit;
} 
//else
//       store them in two variables 
$email=$_GET['email'];
$newemail=$_GET['newemail'];                
$key=$_GET['key'];

//  prepare variables for query
  $email=mysqli_real_escape_string($link,$email);
                $newemail=mysqli_real_escape_string($link,$newemail);
  $key=mysqli_real_escape_string($link,$key);

//run query: update email 
$sql= "UPDATE users SET email='$email', activation2='0' WHERE (email='$email' AND activation2='$key' ) LIMIT 1"; 
$result = mysqli_query($link, $sql);


//if query is successful, show success message and invite users to log in page


if(mysqli_affected_rows($link) == 1){
    session_destroy();
    setcookie("rememberme", "", time()-3600);
    echo'<div class="alert alert-success">your email has been updated.</div>';
    echo '<a href="index.php" type="button" class="btn btn-lg btn-success">Login</a>'; 
}else{
    //error
    echo'<div class="alert alert-danger">your email could not be updated. please try again.</div>';
    echo'<div class="alert alert-danger">'. mysqli_error($link) .'</div>'; 
} 
                
                ?>
            </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax.libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>  

</html>