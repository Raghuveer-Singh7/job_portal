<?php                   //here the jobs cretaed by the recruiter is called from query string and sent in json format
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}

$sql="SELECT 
      user.username, 
      jobs.position, 
      jobs.qualification, 
      jobs.location, 
      jobs.lastdatetoapply, 
      jobs.id
FROM usertable AS user 
JOIN jobstable AS jobs 
     ON jobs.register_id=user.id 
WHERE user.is_active='1' AND jobs.is_active='1' AND jobs.lastdatetoapply >= CURRENT_DATE;";  //older than today's date are not displayed

$result = mysqli_query($conn, $sql) ;

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(array('data' => $data));
