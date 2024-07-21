<?php
require 'header.php';
?>

    <h4 class="text-center pt-3">Login</h4>

    <div id="loginformdiv">

        <form action="" id="loginform" method="POST" class="">
            <!-- The following input is just to send the value 'processlogin' to script.php so it will process Helperlog class  -->
            <input type="text" name="processlogin" style="display:none;">

            <label for="email">Email:</label> <br>
            <input class="inputfield" type="email" name="email"> <br><br>

            <label for="password">Password:</label> <br>
            <input class="inputfield" type="password" name="password"> <br><br>

            <input type="submit" value="Login"> <br>

            <div id="submissionstatus"></div> <br>

            Not Registered? <a href="index.php">Register now</a>

        </form>

    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
    <script src="ajaxoop.js"></script>

    <script>  
        $(document).ready(function() {
            new FormValidator('loginform', 'submissionstatus', 'process.php');
        });
    </script>

</body>
</html>