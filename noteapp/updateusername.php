<?php

//start session and connect
session_start();
include('connection.php');


//get the user_id
$id = $_SESSION['user_id'];

// get username sent through ajax
$username = $_POST['username'];

//RUN QUERY and update username
$sql = "UPDATE users SET username='$username' WHERE user_id='$id'";

$result = mysqli_query($link, $sql);
if(!$result){
        echo'<div class = "alert alert-danger">there was an error updating storing the new username in the daatabase!</div>';
        
    } 




?>