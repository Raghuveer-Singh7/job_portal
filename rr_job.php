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
            <a href="rr.php"><button id="topbutton">BACK</button> </a>
            <h3>Welcome Admin : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<?php
$id = $_GET['id'];   //we have retrieved usertable id here .
$sql = "SELECT * FROM usertable WHERE id=$id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$isActive = $user['is_active'];

?>

<div class="container mb-3">
        <div>
            <h4>
                Selected Recruiter : <?php echo $user['username']; ?> <br>
            </h4>

            <form action="" id="adminupdateprocess" method="POST">
                <label for="is_active"><b>Status:</b></label> 
                    <select name="is_active">
                        <option value="1" <?php echo $isActive == 1 ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo $isActive == 0 ? 'selected' : ''; ?>>Not Active</option> 
                    </select> 
                <input type="submit" value="Update"> <br>
                <div id="submissionstatus"></div> <br>
            </form>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
            <script src="ajaxoop.js"></script>
            <script>  
                $(document).ready(function() {
                    new FormValidator('adminupdateprocess', 'submissionstatus', 'adminupdateprocess.php?id=<?php echo $id; ?>'); 
                });
            </script>

        </div>

        <div>
            <h5 class="mt-3">
                Jobs listed : 
            </h5>
          
            <table border="1" id="rr_job" class="display">    <!-- This is a table to dynamically show the jobs posted by this particular recruiter  -->
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Position</th>
                        <th>Qualification</th>
                        <th>Location</th>
                        <th>Last date to apply</th>
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
    var table = $('#rr_job').DataTable({
        "ajax": {
            "url": "rr_jobdata.php?id=<?php echo $id; ?>",
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
            { "data": "position" },
            { "data": "qualification" },
            { "data": "location" },
            { "data": "lastdatetoapply" },
            {
              "data": "id",   //this id is primary key of jobstable
              "render": function(data, type, row, meta) {
                  return '<a href="rr_applicants.php?id=' + data + '"><button>&nbsp; VIEW &nbsp;</button></a>'; }
            //   "defaultContent": "<button class='view-btn'>View Job</button>"
            }
        ]
    });

    setInterval(function() {
        $('#rr_job').DataTable().ajax.reload(null, false);
    }, 3000);
});

</script>



</body>
</html>