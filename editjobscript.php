<?php
require 'connection.php';

if (isset($_POST['processeditjob'])) {

  $position         = $_POST['position'];
  $qualification    = $_POST['qualification'];
  $experience       = $_POST['experience'];
  $location         = $_POST['location'];
  $lastdatetoapply  = $_POST['lastdatetoapply'];
  $is_active        = $_POST['is_active'];
   
  $errors = [];
  $formresult = [];

  if (empty($position)) {
    $errors['position']         = "Please enter position";
  }
  if (empty($qualification)) {
      $errors['qualification'] = "Please enter qualification";
  }
  if (empty($experience)) {
    $errors['experience']      = "Please enter experience";
  }
  if (empty($location)) {
    $errors['location']        = "Please enter location";
  }
  if (empty($lastdatetoapply)) {
    $errors['lastdatetoapply'] = "Please enter last date to apply";
  }

  if (count($errors) > 0) {            
    $formresult = [
        'status' => false,
        'data' => $errors
    ];


   } else {

    
    $id = $_GET['id'];   //we have retrieved jobstable id here .
    
    $sql = "UPDATE `jobstable` SET position = '$position' , qualification = '$qualification' , 
    experience = '$experience' , location = '$location' , lastdatetoapply = '$lastdatetoapply' , 
    is_active = '$is_active' WHERE id=$id ";
    $result = $conn->query($sql);
   
   
       $successmsg = "submitting changes please wait";
       $formresult = [
           'status' => 'jobupdated',
           'data' => $successmsg
       ];
   
   }

   echo json_encode($formresult);

}
