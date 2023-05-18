<?php

require_once ("conn.php");
require_once ("common/header.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $tEmail = $_POST["Email"];
    $phone = $_POST["Phone"];
    if($_SESSION['account'] == 'Tutor'){
        $detail = $_POST["Description"];
    }
    
    $pw = $_POST["conPw"];
    if($pw == null){
        $pw = $_POST["oldPw"];
    }
    
//   need add icon password subject.
    
   if($_SESSION['account'] == 'Student'){
            
            $sql = "UPDATE Student SET FirstName='".$fname."',LastName='".$lname."', Phone='".$phone."', Password='".$pw."' where Email='".$tEmail."';";
            
        }else{
            $sql = "UPDATE tutor SET Phone='".$phone."', Description='".$detail."', Password='".$pw."' where Email='".$tEmail."';";
        }
    

     if (mysqli_query(getDBconn(), $sql)) {
         if($_SESSION['account'] == 'Tutor' ){
             echo '<script>alert("Successfully !");window.location.href="page_teacher_profile.php";</script>';
         }else{
             echo '<script>alert("Successfully!");window.location.href="page_student_profile.php";</script>';
         }
        
     } else {
         if($_SESSION['account'] == 'Tutor' ){
              echo '<script>alert("Error!");window.location.href="page_teacher_editProfile.php;</script>';
         }else{
              echo '<script>alert("Error!");window.location.href="page_student_editProfile.php;</script>';
         }
       
         /*'<script>alert("Error!");window.location.href="page_viewOrderDetails.php?orderID='.$orderID.'";</script>';*/
    }
     
}
mysqli_close(getDBconn());
?>
