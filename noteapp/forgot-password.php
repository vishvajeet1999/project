<?php
//start session
session_start();
//connect to the database
include('connection.php');

//check user inputs
    //define error messages
$missingEmail='<p>please enter an email</p>'; 
$invalidEmail='<p>invalid email</p>';
//get email
//store errors in errors variables
if(empty($_POST["forgotemail"])){ 
    $errors.=$missingEmail; 
}else{
    $email=filter_var($_POST["forgotemail"],FILTER_SANITIZE_EMAIL);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors.=$invalidEmail;
    }
}
//if there are any errors
    //print error message

if($errors){
    $resultMessage='<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
    exit; 
}
     //else :no errors
            //prepare variables for the query
    $email=mysqli_real_escape_string($link,$email);
         //run query to check if the email exists in the users table
$sql="SELECT * FROM users WHERE email='$email'";
$result=mysqli_query($link,$sql);

if(!$result){
    echo '<div class="alert alaert-danger" >error running the query</div>';   
    exit; 
}
//if the result doest not exist
              //print errors
$count= mysqli_num_rows($result); 
if(!$count){
    echo '<div class="alert alaert-danger" >email never registered with us </div>';exit;
}   
     //ELSE
        //get the user id
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$user_id = $row['user_id'];

       //create a unique activation code
$Key=bin2hex(openssl_random_pseudo_bytes(16));
     //insert user details and activation code in the forgotpassword table
$time = time();
$status = 'pending';
$sql = "INSERT INTO forgotpassword (user_id, rkey, time, status) VALUES ('$user_id', '$Key', '$time', '$status')";
$result=mysqli_query($link,$sql); 
if(!$result){
        echo'<div class="alert alert-danger">there was an error in inserting the user details in database</div>';
        exit;  
    }

//send user an email with a link to resetpassword.php with their user id and key

$message = "<p>Please click on this link to reset your password:\n\n</p>"; 

$message .="http://firstwebapplication.host20.uk/notesapp3/resetpassword.php?user_id=$user_id&key=$Key";
$from="vishvajeet141@gmail.com";
$header="From: the sender <vishvajeet141@gmail.com>\r\n";
$header.="Content-type:text/html\r\n";   


 if(mail($email, 'reset your password',$message,$header)){
     
     //if email sent successfully
         //print success message
      echo"<div class='alert alert-success'>an email has been sent to the $email address provided. please click on the link to reset the password.</div>";  
 } 

?>