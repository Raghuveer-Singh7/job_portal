<?php
require 'header.php';
require 'connection.php';
?>

<a href="about.php">Project Description</a>
    <h4 class="text-center">Register</h4>
    
    <div id="registerformdiv">
    
        <form action="" id="registerform" method="POST" class="">
    
            <label for="role">Specify Role:</label> <br>
            <select name="role" class="inputfield">
                <option value="">Select role</option>
                <option value="candidate">Candidate</option>
                <option value="recruiter">Recruiter</option>
            </select> <br><br>
    
            <label for="username">Name:</label> <br>
            <input class="inputfield" type="text" name="username" placeholder="Recruiter must use company name"> <br> <br>
    
            <label for="email">Email:</label> <br>
            <input class="inputfield" type="email" name="email"> <br><br>
    
            <label for="password">Password:</label> <br>
            <input class="inputfield" type="password" name="password"> <br><br>
    
            <label for="confirmpassword">Confirm Password:</label> <br>
            <input class="inputfield" type="password" name="confirmpassword"> <br><br>
    
            <input type="submit" value="Register"> <br>
    
            <div id="submissionstatus"></div> <br>
            
            <div>Already Registered? <a href="login.php">Log in</a> </div>
    
        </form>
    
    </div>

    <!-- jquery CDN  -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
    <!-- Own javascript code (AJAX)  -->
    <script src="ajaxoop.js"></script>

    <script>  
        $(document).ready(function() {
            new FormValidator('registerform', 'submissionstatus', 'process.php');  //The js file contains only classes , to make use of those classes here object is defined with the formid , scripturl and submissionstatus
            // Initialize another form validator if needed:
            // new FormValidator('anotherFormId', 'anotherStatusId', 'anotherScript.php');
        });
    </script>

</body>
</html>