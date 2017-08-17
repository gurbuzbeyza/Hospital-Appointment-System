<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="mystyle.css">

</head>
<body>
	<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "Hospital";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}elseif ($_POST['changeOption'] == "" OR $_POST['branchName'] == "") {
			header('Location: appBranch.php?msg=Please fill required inputs!');

		}
		session_start();
		if ($_POST['changeOption'] == 'past') {
			$branchname = $_POST['branchName'];
			$stmt = $conn->prepare("CALL ADD_PAST(?)");
			$stmt->bind_param('s', $branchname); 
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($appointmentid, $datetime, $doctorname, $doctorsurname);
			if ($stmt->num_rows > 0) {
				echo "<h3>Past Appointments Table of ".$branchname."</h3>"; 
				echo '<table style="width:100%">
					  <tr>
					    <th>Date and Time</th>
					    <th>Doctor Name</th>
					    <th>Doctor Surname</th> 
					  </tr>';
				while ($stmt->fetch()) {
					echo '<tr><td>' .$datetime. '</td><td>' .$doctorname. '</td><td>' .$doctorsurname. '</td><tr>' ;
				}
				echo "</table>";
			}
			else{
				?>
					<p>No Result</p>
				<?php
			}			
		}
		else{
			$branchname = $_POST['branchName'];
			$stmt = $conn->prepare("CALL ADD_FUTURE(?)");
			$stmt->bind_param('s', $branchname); 
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($appointmentid, $datetime, $doctorname, $doctorsurname);
			if ($stmt->num_rows > 0) {
				echo "<h3>Future Appointments Table of ".$branchname."</h3>"; 
				echo '<table style="width:100%">
					  <tr>
					    <th>Date and Time</th>
					    <th>Doctor Name</th>
					    <th>Doctor Surname</th> 
					  </tr>';
				while ($stmt->fetch()) {
					echo '<tr><td>' .$datetime. '</td><td>' .$doctorname. '</td><td>' .$doctorsurname. '</td><tr>' ;
				}
				echo "</table>";
				}
				else{
					?>
						<p>No Result</p>
					<?php
				}	
		}

	?>

</body>
</html>