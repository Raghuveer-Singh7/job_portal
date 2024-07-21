<?php
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}

// Check if ID is received via POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];  //applicantstable's id

    // Perform the delete operation
    $sql = "DELETE FROM applicantstable WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($conn);
    }
} else {
    echo 'error: ID parameter not set';
}
?>
