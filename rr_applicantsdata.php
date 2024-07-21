<?php                   //here the applicants are handled
session_start(); 
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
}

$id = $_GET['id'];   //we have retrieved jobstable id here .

$sql="SELECT 
    candidate.username AS candidate_name,
    email.email,
    applicant.cnqualification, 
    applicant.cnexperience, 
    job.position,
    applicant.resume,
    applicant.id AS applicant_id       
    -- the above applicant.id selects the id from applicantstable for deleting 
FROM usertable AS candidate
JOIN usertable AS email
     ON email.id = candidate.id
JOIN applicantstable AS applicant 
     ON applicant.user_id = candidate.id
JOIN jobstable AS job
     ON job.id = applicant.job_id
WHERE job.id = $id ";   //only showing for the selected element


$result = mysqli_query($conn, $sql) ;

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(array('data' => $data));



// SELECT user.username, user.email, jobs.position, jobs.qualification FROM usertable AS user JOIN jobstable AS jobs ON jobs.register_id=user.id WHERE user.is_active='1';