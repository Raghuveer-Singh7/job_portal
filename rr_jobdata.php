<?php                   //here the jobs cretaed by the recruiter is called from query string and sent in json format
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}

$id = $_GET['id'];   //we have retrieved jobstable id here .

$sql = "SELECT * FROM jobstable WHERE register_id=$id";  
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode(array('data' => $data));