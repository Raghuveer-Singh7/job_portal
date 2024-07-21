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
            <div></div>
            <h3>Welcome Admin : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 d-flex justify-content-evenly border">
           <a href="rr.php"><button id="adminbutton">Registered Recruiters</button></a>
           <a href="rc.php"><button id="adminbutton">Registered Candidates</button></a>
        </div>
    </div>
</div>
