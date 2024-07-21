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
    <div class="container-fluid headerbarforpages">
        <div class="d-flex justify-content-between ">
            <div></div>
            <h3>Welcome Candidate : <?php  echo $row['username'];?>  </h3>
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a>
        </div>
    </div>
</section>
<hr>

<div class="text-center">
    <a href="myappliedjobs.php"><button class="bg-dark text-white p-2">MY APPLIED JOBS</button></a>
</div>
    
<div class="container mt-5">

    <h5>Following are the available jobs for you</h5>

    <table border="1" id="CanTable" class="display">    <!-- This is a table to dynamically show the available jobs to candidate  -->
        <thead>
            <tr>
                <th>S.no</th>
                <th>Company name</th>
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



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<script> //The above table is handeled by this script

    $(document).ready(function() {
    $('#CanTable').DataTable({
        "ajax": {
            "url": "datacandidate.php", // This URL manages the data which is to be inserted in the datatable
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
            { "data": "position" },
            { "data": "qualification" },
            { "data": "location" },
            { "data": "lastdatetoapply" },
            {
               "data": "id",
              "render": function(data, type, row, meta) {
                  return '<a href="viewjobcandidate.php?id=' + data + '"><button>View Job</button></a>'; }
            //   "defaultContent": "<button class='view-btn'>View Job</button>"
            }
        ]
    });

    // Optional: Set interval to refresh table data every 30 seconds
    setInterval(function() {
        $('#CanTable').DataTable().ajax.reload(null, false); // User paging is not reset on reload
    }, 3000);
});

</script>
