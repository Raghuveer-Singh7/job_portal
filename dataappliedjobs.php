<?php                   //here the applied jobs are handled
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}


$sql="SELECT
      company.username AS company_name, 
      company.email AS company_email, 
      job.position AS required_position, 
      job.location AS on_location,
      job.id,
      candidate.username AS candidate_applied
FROM usertable AS company 
JOIN jobstable AS job 
     ON job.register_id = company.id 
JOIN applicantstable AS applicant
     ON applicant.job_id = job.id
JOIN usertable AS candidate
     ON candidate.id = applicant.user_id
WHERE candidate.id = $userid";   //only showing for the selected element


$result = mysqli_query($conn, $sql) ;

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(array('data' => $data));

