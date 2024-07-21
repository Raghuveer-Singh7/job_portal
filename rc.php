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

    $sql = "SELECT * FROM usertable WHERE id=$userid " ;
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc() ;
?>

<section id="headerbar" class="p-2 pb-0 yui">
    <div class="container-fluid">
        <div class="d-flex justify-content-between ">  
            <a href="adminpage.php"><button id="topbutton">BACK</button> </a>
            <h3>Welcome Admin : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<div class="container mb-5">
    <div>
        <h5 class="mt-5 text-center">
            Following are the Candidates registered with the portal
        </h5>
      
        <table border="1" id="rc" class="display">    <!-- This is a table to dynamically show the jobs posted by this particular recruiter  -->
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Candidate name</th>
                    <th>Candidate email</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Data insertion via AJAX  -->
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<script> //The above table is handeled by this script

$(document).ready(function() {
    var table = $('#rc').DataTable({
        "ajax": {
            "url": "rc_data.php",
        },
        "columns": [
            { 
                "data": null,
                "render": function(data, type, row, meta) {
                    // 'meta.row' gives the row number starting from 0
                    // Adding 1 to make it start from 1
                    return meta.row + 1;
                }
            },
            { "data": "username" },
            { "data": "email" },
            { "data": "password" },
            {
              "data": "id",   //this id is primary key of usertable
              "render": function(data, type, row, meta) {
                  return '<a href="rc_applicant.php?id=' + data + '"><button>&nbsp; VIEW &nbsp;</button></a>'; }
            //   "defaultContent": "<button class='view-btn'>View Job</button>"
            }
        ]
    });

    setInterval(function() {
        $('#rc').DataTable().ajax.reload(null, false);
    }, 3000);
});

</script>



</body>
</html>