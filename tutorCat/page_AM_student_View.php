<?php require_once('Common/header.php');?>
<?php
$i= 0;
    require_once ("conn.php");
    $Email = $_GET['Email'];
//    $current_status = $_GET['report_status'];
    $sql = "SELECT * FROM student WHERE Email='$Email';";
    $result = mysqli_query(getDBconn(),$sql);
    
    if (!empty($result) && $result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentID = $row['StudentID'];
            $uID = $row['UniqueID'];
            $fName = $row['FirstName'];
            $lName = $row['LastName'];
            
            $pw = $row['Password'];
            $phone = $row['Phone'];
			$subject = $row['Subject'];
			$icon = $row['IconImg'];
			$iconType = $row['IconImgType'];
			$status = $row['Status'];


			if ($icon == null) {
				$icon = '<img src="img/logo.jpg"  class="rounded-circle" ';
			} else {
				$icon = '<img src="data:image/' . $iconType . ';base64,' . base64_encode($icon) . '" class="rounded-circle" width="200" height="200" alt=""/>';
			}
        }
 
	}else {

    }

    ?>
<!--    Detail-->
<div class="container">
	<div class="row">
		<div class="col-12 my-2 mt-5">
			<h4 class="text-secondary">View Tutor Details <br>User:<span class="badge bg-info text-dark"><?php echo $Email;?></span></h4>

		</div>
	</div>
</div>

<div class="container">

	<div class="row">
		<div class="col-12">
			<a href="page_admin_profile.php" class="btn btn-secondary">Return</a>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Icon:
		</div>
		<div class="col-12 col-sm-3 text-secondary fw-bold">
			<?php echo $icon; ?>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Email:
		</div>
		<div class="col-12 col-sm-8 text-secondary fw-bold">
			<?php echo $Email; ?>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Name:
		</div>
		<div class="col-12 col-sm-8 text-secondary fw-bold">
			<?php echo $fName; echo " ".$lName;?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Password:
		</div>
		<div class="col-12 col-sm-8 text-secondary fw-bold">
			<?php echo $pw; ?>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Phone:
		</div>
		<div class="col-12 col-sm-8 text-secondary fw-bold">
			<?php echo $phone; ?>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Subject:
		</div>
		<div class="col-12 col-sm-8 text-secondary fw-bold">
			<?php echo $subject; ?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Status:
		</div>
		<div class="col-12 col-sm-8 text-secondary fw-bold">
			<?php echo $status; ?>
		</div>
	</div>
	





	<div class="row mt-3">
		<div class="col-12 col-sm-4">
			Report of Student
		</div>
		<div class="col-12 col-sm-8 text-secondary">
			<table class="table table-sm">
				<tr>
					<th>Sender's Email</th>
					<th>Reason</th>
					<th>Status</th>
					<th>Number of warnings</th>
				</tr>

				<?php

                    $sql = mysqli_query(getDBconn(),"SELECT * FROM reports WHERE reports.getterEmail = '$Email'And reports.report_status != 'pending';");
                    while($row = mysqli_fetch_assoc($sql)){
						$i++;
                        echo '<tr><td>'
                        .$row['getterEmail'].'</td><td>'
                        .$row['reason'].'</td><td>'
                        .$row['report_status'].'</td><td>'
                        .$i.'</td></tr>';
                    }
                    ?>

			</table>
		</div>
	</div>

	<button id="con_btn" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#susAc">
		Suspension Account
	</button>
<!--	doesnt need to delete the account-->
<button id="con_btn" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#unsusAc">
		Unsuspension Account
	</button>
	<!-- Button trigger modal -->




	<!-- Modal -->
	<form class="p-lg-5 col-12 row g-3" action="suspendAccount.php" method="post">
		<div class="modal fade" id="susAc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<input type="hidden" name="account" value="student">
					<div class="modal-header">
						<h5 class="modal-title" id="sendWarn">Suspension Account</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Email:<span class="badge bg-info text-dark"><?php echo $Email ; ?></span><br>
						Name:<span class="badge bg-info text-dark"><?php echo $fName; echo " ".$lName; ?></span><br>
						Number of warnings:<span class="badge bg-info text-dark"><?php echo $i; ?></span>

					</div>
					<div class="col-8">
						Suspend Day:<input name="susDay" id="susTime" type="number" class="form-control">

						<label for="email" class="form-label">Suspend Reason</label>
						<input type="hidden" name="Email" value="<?php echo $Email; ?>">
						<select id="mySelect" onchange="getValue()" name="reason_Option" class="form-select  mb-3" aria-label=".form-select-lg example">
							<option value="" disabled selected>Open this select menu</option>
							<option value="offensiveContent">Posting inappropriate/offensive content</option>
							<option value="hateSpeech">Using inappropriate language or hate speech</option>
							<option value="spam">Sending excessive advertising/spam messages</option>
							<option value="cheating">Cheating/manipulating ratings</option>
							<option value="sexual">Posting pornographic/violent/offensive content</option>
						</select>
						
						 

						<textarea name="Description" class="form-control" placeholder="Type Suspend Detail" id="floatingTextarea2" style="height: 100px"></textarea>
					</div>


					<div class="modal-footer">
						<button type="submit" class="btn btn-success" name="submit">Send</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Return</button>
					</div>

				</div>
			</div>
		</div>
	</form>
<!--model-->
<form class="p-lg-5 col-12 row g-3" action="unsuspendAccount.php" method="post">
		<div class="modal fade" id="unsusAc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<input type="hidden" name="account" value="student">
					<div class="modal-header">
						<h5 class="modal-title" id="sendWarn">Unsuspension Account</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Email:<span class="badge bg-info text-dark"><?php echo $Email ; ?></span><br>
						Name:<span class="badge bg-info text-dark"><?php echo $fName; echo " ".$lName; ?></span><br>
						Number of warnings:<span class="badge bg-info text-dark"><?php echo $i; ?></span>

					</div>
					<input type="hidden" name="Email" value="<?php echo $Email; ?>">


					<div class="modal-footer">
						<button type="submit" class="btn btn-success" name="submit">Send</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Return</button>
					</div>

				</div>
			</div>
		</div>
	</form>
	<script>
		$(document).ready(function() {
			if ($("#conValue").val() == 'Warned' || $("#conValue").val() == 'Reject') {

				$("#con_btn").hide();


			}



		});

	</script>
