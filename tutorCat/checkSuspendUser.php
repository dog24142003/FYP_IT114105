<?php

require_once ("conn.php");
require_once ("common/header.php");

/*from viewteacher_profile*/
	$current_date = date('Y-m-d');

	$sql = "SELECT * FROM suspenduser";
	$result = mysqli_query(getDBconn(),$sql);
	if ($result->num_rows > 0) {
		while ($row = mysqli_fetch_assoc($result)) {

			$Email = $row['Email'];
			$until = $row['blocked_until'];

		}
	}
	if($until <= $current_date){
		$sql = "UPDATE tutor SET blockStatus=0 WHERE Email='$Email'";
		
		if(mysqli_query(getDBconn(),$sql)) {
       		echo '<script>alert("Successfully!");window.location.href="index.php";</script>';
			$sql = "DELETE FROM suspenduser WHERE Email ='$Email'";
			mysqli_query(getDBconn(),$sql);
    }
        
		else {
			echo '<script>alert("Error!");window.location.href="index.php";</script>';
		}
	}
	
	
   	
     

mysqli_close(getDBconn());
?>