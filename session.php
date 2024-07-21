<!-- Just a notes page -->
<?php
    session_start(); //start session
    $_SESSION['user_id'] = $user_id;
    // unset(); //to unset the session variable or ant other variable unset($_SESSION['useremail..."])
    session_destroy(); //end the session
    ?>