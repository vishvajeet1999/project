<?php 
//this file receices the user_id and key generated to create the new password

//this file displays a form to input new password

session_start();
include('connection.php');


?> 

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Password Reset</title>
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
            <h1>Reset Password: </h1>
                <div id="resultmessage"> </div>
                
                <?php
                
                //if user_id and  key is missing show an error

if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo'<div class="alert alert-danger">there was an error. please click on the activation link you received by email.</div>';exit;
}  
//else
//       store them in two variables 
$user_id=$_GET['user_id'];
$key=$_GET['key'];
$time = time()-86400;

//  prepare variables for query
  $user_id=mysqli_real_escape_string($link, $user_id);
  $key=mysqli_real_escape_string($link, $key);

//run query: check combination of user_id and key exists and less than 24h old
$sql= "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND time>'$time'  AND status='pending'"; 
$result = mysqli_query($link, $sql);

                if(!$result){
    echo '<div class="alert alaert-danger" >error running the query</div>';  
    exit;  
}
         //if the combination does not exist.
                //show and error message.
   
$count= mysqli_num_rows($result); 
if($count !== 1){
    echo '<div class="alert alaert-danger" >please try again</div>';exit; 
}  
//print reset password form with hidden user_id and key fields
echo"
<form method = 'POST' id = 'passwordreset'>
<input type = hidden name = key value = $key>
<input type = hidden name = user_id value = $user_id>
<div class='form-group'>
<label for='password'> Enter your new password:</label>
<input type = 'password' name = 'password' placeholder='enter password' id='password' class='form-control'>
</div> 
<div class='form-group'>
<label for='password2'> re-enter password:</label>
<input type = 'password' name = 'password2' placeholder='re-enter password' id='password2' class='form-control'>
</div>
<input type = 'submit' name = 'resetpassword' class='btn btn-success btn-lg' value='Reset Password'>

</form>";       
            ?>
            
            
            </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax.libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
        <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
        
        <script>
            //script for ajax call to storeresetpassword.php which processes form data 
            
      $("#passwordreset").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
     
    //send them to signup.php using AJAX
    //    $.post({}).done().fail();
    
    $.ajax({  
        url:"storeresetpassword.php",
        type:"POST",
        data: datatopost,
        success: function(data){
           $("#resultmessage").html(data);  
                
            
        },
        error: function(){
            $("#resultmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    }); 

    
});   
        
        
        </script>
    </body>  

</html>

