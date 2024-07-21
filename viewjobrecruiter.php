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

<section id="headerbar" class="p-2 pb-0 yui">
    <div class="container-fluid headerbarforpages">
        <div class="d-flex justify-content-between ">
            <a href="recruiter.php"><button id="topbutton">BACK</button> </a>
            <h3 id="headinginside">Welcome Recruiter : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

<?php
    $id = $_GET['id'];   //we have retrieved jobstable id here .
    $sql = "SELECT * FROM jobstable WHERE id=$id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
?>

<div class="container">
    <h5 class="mt-5 text-decoration-underline">Selected job profile:</h5>
    <b class="spacing"> Position     </b>  <?php echo ": " . $user['position']                                    ."<br>"; ?>
    <b class="spacing"> Qualification</b>  <?php echo ": " . $user['qualification']                               ."<br>"; ?>
    <b class="spacing"> Experience   </b>  <?php echo ": " . $user['experience']                                  ."<br>"; ?>
    <b class="spacing"> Location     </b>  <?php echo ": " . $user['location']                                    ."<br>"; ?>
    <b class="spacing"> Last date    </b>  <?php echo ": " . $user['lastdatetoapply']                             ."<br>"; ?>
    <b class="spacing"> Status       </b>  <?php echo ": " . ($user['is_active'] == 1 ? "Active" : "Not Active")  ."<br>"; ?>
</div>

<div class="container mb-5">
    <div>
        <h5 class="mt-5 text-decoration-underline">
            <b>Received applications so far :</b>
        </h5>
      
        <table border="1" id="applicantstable" class="display">    <!-- This is a table to dynamically show the jobs posted by this particular recruiter  -->
            <thead>
                <tr>
                    <th>S.no           </th>
                    <th>Candidate Name </th>
                    <th>Candidate Email</th>
                    <th>Qualification  </th>
                    <th>Experience     </th>
                    <th>Resume         </th>
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

<!-- Scripts below -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#applicantstable').DataTable({
            "ajax": {
                "url": "dataapplicants.php?id=<?php echo $id; ?>" // This URL manages the data which is to be inserted in the datatable
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
                {
                    "data": "resume", // Retrieves the name of the PDF files as in resume column we have inserted the $filename
                    "render": function(data, type, row, meta) {
                        return '<a href="viewresume.php?id=' + row.id + '" target="_blank"><button> &nbsp; View &nbsp;</button></a>';
                    }
                }
            ] 
        });

        // Apply scrollX and scrollY only on mobile
        // if ($(window).width() <= 600) {
        //     console.log("Window width:", $(window).width());
        //     table.scrollX = true;
        //     table.scrollY = "400px";
        // }
        
        // Initialize DataTable
        // $('#applicantstable').DataTable(table);


        
        // Set interval to refresh table data every 30 seconds
        // setInterval(function() {
        //     $('#applicantstable').DataTable().ajax.reload(null, false); // User paging is not reset on reload
        // }, 3000);
    });
</script>

</body>
</html>

