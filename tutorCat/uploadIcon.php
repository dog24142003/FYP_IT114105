<?php
require_once "conn.php";
require_once ("common/header.php");
 

if (!isset($_POST["craeteBookSubmit"])) {
    echo "<script>alert('404 error')</script>";
} else {

//    $IconImg = $_POST["IconImg"];
    $IconType = $_POST["IconType"];
    $Email = $_POST["Email"];
    $Imgblob = addslashes(file_get_contents($_FILES["IconImg"]['tmp_name']));

    // Insert image content into database 
	if($_SESSION['account'] == 'Student'){
		$sql ="UPDATE student SET IconImg = '$Imgblob' , IconImgType = '$IconType' WHERE Email=$Email;";
	}
	else{
		$sql ="UPDATE tutor SET IconImg = '$Imgblob' , IconImgType = '$IconType' WHERE Email=$Email;";

	}
	
    
    if (mysqli_query(getDBconn(), $sql)) {
		if($_SESSION['account'] == 'Student'){
			echo '<script>alert("Successfully !");window.location.href="page_student_profile.php";</script>';
		}else{
			echo '<script>alert("Successfully !");window.location.href="page_teacher_profile.php";</script>';
		}
        
     } else {
		if($_SESSION['account'] == 'Student'){
			echo '<script>alert("Error!");window.location.href="page_student_editProfile.php;</script>';
		}else{
			echo '<script>alert("Error!");window.location.href="page_teacher_editProfile.php;</script>';
		}
        

    }        
            
           
}



?>
