<?php
session_start();
include('connection.php');

//get the id of the note through the ajax
$note_id = $_POST['id'];
//run a query to delete the node
$sql = "DELETE FROM notes WHERE id = $note_id";
$result = mysqli_query($link, $sql);
if(!$result){
        echo'error';
        exit;
    } 

?>