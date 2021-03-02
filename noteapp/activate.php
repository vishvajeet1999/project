<?php 

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
    
    <title>Account Activation</title>
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
            <h1>Account Activation</h1>
                <?php
                
                //if email and activation key is missing show an error

if(!isset($_GET['email']) || !isset($_GET['key'])){
    echo'<div class="alert alert-danger">there was an error. please click on activation you received by email.</div>';exit;
} 
//else
//       store them in two variables 
$email=$_GET['email'];
$key=$_GET['key'];

//  prepare variables for query
  $email=mysqli_real_escape_string($link,$email);
  $key=mysqli_real_escape_string($link,$key);

//run query: set activation field to activated for provided email
$sql= "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key' ) LIMIT 1"; 
$result = mysqli_query($link, $sql);


//if query is successful, show success message and invite users to log in page


if($result){
    echo'<div class="alert alert-success">your accoutn has been activated.</div>';
    echo '<a href="index.php" type="button" class="btn btn-lg btn-success">Login</a>'; 
}else{
    //error
    echo'<div class="alert alert-danger">your account could not be activated. please try again.</div>';
} 
                
                ?>
            </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax.libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>  

</html>