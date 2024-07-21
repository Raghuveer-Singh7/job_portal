<?php
require 'connection.php';
require 'Helper.php';  //Including helper class as the proccing logic is written in those only.

//Registration form processing
if (isset($_POST['username'])) {
    $obj = new Helperreg($conn);
    $obj->formvalidation();
}

//Login form processing
if (isset($_POST['processlogin'])) {
    $obj = new Helperlog($conn);    
    $obj->formvalidation();    
}

// Create job form processing
if (isset($_POST['processcreatejob'])) {
    $obj = new HelperCreatejobform($conn);    
    $obj->formvalidation();    
}

//Apply job form processing
if (isset($_POST['processapplyjob'])) {
    $obj = new HelperApplyjobform($conn);    
    $obj->formvalidation();    
}