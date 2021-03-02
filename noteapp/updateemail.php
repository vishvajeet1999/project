<?php 
//start session and connect
session_start();
include('connection.php');
//get user_id and new email sent through ajax
$user_id = $_SESSION['user_id'];
$$newemail = $_POST['email'];

// check if new email exists
$sql = "SELECT * FROM users WHERE email = '$newemail'";
      $result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if($count>0){
    echo "<div class = 'alert alert-danger'>there is already a user registered with that email, please choose anothe one!</div>";exit;
}  

// get the current email
$sql ="SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($link, $sql);
if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    $email = $row['email'];
}else{
    echo "<div class = 'alert alert-danger'>there was an error in retrieving the  email from the database</div>";exit;
}

// create a unique activation code
$activationKey=bin2hex(openssl_random_pseudo_bytes(16));

// insert new activation code in the users table
$sql = "UPDATE users SET activation2= '$activationKey' WHERE user_id ='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
     echo "<div class = 'alert alert-danger'>there was an error inserting the users details into the database.</div>";exit;
}else{
    //send email with link to activatenewemail.php with current email, new email and activation code
    $message = "<p>Please click on this link to to prove that you own this email:\n\n</p>"; 

$message .="http://firstwebapplication.host20.uk/notesapp3/activatenewemail.php?email=".urlencode($email). "&newemail=".urlencode($newemail)."&key=$activationKey";
$from="vishvajeet141@gmail.com"; 
$header="From: the sender <vishvajeet141@gmail.com>\r\n";
$header.="Content-type:text/html\r\n";   

 if(mail($newemail, 'Email update for your online notes app',$message,$header)){
      echo"<div class='alert alert-success'>Thank you for registering. a confirmation link has been sent to your email: $newemail. click on the link to prove that you oown this email address.</div>"; 
 } 
    
    
}




?>