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
            <a href="candidate.php"><button id="topbutton">BACK</button> </a>
            <h3>Welcome Candidate : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<div class="container mt-5">

    <h5>Following are the jobs applied by you</h5>

    <table border="1" id="appliedjobstable" class="display">    <!-- This is a table to dynamically show the applied jobs by candidate  -->
        <thead>
            <tr>
                <th>S.no</th>
                <th>Company name</th>
                <th>Company email</th>
                <th>Position</th>
                <th>Location</th>
                <th>Action</th>
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
    $('#appliedjobstable').DataTable({
        "ajax": {
            "url": "dataappliedjobs.php", // This URL manages the data which is to be inserted in the datatable
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
            { "data": "company_name" },
            { "data": "company_email" },
            { "data": "required_position" },
            { "data": "on_location" },
            {
               "data": "id",
              "render": function(data, type, row, meta) {
                  return '<a href="myappliedjobdetails.php?id=' + data + '"><button> &nbsp; VIEW &nbsp; </button></a>'; }
            }
        ]
    });

});

</script>
