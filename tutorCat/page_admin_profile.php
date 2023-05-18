<?php

require_once("conn.php");
require_once('Common/header.php');
$tEmail = $_SESSION['Email'];
$uId = $_SESSION['UniqueID'];
$i = 0;
if ($tEmail == 'admin@tutorcat.com') {
        $sql = "SELECT * FROM student WHERE Email='admin@tutorcat.com';";

    }
    else if ($tEmail == 'admin@tutorcat.com') {
        $sql = "SELECT * FROM tutor WHERE Email='admin@tutorcat.com';";
    }
$result = mysqli_query(getDBconn(),$sql);

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $tname = $row['FirstName'] . ' ' . $row['LastName'];
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $tEmail = $row['Email'];
        $icon = $row['IconImg'];
        $iconType = $row['IconImgType'];
        
        if ($icon == null) {                      
            $icon = '<img src="img/logo.jpg"  class="rounded-circle" ';
        } else {
            $icon = '<img src="data:image/' . $iconType . ';base64,' . base64_encode($icon) . '" class="rounded-circle" width="200" height="200" alt=""/>';
        }

    }
 
} 

    $result = mysqli_query(getDBconn(),"SELECT * FROM reports");

    while($row = mysqli_fetch_assoc($result)){
    	$results[] = $row;
    }

    foreach ($results as $key => $result) {
        if($result['report_status'] == 'Pending'){
            $i++;
        }
        
    }

	
                                   

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">



	<title>Your Profile</title>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" type="image/x-icon" href="favicon.ico" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/owl.carousel.min.css" />
	<link rel="stylesheet" href="css/owl.theme.default.min.css" />
	<link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="css/style.css" />
	<!--   Required js-->
	<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/app.js"></script>
	<!--    jquery code-->
	<script>
		$(document).ready(function() {
			$("#reportTable").hide();
			$("#userTable").hide();
			$("#profile_btn").click(function() {
				/*hide*/
				$("#reportTable").hide();
				$("#userTable").hide();
				/*show*/
				$("#myProfile").show();
			});
			$("#reportRq_btn").click(function() {
				/*hide*/
				$("#myProfile").hide();
				$("#userTable").hide();
				/*show*/
				$("#reportTable").show();
			});			
			$("#userManage_btn").click(function() {
				/*hide*/
				$("#myProfile").hide();
				$("#reportTable").hide();
				/*show*/
				$("#userTable").show();
			});
			$("#tutor_btn").click(function() {
				/*hide*/
				$("#tutor_btn").attr('class', 'flex-sm-fill text-sm-center nav-link active');
				/*show*/
				$("#student_btn").attr('class', 'flex-sm-fill text-sm-center nav-link');
			});

			$("#tutor_table").hide();
			$("#student_btn").click(function() {
				/*hide*/
				$("#tutor_btn").attr('class', 'flex-sm-fill text-sm-center nav-link ');
				$("#tutor_table").hide();

				/*show*/
				$("#student_table").show();
				$("#student_btn").attr('class', 'flex-sm-fill text-sm-center nav-link active');
			});
			$("#tutor_btn").click(function() {
				/*hide*/
				$("#tutor_btn").attr('class', 'flex-sm-fill text-sm-center nav-link active');
				$("#student_table").hide();


				/*show*/
				$("#tutor_table").show();
				$("#student_btn").attr('class', 'flex-sm-fill text-sm-center nav-link ');
			});
			 



		});

	</script>


</head>

<body>
	<div class="container">
		<div class="main-body">


			<div class="row gutters-sm">
				<div class="col-md-4 mb-3">
					<div class="card">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center text-center">

								<div class="mt-3">
									<?php echo $icon; ?>
									<h4>
										<?php echo $tname; ?>
									</h4>



								</div>
								<div class="row">
									<div class="col-sm-12">
										<a class="btn btn-brand" target="__blank" href="page_student_editProfile.php">Edit</a>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card mt-3">
						<ul class="list-group list-group-flush">
							<div class="btn-group-vertical">
								<a id="profile_btn" href="#" class="btn btn-brand active" aria-current="page">My
									Profile</a>
								<button id="reportRq_btn" type="button" class="btn btn-brand">
									Report Request<span class="badge bg-info "><?php echo $i?></span>
								</button>
								<a id="refundRq_btn" href="#" class="btn btn-brand">Refund Request</a>
								<a id="userManage_btn" href="#" class="btn btn btn-brand">User Account Management</a>

							</div>
						</ul>
					</div>
				</div>

				<div class="col-md-8">
					<!--                profile start-->
					<div class="card mb-3" id="myProfile">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<h6 class="mb-0">Full Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="fname" class="form-control" value="<?php echo $tname; ?>" readonly="true">

								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<h6 class="mb-0">Email</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="Email" class="form-control" value="<?php echo $tEmail; ?>" readonly="true">

								</div>
							</div>

						</div>
					</div>
					<!-- profile end-->
					<!--                    report request-->
					<div class="card mb-" id="reportTable">
						<div class="card-body">
							<table class="table table-hover">
								<tr>
									<th>Report ID</th>
									<th>Sender Email</th>
									<th>Send Date Time</th>
									<th>Reason</th>
									<th>Report Status</th>
									<th>Detail</th>
								</tr>

								<tbody>
									<?php
                                    

                                    foreach ($results as $key => $result) {
                                        
                                        echo '<tr><td>'
											.$result['reportID'].'</td><td>'
                                            .$result['senderEmail'].'</td><td>'
                                            .$result['dateTime'].'</td><td>'
                                            .$result['reason'].'</td><td>'
                                            .'<span class="badge rounded-pill bg-warning text-dark">'.$result['report_status'].'</td><td></span></td><td>'
                                            .'<button class="btn btn-outline-danger" onclick="location.href=\'page_report_View.php?senderEmail='.$result['senderEmail'].'&reportID='.$result['reportID'].'&report_status='.$result['report_status'].'\'">Details</button></td><td>';
                                        
										
                                    }
                                    
                                    ?>
								</tbody>
							</table>

						</div>
					</div>
					<!--student user account management-->
					<div class="card mb-" id="userTable">
						<div class="card-body">
							<nav class="nav nav-pills flex-column flex-sm-row">
								<a id="student_btn" class="flex-sm-fill text-sm-center nav-link active" aria-current="page" href="#">Student</a>
								<a id="tutor_btn" class="flex-sm-fill text-sm-center nav-link" href="#">Teacher</a>

							</nav>
							<table id="student_table" class="table table-hover">
								<tr>
									<th>FirstName</th>
									<th>LastName</th>
									<th>Email</th>
									<th>Status</th>
									<th>Detail</th>
								</tr>

								<tbody>
									<?php
                                        $result_std = mysqli_query(getDBconn(),"SELECT * FROM student where UniqueID !=0");

										while($row = mysqli_fetch_assoc($result_std)){
										$results_std[] = $row;
										}

										foreach ($results_std as $key => $result_std) {
											 echo '<tr><td>'
											.$result_std['FirstName'].'</td><td>'
											.$result_std['LastName'].'</td><td>'
                                            .$result_std['Email'].'</td><td>'
                                            .$result_std['Status'].'</td><td>'
                                            .'<button class="btn btn-outline-danger" onclick="location.href=\'page_AM_student_View.php?Email='.$result_std['Email'].'\'">Details</button></td><td>';
										}
                                    ?>

								</tbody>
							</table>

							<table id="tutor_table" class="table table-hover">
								<tr>
									<th>FirstName</th>
									<th>LastName</th>
									<th>Email</th>
									<th>Status</th>
									<th>Detail</th>
								</tr>

								<tbody>
									<?php
                                        $result_tutor = mysqli_query(getDBconn(),"SELECT * FROM tutor where UniqueID !=0");

										while($row = mysqli_fetch_assoc($result_tutor)){
										$results_tutor[] = $row;
										}

										foreach ($results_tutor as $key => $result_tutor) {
											
											 echo '<tr><td>'
											.$result_tutor['FirstName'].'</td><td>'
											.$result_tutor['LastName'].'</td><td>'
                                            .$result_tutor['Email'].'</td><td>'
                                            .$result_tutor['Status'].'</td><td>'
											.'<button class="btn btn-outline-danger" onclick="location.href=\'page_AM_tutor_View.php?account=tutor&Email='.$result_tutor['Email'].'\'">Details</button></td><td>';
										}

                                    ?>

								</tbody>
							</table>

						</div>
					</div>


				</div>





			</div>
		</div>

	</div>

	<style type="text/css">
		body {
			color: #1a202c;
			text-align: left;
			background-color: #e2e8f0;
		}

		.main-body {
			padding: 15px;
		}

		.card {
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
		}

		.card {
			position: relative;
			display: flex;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
			border: 0 solid rgba(0, 0, 0, .125);
			border-radius: .25rem;
		}

		.card-body {
			flex: 1 1 auto;
			min-height: 1px;
			padding: 1rem;
		}

		.gutters-sm {
			margin-right: -8px;
			margin-left: -8px;
		}

		.gutters-sm>.col,
		.gutters-sm>[class*=col-] {
			padding-right: 8px;
			padding-left: 8px;
		}

		.mb-3,
		.my-3 {
			margin-bottom: 1rem !important;
		}

		.bg-gray-300 {
			background-color: #e2e8f0;
		}

		.h-100 {
			height: 100% !important;
		}

		.shadow-none {
			box-shadow: none !important;
		}

		body {
			background-color: #eee;
		}

		#icon {
			object-fit: fill;
		}

	</style>

</body>

</html>
