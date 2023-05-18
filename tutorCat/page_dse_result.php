<?php

require_once("conn.php");

require_once('Common/header.php');
$tEmail = $_SESSION['Email'];
$result = mysqli_query(getDBconn(), "SELECT * FROM tutor WHERE Email='$tEmail';");
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $tEmail = $row['Email'];
       
    }

    //    extract($result);
} else {
    echo $tEmail;
} 
$sql = "SELECT * FROM dse_result WHERE Email='$tEmail' ORDER BY Year DESC;";

$result = mysqli_query(getDBconn(),$sql);
	
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>

<body>

	<div class="d-flex justify-content-center">
		<div class="gap-2 mt-3">
			<a href="page_add_dse_result.php"class="btn btn-lg btn-brand" type="button">Add</a>
		</div>
	</div>
	<div class="row justify-content-center mt-3">
		<div class="col-auto">
			<table class="table table-responsive" style="">
				<thead>
					<tr>
						<th scope="col">Year</th>
						<th scope="col">Subject</th>
						<th scope="col">Result</th>
					</tr>

				</thead>
				<tbody>
				
					<?php
                    if($result->num_rows > 0){
						while($row = mysqli_fetch_assoc($result)){
							$results[] = $row;
						}


						foreach ($results as $key => $result) {
							echo '<tr><td>'
									.$result['Year'].'</td><td>'
									.$result['Subject'].'</td><td>'
									.$result['Result'].'</td>';
						}
					}else{
						echo "There not any result";
					}         
						
                                        
                   	?>
				</tbody>
				
			</table>
		</div>
	</div>
	
</body>
<style>
	.table {
		border: 2px solid darkcyan;
		border-collapse: separate;
		padding: 20px;
	}

</style>

</html>
