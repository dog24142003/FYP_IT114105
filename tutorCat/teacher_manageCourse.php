<?php
require_once('common/header.php');
$tutorID = $_SESSION['TutorID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<!-- Teacher List -->
	<link rel="stylesheet" href="css/courseList.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
	<!--   Required js-->
	<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/app.js"></script>
	<script>
		function StateSave(elementID) {
			cid = document.getElementById('CID_' + elementID).value;
			if (confirm('Delete Course, course ID :' + cid + '?')) {
				// Save it!
				location.href = 'delCourse.php?CourseID=' + cid;

			}
		}
	</script>
</head>

<body>
<br>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="col-sm-12 btn-group me-2">
            <button type="button" class="btn  btn-outline-warning" onclick="location.href='teacher_schedule.php';">Calendar</button>
            <button type="button" class="btn  btn-outline-warning" onclick="location.href='teacher_manageCourse.php';">Course Detail</button>
            <button type="button" class="btn  btn-outline-warning" onclick="location.href='teacher_analyze.php';">Analyze Report</button>
        </div>
    </div>
<h1>&nbsp;Course Mangement</h1>
	<div class="row justify-content-center">
		<div class="col-sm-10">
			<div class="table-responsive">
				<table class="table table-striped table-sm">
					<thead>
						<tr>
							<th scope="col">Course ID</th>
							<th scope="col">Student Name</th>
							<th scope="col">Date</th>
							<th scope="col">Time</th>
							<th scope="col">State</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php $conn = getDBconn();

						$sql = "SELECT schedule.*, student.FirstName, student.LastName, course.Time, course.Hour FROM schedule, student, course WHERE student.StudentID = schedule.StudentID AND course.CourseID = schedule.CourseID AND schedule.StudentID IS NOT NULL AND schedule.TutorID=" . $tutorID . " ORDER BY Date DESC";
						// $sql = "SELECT schedule.*, student.FirstName, student.LastName FROM schedule, student WHERE student.StudentID = schedule.StudentID AND schedule.StudentID IS NOT NULL AND TutorID= 10003 ORDER BY Date ASC";
						$result = $conn->query($sql);
						$num = mysqli_num_rows($result);


						if ($num >= 1) {

							$conn->close();

							while ($row = mysqli_fetch_assoc($result)) {
								$results[] = $row;
								$courseID = $row['CourseID'];
							}
							$i = 0;
							foreach ($results as $key => $result) {
								$courseTime  = date("g:i a", strtotime($result['Time']));
								$endTime  = date("g:i a", strtotime($result['Time'] . ' + ' . $result['Hour'] . ' hours'));
								if ($result['State'] == "wait") {
									$state = '					
					<td> <select name="state" id="state">
						<option value="wait" selected="selected">wait</option>
						<option value="completed">completed</option>
						<option value="cancel">cancel</option>
					</select></td>
					<td><button type="submit" class=" " ;">Save</button></td>';
								} else if ($result['State'] == "completed") {
									$state = '					
						<td> <select name="state" id="state" disabled>
							<option value="wait" >wait</option>
							<option value="completed" selected="selected">completed</option>
							<option value="cancel">cancel</option>
						</select></td>
						<td></td>';
								} else {
									$state = '					
						<td> <select name="state" id="state" disabled>
							<option value="wait" >wait</option>
							<option value="completed" >completed</option>
							<option value="cancel" selected="selected">cancel</option>
						</select></td>
						<td></td>';
								}
								echo '  
					<form method="post" action="changeState.php">
					<input type="hidden" name="scheduleID"  value="' . $result['ScheduleID'] . '" />
					<tr>
					<td>' . $result['CourseID'] . '</td>
					<td>' . $result['FirstName'] . ' ' . $result['LastName'] . '</td>
					<td>' . $result['Date'] . '</td>
					<td>' . $courseTime . '-' . $endTime . '</td>'
									. $state . '
				  	</tr>
					</form>';
								$i++;
							}
						} else {
							echo "<tr><td colspan='6' class='h1'>No Course Record</tr></td>";
						}

						?>






					</tbody>
				</table>
			</div>
			</main>
		</div>
	</div>


</body>

</html>