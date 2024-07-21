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
    // checking if the session retrieves id .

    $sql = "SELECT * FROM usertable WHERE id=$userid " ;
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc() ;
?>

<section id="headerbar" class="p-2 pb-0">
    <div class="container-fluid headerbarforpages">
        <div class="d-flex justify-content-between ">
            <a href="recruiter.php"><button id="topbutton">BACK</button> </a>
            <h3 id="headinginside">Welcome Recruiter : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<h4 class="text-center">JOB EDIT</h4>

<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-5">
                <div>
                    <h5 class="text-decoration-underline">Selected job profile:</h5>
                    <?php
                    $id = $_GET['id'];   //we have retrieved jobstable id here .
                    $sql = "SELECT * FROM jobstable WHERE id=$id";
                    $result = $conn->query($sql);
                    $user = $result->fetch_assoc();
                    $isActive = $user['is_active'];
                    ?>
                    <b class="spacing"> Position     </b>  <?php echo ": ". $user['position']."<br>";  ?>
                    <b class="spacing"> Qualification</b>  <?php echo ": ". $user['qualification']."<br>"; ?>
                    <b class="spacing"> Experience   </b>  <?php echo ": ". $user['experience']."<br>"; ?>
                    <b class="spacing"> Location     </b>  <?php echo ": ". $user['location']."<br>"; ?>
                    <b class="spacing"> Last date    </b>  <?php echo ": ". $user['lastdatetoapply']."<br>"; ?>
                    <b class="spacing"> Status       </b>  <?php echo ": ". ($user['is_active'] == 1 ? "Active" : "Not Active") . "<br>"; ?>
                </div>
            </div>
            <div class="col-md-7">
                <div class="mb-5" id="">

                    <h5 class="mb-3 text-decoration-underline">
                        Update existing job
                    </h5>
                    
                    <form action="" id="editjobform" method="POST" class="recruitereditformstyling">
                        <!-- The following input is just to send the value 'processcreatejob' to script.php so it will process Helperlog class  -->
                        <input type="text" name="processeditjob" style="display:none;">
                        <!-- sending register id along with this form so that in database for jobstable we can get the register_id to know that which job is created by which user recruiter  -->
                        <input type="text" name="register_id" value="<?php echo $userid; ?>" style="display:none;">
                    
                        <label for="position">Position:</label> <br>
                        <input class="inputfield" type="text" name="position" value="<?php echo $user['position']; ?>"> <br> <br>
                    
                        <label for="qualification">Qualification:</label> <br>
                        <input class="inputfield" type="text" name="qualification" value="<?php echo $user['qualification']; ?>"> <br><br>
                    
                        <label for="experience">Experience:</label> <br>
                        <!-- <input class="inputfield" type="text" name="experience"> <br><br> -->
                        <input class="inputfield" type="text" name="experience" value="<?php echo $user['experience']; ?>"> <br><br>
                    
                    
                        <label for="location">Location:</label> <br>
                        <input class="inputfield" type="text" name="location" value="<?php echo $user['location']; ?>"> <br><br>
                    
                        <label for="lastdatetoapply">Last Date to apply:</label> <br>
                        <input class="inputfield" type="date" name="lastdatetoapply" value="<?php echo $user['lastdatetoapply']; ?>"> <br><br>
                    
                        <label for="is_active">Status:</label> <br>
                        <select name="is_active">
                            <option value="1" <?php echo $isActive == 1 ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?php echo $isActive == 0 ? 'selected' : ''; ?>>Not Active</option> 
                        </select> <br><br>
                    
                        <input type="submit" value="Update Job"> <br>
                    
                        <div id="submissionstatus"></div> <br>
                            
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</section>


<!-- script below  -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
<script src="ajaxoop.js"></script>
<script>  
    $(document).ready(function() {
        new FormValidator('editjobform', 'submissionstatus', 'editjobscript.php?id=<?php echo $id; ?>');  //The js file contains only classes , to make use of those classes here object is defined with the formid , scripturl and submissionstatus
        // Initialize another form validator if needed:
        // new FormValidator('anotherFormId', 'anotherStatusId', 'anotherScript.php');
    });
</script>