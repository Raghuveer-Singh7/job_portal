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
    $user = $result->fetch_assoc();
?>

<section id="headerbar" class="p-2 pb-0 yui">
    <div class="container-fluid">
        <div class="d-flex justify-content-between ">  
            <a href="rc.php"><button id="topbutton">BACK</button> </a>
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

<div class="container mt-5">
        <div>
            <h4>
                Selected Candidate : <?php echo $user['username']; ?> <br>
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

    <h5>Jobs applied :</h5>

    <table border="1" id="rc_applicant" class="display">    <!-- This is a table to dynamically show the applied jobs by candidate  -->
        <thead>
            <tr>
                <th>S.no</th>
                <th>Company name</th>
                <th>Company email</th>
                <th>Position</th>
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
    $('#rc_applicant').DataTable({
        "ajax": {
            "url": "rc_applicantdata.php?id=<?php echo $id; ?>", // This URL manages the data which is to be inserted in the datatable
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
            { "data": "applying_for" },
            {"data": null, // Combine resume and delete buttons into one column
                "render": function(data, type, row, meta) {
                    return '<a href="./resumepdf/' + row.resume + '" target="_blank"><button>Resume</button></a>' +
                    ' <button onclick="deleteRecord(' + row.applicant_id + ')">Delete</button>';
                }
            }
        ]
    });
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
                    $('#rc_applicant').DataTable().ajax.reload(); // Reload the table data
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
