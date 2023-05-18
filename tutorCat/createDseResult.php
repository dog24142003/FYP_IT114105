<?php

require_once ("conn.php");
require_once ("common/header.php");

    $sender = $_SESSION['Email'];
/*from viewteacher_profile*/
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $year = $_POST["year"];
    $subject = $_POST["subject"];
	$result = $_POST["result"];
	

    $sql = "INSERT INTO `dse_result` (`Year`, `Subject`, `Result`, `Email`) VALUES
('$year', '$subject', '$result', '$sender');";
    
   	if(mysqli_query(getDBconn(),$sql)) {
       echo '<script>alert("Successfully!");window.location.href="page_dse_result.php";</script>';
    }
        
    else {
		echo '<script>alert("Error!");window.location.href="page_dse_result.php";</script>';
	}
     
}
mysqli_close(getDBconn());
?>