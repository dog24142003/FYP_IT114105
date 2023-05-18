<?php

require_once("conn.php");

require_once('Common/header.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>

<body>
	<div class="container">

		<h1 class="mt-5">Add Results</h1>

		<div class="row mt-3">
			<form action="createDseResult.php" method="POST">

				<table class="table table-hover">
					<tr>
						<th>Year</th>
						<td><input name="year" type="number" min="1900" max="2099" step="1" value="2023" required />
						</td>
					</tr>
					<tr>
						<th>Subject</th>
						<td><select name="subject" class="form-select" id="exampleSelect1" required>
								<option>Chinese Language</option>
								<option>English Language</option>
								<option>Mathematics</option>
								<option>Chinese Literature</option>
								<option>English Literature</option>
								<option>Chinese History</option>
								<option>Economics</option>
								<option>Geography</option>
								<option>History</option>
								<option>Economics</option>
								<option>Biology</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>Result</th>
						<td><select name="result" class="form-select" id="exampleSelect1" required>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>5*</option>
								<option>5**</option>
								
							</select>
						</td>
					</tr>
					<tr>

				</table>

				<input type="submit" name="submit" value="Place Order">
			</form>

		</div>

	</div>

</body>

</html>
