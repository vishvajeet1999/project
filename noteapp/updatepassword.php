<?php
//start session and connect
session_start();
include('connection.php');

//define error messages
$missingCurrentPassword = '<p><strong>please enter the password</strong></p>';
$incorrectCurrentPassword = '<p><strong>put the correct password</strong></p>';
$missingPassword = '<p><strong>please enter the new password</strong></p>';
$invalidPassword = '<p><strong>your password should be of at least 6 characters long and include one apital letter adn one number!</strong></p>';
$differentPassword = '<p><strong>passwords dont match</strong></p>';
$missingPassword2 = '<p><strong>please confirm your password</strong></p>';

//check the errors
if (empty($_POST["currentpassword"])){
    $errors .= $missingCurrentPassword;
}else{
    
    $currentPassword = $_POST["currentpassword"];
    $currentPassword = filter_var($currentPassword,FILTER_SANITIZE_STRING); 
    $currentPassword = mysqli_real_escape_string($link,$currentPassword);
    $currentPassword = hash('sha256',$currentPassword);
    //check if the given password is correct
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT password  FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class = "alert alert-danger"> there was a problem running the query</div>';
    }else{
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($currentPassword != $row['password']){
            $errors .= $incorrectCurrentPassword;
        }
        
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
//if there is an error print error message
if($errors){
    $resultMessage = "<div class = 'alert alerlt-danger'>$errors</div>";
    echo $resultMessage;
}
else{
    $password = mysqli_real_escape_string($link,$password);
    $password = hash('sha256',$password);
    
    
    //else run query and update password
    $sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id'";
     $result = mysqli_query($link, $sql);
    if(!$result){
        echo"<div class= 'alert alert-danger'> the password could not be reset. please try again later.</div>";
    }
    else{
        echo "<div class= 'alert alert-success'> your password has been updated successfully.</div>";
    }
}





?>