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


<?php
$id = $_GET['id'];   //we have retrieved jobstable id here .
$sql = "SELECT * FROM jobstable WHERE id=$id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<section id="headerbar" class="p-2 pb-0 yui">
    <div class="container-fluid">
        <div class="d-flex justify-content-between ">  
            <a href="rr_job.php?id=<?php echo $user['register_id']; ?>"><button id="topbutton">BACK</button> </a>
            <h3>Welcome Admin : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>



<div class="container mb-5">
        <div>
            <h4>
                Selected Job : <?php echo $user['position']; ?> <br>
                <!-- Status : -->
            </h4>
        </div>
        <div>
            <h5>applicants for the job profile :</h5>
        </div>
        <div>
      
        <table border="1" id="applicantstable" class="display">    <!-- This is a table to dynamically show the jobs posted by this particular recruiter  -->
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Candidate Name</th>
                    <th>Candidate Email</th>
                    <th>Qualification</th>
                    <th>Experience</th>
                    <th>Resume</th>
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
    $('#applicantstable').DataTable({
        "ajax": {
            "url": "rr_applicantsdata.php?id=<?php echo $id; ?>", // This URL manages the data which is to be inserted in the datatable
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
            { "data": "candidate_name" },
            { "data": "email" },
            { "data": "cnqualification" },
            { "data": "cnexperience" },
            {"data": null, // Combine resume and delete buttons into one column
                "render": function(data, type, row, meta) {
                    return '<a href="./resumepdf/' + row.resume + '" target="_blank"><button>Resume</button></a>' +
                    ' <button onclick="deleteRecord(' + row.applicant_id + ')">Delete</button>';
                }
            }
        ]
    });

    // Optional: Set interval to refresh table data every 30 seconds
    // setInterval(function() {
    //     $('#applicantstable').DataTable().ajax.reload(null, false); // User paging is not reset on reload
    // }, 3000);
});

function deleteRecord(id) {
    console.log(id);
    if (confirm('Are you sure you want to delete this job application?')) {
        $.ajax({
            url: 'delete_applicant.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                if (response === 'success') {
                    alert('Record deleted successfully');
                    $('#applicantstable').DataTable().ajax.reload(); // Reload the table data
                } else {
                    alert('Failed to delete the record: ' + response);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }
}

</script>