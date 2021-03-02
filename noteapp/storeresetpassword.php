<!--this file receives: user_id, generated key to reset password, password1 and password2-->

<!--this file then repeats password for user_id if all checks are correct-->

<?php
session_start();
include('connection.php');

//if(!isset($_GET['user_id']) || !isset($_GET['key'])){
//    echo'<div class="alert alert-danger">there was an error. please click on the activation link you received by email.</div>';exit;
//} 
//else
//       store them in two variables 
$user_id=$_POST['user_id'];
$key=$_POST['key'];
$time = time()-86400; 

//  prepare variables for query
  $user_id=mysqli_real_escape_string($link, $user_id);
  $key=mysqli_real_escape_string($link, $key); 

//run query: check combination of user_id and key exists and less than 24h old
$sql= "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND time>'$time' AND status='pending'";
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

//   define error message
$missingPassword='<p>please enter a password</p>';
$invalidPassword='<p>your password  should be at leasllt 6 characteers long and include one capital letter and one number in it!</p>';
$differentPassword='<p>password dont match</p>';
$missingPassword2='<p>please confirm your password </p>';

//get password

if(empty($_POST["password"])){
    $errors.=$missingPassword;
}
elseif(strlen($_POST["password"])<6 && !preg_match('/[A-Z]/',$_POST["password"]) && !preg_match('/[0-9]/', $_POST["password"])){
    $errors.=$invalidPassword;
}


else{
    $password=filter_var($_POST["password"],FILTER_SANITIZE_STRING);
    
        if(empty($_POST["password2"])){
             $errors.=$missingPassword2;
        }else{
    $password2=filter_var($_POST["password2"],FILTER_SANITIZE_STRING);
            
             if($password !== $password2){
               $errors.=$differentPassword;
                 
             }
             
        }  
}

//if there are any errors print the errors
if($errors){
    $resultMessage='<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
    exit; 
}
//Prepare variaables for the query
$password=mysqli_real_escape_string($link,$password);
//$password=md5($password);
$password=hash('sha256',$password); 
$user_id=mysqli_real_escape_string($link,$user_id);

//run query: update users password in the users table

$sql="UPDATE users SET password='$password' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
 if(!$result){
        echo'<div class="alert alert-danger">there was a problem storing the new password in the database</div>';
        exit;
    } 
//set the key status to "used" in the forgotpassword table prevent the key from being used twice
$sql="UPDATE forgotpassword SET status='used' WHERE rkey='$key'AND user_id='$user_id'";
$result = mysqli_query($link, $sql);

if(!$result){
        echo'<div class="alert alert-danger">Error running the query</div>';
        
    }    
else{
    echo'<div class="alert alert-success">your password has been updated successfully!<a href="index.php">Login</a></div>';
}



?>