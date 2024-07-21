<?php                   //here the applied jobs are handled
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}

$id = $_GET['id'];   //we have retrieved usertable id here .

$sql="SELECT 
      candidate.username AS candidate_name,
      candidate.email AS candidate_email,
      company.username AS company_name,
      company.email AS company_email,
      job.position AS applying_for,
      job.location AS for_location,
      applicant.resume,
      applicant.id AS applicant_id       
    -- the above applicant.id selects the id from applicantstable for deleting 
FROM usertable AS candidate
JOIN applicantstable AS applicant
    ON applicant.user_id = candidate.id
JOIN jobstable AS job
    ON job.id = applicant.job_id
JOIN usertable AS company
    ON company.id = job.register_id
WHERE candidate.id = $id";   //only showing for the selected element

$result = mysqli_query($conn, $sql) ;

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(array('data' => $data));

