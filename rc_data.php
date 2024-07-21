<?php                   //here the all the candidates is called from query string and sent in json format
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}

$sql = "SELECT * FROM usertable WHERE role='candidate' ";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode(array('data' => $data));