<?php
require 'connection.php';



if (isset($_POST['is_active'])) {

    $is_active = $_POST['is_active'];
    
    $id = $_GET['id'];   //we have retrieved usertable id here .
    $sql = "UPDATE `usertable` SET is_active = '$is_active' WHERE id=$id ";
    $result = $conn->query($sql);
    
    $successmsg = "Status updated.";
    $formresult = [
        'status' => 'adminupdateprocess',
        'data' => $successmsg
    ];


echo json_encode($formresult);

}