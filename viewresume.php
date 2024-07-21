<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = $_GET['id']; // we have retrieved id of applicants table whose viewedon we wish to update 
    
    // Retrieve the applicant's resume details from the database
    $sql = "SELECT resume FROM applicantstable WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resume_path = './resumepdf/' . $row['resume'];

        // Check if file exists
        if (file_exists($resume_path)) {
            // Display the PDF
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $row['resume'] . '"');
            @readfile($resume_path);
        } else {
            echo "The file does not exist.";
        }
    } else {
        echo "No record found.";
    }
} else {
    echo "Invalid request.";
}


//updating the current date inside the viewedon coloumn of applicants table on viewing of resume
$sql = "UPDATE applicantstable SET viewedon = CURDATE() WHERE id = $id";  
$result = $conn->query($sql);