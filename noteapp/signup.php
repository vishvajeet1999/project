<?php


//start session
session_start();

//logout
include("logout.php");

//Connecct to the database
include('connection.php');

//check user input
//   define error message

$missingUsername='<p>please enter a username</p>';
$missingEmail='<p>please enter an email</p>'; 
$invalidEmail='<p>invalid email</p>';
$missingPassword='<p>please enter a password</p>';
$invalidPassword='<p>your password  should be at leasllt 6 characteers long and include one capital letter and one number in it!</p>';
$differentPassword='<p>password dont match</p>';
$missingPassword2='<p>please confirm your password </p>'; 
 
//get username email and password and password2
//get username

if(empty($_POST["username"])){ 
    $errors.=$missingUsername;
}else{
    $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
} 

//get email
if(empty($_POST["email"])){ 
    $errors.=$missingEmail; 
}else{
    $email=filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors.=$invalidEmail;
    }
}
    
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

//no errors

//prepare varialbles for the queries
$username=mysqli_real_escape_string($link,$username);

$email=mysqli_real_escape_string($link,$email);

$password=mysqli_real_escape_string($link,$password);
//$password=md5($password);
$password=hash('sha256', $password); 
//256 bits 


//if username exists in the user table print error
 
$sql="SELECT * FROM users WHERE username='$username'";
$result=mysqli_query($link,$sql);

if(!$result){
    echo '<div class="alert alaert-danger" >error running the query</div>';
    exit; 
}
$results= mysqli_num_rows($result);  
if($results){
    echo '<div class="alert alaert-danger" >That username already exists. Do you want to login?</div>';exit;
}

//if email exists in the user table print error
    
$sql="SELECT * FROM users WHERE email='$email'"; 
$result=mysqli_query($link,$sql); 

if(!$result){
    echo '<div class="alert alaert-danger" >error running the query</div>';  
    exit; 
}
$results= mysqli_num_rows($result); 
if($results){
    echo '<div class="alert alaert-danger" >That email already exists. Do you want to login?</div>';exit;
}     


    
    
    
    //create a unique activation code
$activationKey=bin2hex(openssl_random_pseudo_bytes(16));
    //byte: unit of data
    //bit: 0 or 1
    //16 byte=16*8=128 bits
    //(2*2*2*2)*2*2*2*2*
    //32 characters
    
//Insert user details and activation code in the users table   
    
$sql= "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";

$result = mysqli_query($link, $sql);
    if(!$result){
        echo'<div class="alert alert-danger">there was an error in inserting the user details in database</div>';
        exit; 
    }   
    
//send user an email with a link to activate.php with their email and activation

$message = "<p>Please click on this link to activate your account:\n\n</p>"; 

$message .="http://firstwebapplication.host20.uk/notesapp3/activate.php?email=".urlencode($email)."&key=$activationKey";
$from="vishvajeet141@gmail.com";
$header="From: the sender <vishvajeet141@gmail.com>\r\n";
$header.="Content-type:text/html\r\n";   

 if(mail($email, 'Confirm your  Reistration',$message,$header)){
      echo"<div class='alert alert-success'>Thank you for registering. a confirmation link has been sent to your email: $email. click on the link to activate your account.</div>"; 
 }  
     
?>