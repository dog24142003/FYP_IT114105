<?php

require_once ("conn.php");
require_once ("common/header.php");

   	$confirmRq = $_GET['confirmRq'];
   	$reportID = $_GET['reportID'];
/*from viewteacher_profile*/
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if($confirmRq == 'true'){
		$sql ="UPDATE reports SET report_status='Warned' where reportID='".$reportID."';";
	}else{
		$sql ="UPDATE reports SET report_status='Reject' where reportID='".$reportID."';";
	}
    
   	if(mysqli_query(getDBconn(),$sql)) {
       echo '<script>alert("Successfully!");window.location.href="page_admin_profile.php";</script>';
    }
        
    else {
		echo '<script>alert("Error!");window.location.href="page_admin_profile.php;</script>';
	}
     
}
mysqli_close(getDBconn());
?>