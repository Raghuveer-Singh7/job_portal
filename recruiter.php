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
            <div id="emptydiv"></div>
            <h3>Welcome Recruiter : <?php echo $row['username']; ?> </h3>   
            <a href="logout.php"><button id="topbutton">LOG OUT</button> </a> 
        </div>
    </div>
</section>
<hr>

    <div class="container mb-5">
        <div>
            <h5 class="mt-5 text-center">
                Following are the jobs listed by you
            </h5>
          
            <table border="1" id="myTable" class="display nowrap " style="width:100%">    <!-- This is a table to dynamically show the jobs posted by this particular recruiter  -->
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

    <div class="conatiner mt-5 mb-5" id="recruiterformdiv">

        <h5 class="mb-3 text-center">
            Create a new job
        </h5>
        
        <form action="" id="recruiterform" method="POST" class="recruiterformstyling">
            <!-- The following input is just to send the value 'processcreatejob' to script.php so it will process Helperlog class  -->
            <input type="text" name="processcreatejob" style="display:none;">
            <!-- sending register id along with this form so that in database for jobstable we can get the register_id to know that which job is created by which user recruiter  -->
            <input type="text" name="register_id" value="<?php echo $userid; ?>" style="display:none;">
    
            <label for="position">Position:</label> <br>
            <input class="inputfield" type="text" name="position"> <br> <br>
    
            <label for="qualification">Qualification:</label> <br>
            <input class="inputfield" type="text" name="qualification"> <br><br>
    
            <label for="experience">Experience:</label> <br>
            <input class="inputfield" type="text" name="experience"> <br><br>
    
            <label for="location">Location:</label> <br>
            <input class="inputfield" type="text" name="location"> <br><br>
    
            <label for="lastdatetoapply">Last Date to apply:</label> <br>
            <input class="inputfield" type="date" name="lastdatetoapply"> <br><br>
    
            <input type="submit" value="Create Job"> <br>
    
            <div id="submissionstatus"></div> <br>
                
        </form>
    
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="ajaxoop.js"></script>

    <script>  
        $(document).ready(function() {
            new FormValidator('recruiterform', 'submissionstatus', 'process.php');  //The js file contains only classes , to make use of those classes here object is defined with the formid , scripturl and submissionstatus
            // Initialize another form validator if needed:
            // new FormValidator('anotherFormId', 'anotherStatusId', 'anotherScript.php');
        });
    </script>

<script> //The above table is handeled by this script

$(document).ready(function() {
    var table = $('#myTable').DataTable({
        "ajax": {
            "url": "data.php",
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
                  return '<a href="viewjobrecruiter.php?id=' + data + '"><button>Applicants</button></a>                     <a href="editjob.php?id=' + data + '"><button>Edit</button></a>'; }
            //   "defaultContent": "<button class='view-btn'>View Job</button>"
            }
        ],
        "scrollX": true,  // Enable horizontal scroll if needed
        "scrollY": "400px",  // Set the height for vertical scroll
        "scrollCollapse": true,  // Collapse table when it's smaller than the viewport
        "paging": false  // Disable paging since we are using scrolling
    });

    // $('#myTable').on('click', '.view-btn', function() {
    //     var data = table.row($(this).closest('tr')).data();
    //     var jsonData = JSON.stringify(data);
    //     $.ajax({
    //         url: 'store_job_data.php',
    //         method: 'POST',
    //         contentType: 'application/json',
    //         data: jsonData,
    //         success: function(response) {
    //             $('body').html(response); // Display response in the body (or a specific div)
    //             window.location.href = 'view_job.php'; // Uncomment if you need to redirect after processing
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(xhr.responseText);
    //         }
    //     });
    // });

    setInterval(function() {
        $('#myTable').DataTable().ajax.reload(null, false);
    }, 3000);
});

</script>


</body>
</html>