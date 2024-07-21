<?php
require 'connection.php';


// Helperreg class for processing registration form 
class Helperreg {
    private $database;
    private $errors = [];

    public function __construct($conn) {
        $this->database = $conn;
    }

    public function formvalidation() {

        $this->validateRegisterform();

        $formresult = [];

        if (count($this->errors) > 0) {            
            $formresult = [
                'status' => false,
                'data' => $this->errors
            ];

        } else {

           $this->saveformdata();

            $successmsg = "Registration successful";
            $formresult = [
                'status' => true,
                'data' => $successmsg
            ];
        }

        echo json_encode($formresult);
    }

    private function saveformdata() {

      $role            = ($_POST['role']);
      $username        = trim($_POST['username']);
      $email           = ($_POST['email']);
      $password        = ($_POST['password']);
      $confirmpassword = ($_POST['confirmpassword']);

      $sql="INSERT INTO `usertable` (`role`, `username`, `email`, `password`, `is_active`)
      VALUES ('$role', '$username', '$email', '$password', '1')";
      mysqli_query($this->database, $sql);
    }

    private function validateRegisterform() {

            $role            = ($_POST['role']);
            $username        = trim($_POST['username']);
            $email           = ($_POST['email']);
            $password        = ($_POST['password']);
            $confirmpassword = ($_POST['confirmpassword']);

            $sql = "SELECT * FROM usertable WHERE email='$email'";   //For checking duplicate email
            $result = mysqli_query($this->database, $sql);

            if (empty($role)) {
              $this->errors['role'] = "Please specify the role";
            }
            if (empty($username)) {
                $this->errors['username'] = "Please enter username";
            }
            if (empty($email)) {
              $this->errors['email'] = "Please enter email";
            }
            if (mysqli_num_rows($result) > 0) {                      //For checking duplicate email
              $this->errors['email'] = "Email already registered with us";
            }
            if (empty($password)) {
              $this->errors['password'] = "Please enter password";
            }
            if($password != $confirmpassword){
              $this->errors['confirmpassword'] = "Password mismatched";
            }

    }
}

// Helperlog class for processing login form 
class Helperlog {
  private $database;
  private $errors = [];

  public function __construct($conn) {
      $this->database = $conn;
  }

  public function formvalidation() {
      $this->validateLoginform();

      $formresult = [];

      if (count($this->errors) > 0) {            
          $formresult = [
              'status' => false,
              'data' => $this->errors
          ];
      } else {      //Redirecting to different pages based on login details

        $email = $_POST['email'];
        $sql = "SELECT email , role FROM usertable WHERE email='$email' AND role='recruiter' "; 
        $result = mysqli_query($this->database, $sql);

        $sqlAD = "SELECT email , role FROM usertable WHERE email='$email' AND role='admin' "; 
        $resultAD = mysqli_query($this->database, $sqlAD);  //ADMIN page redirecting query
 
        if(mysqli_num_rows($result)== 0){
          $successmsg = "Login successful";
          $formresult = [
              'redirect' => 'candidatepage',  //'redirect' condition logic declared in ajaxoop.js script file
              'status' => true,
              'data' => $successmsg
          ];
        }
        if(mysqli_num_rows($resultAD) != 0){
          $formresult = [
              'redirect' => 'adminpage',  //'redirect' condition logic declared in ajaxoop.js script file
          ];
        }
        if(mysqli_num_rows($result) != 0){
          $formresult = [
            'redirect' => 'recruiterpage',
          ];
        }
      }

      echo json_encode($formresult);
  } 

  private function validateLoginform() {
  
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM usertable WHERE email='$email'";  //For checking if email is registered
        $result = mysqli_query($this->database, $sql);
        $sql2 = "SELECT email,id FROM usertable WHERE email='$email' AND password='$password'";   //For checking if email and corresponsing password is matched
        $result2 = mysqli_query($this->database, $sql2);
        $row = $result2->fetch_assoc() ;  //so that we can fetch the id value 

        if (empty($email)) {
            $this->errors['email'] = "Please enter email";
        }
        elseif (mysqli_num_rows($result) == 0) {              //For checking if email is registered
          $this->errors['email'] = "Email is not registered";
        } 
        elseif (empty($password)) {
            $this->errors['password'] = "Please enter password";
        }
        elseif (mysqli_num_rows($result2) == 0) {                                                //For checking if email and corresponsing password is matched
            $this->errors['password'] = "Incorrect password";
        }
        else{
          session_start(); 
          $_SESSION['user_id'] = $row['id']; //from $sql2 we have called id valuve now assigning the same to session value
        // echo $row['id'] ;
        }
        
    // Add more validation rules for other fields as needed
  }

}

// HelperCreatejobform class for processing create job form 
class HelperCreatejobform {
  private $database;
  private $errors = [];

  public function __construct($conn) {
      $this->database = $conn;
  }

  public function formvalidation() {

      $this->validateCreatejobform();

      $formresult = [];

      if (count($this->errors) > 0) {            
          $formresult = [
              'status' => false,
              'data' => $this->errors
          ];

      } else {

         $this->saveformdata();

          $successmsg = "Job created successfully";
          $formresult = [
              'status' => true,
              'data' => $successmsg
          ];
      }

      echo json_encode($formresult);
  }

  private function saveformdata() {

    $register_id     = ($_POST['register_id']);
    $position        = ($_POST['position']);
    $qualification   = ($_POST['qualification']);
    $experience      = ($_POST['experience']);
    $location        = ($_POST['location']);
    $lastdatetoapply = ($_POST['lastdatetoapply']);

    $sql="INSERT INTO `jobstable` (`register_id`,`position`, `qualification`, `experience`, `location`, `lastdatetoapply` , `is_active`)
    VALUES ('$register_id','$position', '$qualification', '$experience', '$location', '$lastdatetoapply' , '1')";
    mysqli_query($this->database, $sql);

  }

  private function validateCreatejobform() {

    $position        = ($_POST['position']);
    $qualification   = ($_POST['qualification']);
    $experience      = ($_POST['experience']);
    $location        = ($_POST['location']);
    $lastdatetoapply = ($_POST['lastdatetoapply']);

          if (empty($position)) {
            $this->errors['position']         = "Please enter position";
          }
          if (empty($qualification)) {
              $this->errors['qualification'] = "Please enter qualification";
          }
          if (empty($experience)) {
            $this->errors['experience']      = "Please enter experience";
          }
          if (empty($location)) {
            $this->errors['location']        = "Please enter location";
          }
          if (empty($lastdatetoapply)) {
            $this->errors['lastdatetoapply'] = "Please enter last date to apply";
          }
    
  }
}

// HelperApplyjobform class for processing create job form 
class HelperApplyjobform {
  private $database;
  private $errors = [];

  public function __construct($conn) {
      $this->database = $conn;
  }

  public function formvalidation() {

      $this->validateApplyjobform();

      $formresult = [];

      if (count($this->errors) > 0) {            
          $formresult = [
              'status' => false,
              'data' => $this->errors
          ];

      } else {

         $this->saveformdata();

          $successmsg = "Applied successfully";
          $formresult = [
              'status' => true,
              'data' => $successmsg
          ];
      }

      echo json_encode($formresult);
  }

  private function saveformdata() {

    $register_id       = ($_POST['register_id']);
    $job_id            = ($_POST['job_id']);
    $cnqualification   = ($_POST['cnqualification']);
    $cnexperience      = ($_POST['cnexperience']);
    $resume            = ($_FILES['resume']);

    $filename = $_FILES["resume"]["name"];
    $tempname = $_FILES["resume"]["tmp_name"];
    $folder = "./resumepdf/" . $filename;

    $sql = "INSERT INTO `applicantstable` (`user_id`, `job_id`, `cnqualification`, `cnexperience`, `resume`)
            VALUES ('$register_id', '$job_id', '$cnqualification', '$cnexperience' , '$filename')";
    mysqli_query($this->database, $sql);

    move_uploaded_file($tempname, $folder);

  }

  private function validateApplyjobform() {

    $register_id     = ($_POST['register_id']);
    $job_id          = ($_POST['job_id']);

    $sql="SELECT user_id , job_id  FROM `applicantstable` WHERE user_id=$register_id AND job_id=$job_id ";
    $result = mysqli_query($this->database, $sql);

    if (mysqli_num_rows($result) > 0) {
      $this->errors['alreadyappliederror']      = "You have already applied for this position";
    }
  
    else{

      $cnqualification   = ($_POST['cnqualification']);
      $cnexperience      = ($_POST['cnexperience']);
      $resume            = ($_FILES['resume']);
  
            if (empty($cnqualification)) {
                $this->errors['cnqualification'] = "Please enter qualification";
            }
            if (empty($cnexperience)) {
              $this->errors['cnexperience']      = "Please enter experience";
            }
            if (!isset($resume) || $resume['error'] != UPLOAD_ERR_OK) {
              $this->errors['resume'] = "Please upload resume";
            }else {
                // Check if the file is a PDF
                $fileType = strtolower(pathinfo($resume['name'], PATHINFO_EXTENSION));
                if ($fileType != 'pdf') {
                    $this->errors['resume'] = "Only PDF files are allowed.";
                }
                // Check file size (limit to 5MB)
                if ($resume['size'] > 5000000) {
                    $this->errors['resume'] = "File size should not exceed 5MB.";
                }
                // if (file_exists($target_file)) {
                //   $this->errors['resume'] = "Sorry, file already exists.";
                // }
              }

    }
  }

}