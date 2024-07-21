<?php
    session_start(); 
    require 'connection.php';
    require 'header.php';
    
    if (isset($_SESSION['user_id'])) {
        $userid = $_SESSION['user_id'];
    }
    else{
        header("Location: login.php");
        exit();
    }

    // echo $userid; 
    // checking if the session retieves id .


    $sql = "SELECT * FROM usertable WHERE id=$userid " ;
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc() ;
?>

<section id="headerbar" class="p-2 pb-0 yui">
    <div class="container-fluid">
        <div class="d-flex justify-content-between ">
            <a href="myappliedjobs.php"><button id="topbutton">BACK</button> </a>
            <h3>Welcome Candidate : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<?php

    $id = $_GET['id'];   //we have retrieved jobstable id here .
    
    $sql="SELECT
          company.username AS company_name, 
          company.email AS company_email, 
          job.position AS required_position, 
          job.location AS on_location,
          job.experience,
          job.lastdatetoapply,
          candidate.username AS candidate_applied,
          applicant.appliedon,
          applicant.resume,
          applicant.viewedon
    FROM usertable AS company 
    JOIN jobstable AS job 
         ON job.register_id = company.id 
    JOIN applicantstable AS applicant
         ON applicant.job_id = job.id
    JOIN usertable AS candidate
         ON candidate.id = applicant.user_id
    WHERE candidate.id = $userid AND job.id = $id ";   //only showing for the selected element , jobstable 's id is required
    
    
    $result = mysqli_query($conn, $sql) ;
    $user = $result->fetch_assoc();
?>

<div class="container">
    <b class="spacing"> Company      </b>  <?php echo ": ". $user['company_name']."<br>";      ?>
    <b class="spacing"> Email        </b>  <?php echo ": ". $user['company_email']."<br>";     ?>
    <b class="spacing"> Position     </b>  <?php echo ": ". $user['required_position']."<br>"; ?>
    <b class="spacing"> Experience   </b>  <?php echo ": ". $user['experience']."<br>";        ?>
    <b class="spacing"> Location     </b>  <?php echo ": ". $user['on_location']."<br>";       ?>
    <b class="spacing"> Last date    </b>  <?php echo ": ". $user['lastdatetoapply']."<br>";   ?>
    
    <br><br>
    
    <b class="spacing"> Resume       </b> : <a href="./resumepdf/<?php echo $user['resume']; ?>" target="_blank">Your resume</a>
    <br>
    <b class="spacing"> Status       </b>  <?php echo ": Applied - ". $user['appliedon']." , Viewed - ".$user['viewedon']. "<br>"; ?>
</div>


