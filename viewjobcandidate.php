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
            <a href="candidate.php"><button id="topbutton">BACK</button> </a>
            <h3>Welcome Candidate : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<?php
    $id = $_GET['id']; //here we are receiving id of jobstable
    
    $sql="SELECT 
            user.username, 
            user.email,
            jobs.position, 
            jobs.qualification, 
            jobs.experience, 
            jobs.location, 
            jobs.lastdatetoapply
          FROM usertable AS user 
          JOIN jobstable AS jobs 
              ON jobs.register_id=user.id 
          WHERE jobs.id=$id;";
    
    $result = $conn->query($sql);
    $user = $result->fetch_assoc(); 
?>

<div class="container d-flex justify-content-around viewjobpagecandidate">
    <div class="border mt-3">
        <h5 class="">
            SELECTED JOB PROFILE
        </h5>
        <div class="container">
            <b class="spacing"> Company      </b>  <?php echo ": ". $user['username']       ."<br>"; ?>
            <b class="spacing"> Email        </b>  <?php echo ": ". $user['email']          ."<br>"; ?>
            <b class="spacing"> Position     </b>  <?php echo ": ". $user['position']       ."<br>"; ?>
            <b class="spacing"> Qualification</b>  <?php echo ": ". $user['qualification']  ."<br>"; ?>
            <b class="spacing"> Experience   </b>  <?php echo ": ". $user['experience']     ."<br>"; ?>
            <b class="spacing"> Location     </b>  <?php echo ": ". $user['location']       ."<br>"; ?>
            <b class="spacing"> Last date    </b>  <?php echo ": ". $user['lastdatetoapply']."<br>"; ?>
        </div>
    </div>
    <div class="border" id="jobapplyformdiv">
        <h5 class="">
            APPLY FOR SELECTED JOB PROFILE
        </h5>
        <form action="" id="jobapplyform" method="POST" enctype="multipart/form-data" class="jobapplyformstyling">
            <!-- The following input is just to send the value 'processapplyjob' to script.php so it will process Helperlog class  -->
            <input type="text" name="processapplyjob" style="display:none;">
            <!-- sending register id (user_id from usertable (primary unique id) )along with this form  -->
            <input type="text" name="register_id" value="<?php echo $userid; ?>" style="display:none;">
            <!-- sending job id (from jobstable (primary unique id) )along with this form  -->
            <input type="text" name="job_id" value="<?php echo $id; ?>" style="display:none;">
        
            <label for="username">Name:</label> <br>
            <input class="inputfield" type="text" name="position" value="<?php  echo $row['username'];?>" readonly> <br> <br>
        
            <label for="cnqualification">Qualification:</label> <br>
            <input class="inputfield" type="text" name="cnqualification"> <br><br>
        
            <label for="cnexperience">Experience:</label> <br>
            <input class="inputfield" type="text" name="cnexperience"> <br><br>
        
            <label for="resume">Upload Resume:</label> <br>
            <small style="color:blue">Only PDF under 5MB is acceptable</small> <br>
            <input class="inputfield" type="file" name="resume"> <br><br>
        
            <input type="submit" value="Apply"> <br>
        
            <div id="submissionstatus"></div>
            <input class="inputfield" type="text" name="alreadyappliederror" style="display:none;"> <br> <!-- error alreadyappliederror -->
        </form>
    </div>
</div>

<!-- script below   -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
<script src="ajaxoop.js"></script>

<script>  
    $(document).ready(function() {
        new FormValidator('jobapplyform', 'submissionstatus', 'process.php');
    });
</script>

</body>
</html>