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
		} 
		session_start();
		if (!isset($_SESSION["UserName"])) {
			die ("You are not logged in. Please click <a href= patientLogin.php> login </a>");
		}
		if (isset($_GET['msg']) and !empty($_GET['msg'])) echo $_GET['msg'];
		
		$stmt = $conn->prepare("SELECT Appointment.Id, Doctor.Name, Doctor.Surname, Appointment.DateTime, Branch.Name FROM Appointment INNER JOIN Patient INNER JOIN Doctor INNER JOIN Branch ON Doctor.BranchId = Branch.Id AND Doctor.Id = Appointment.DoctorId AND Patient.Id = Appointment.PatientId AND Patient.UserName = ? ");
		$stmt->bind_param('s', $patientusername);
		$patientusername = $_SESSION["UserName"];
		$stmt->execute();
		$stmt->bind_result($id, $doctorname, $doctorsurname, $datetime, $branchname);
		$stmt->store_result();
		?>
		
		<form method="post" action="delete-editAppointment.php">
			<p>Choose an appointment</p>
			<select name="appointmentId" >
				<?php 
				echo "Your Appointments:"; 
					while ($stmt->fetch()) {
						echo '<option value="' .$id. '">' . $doctorname . ' ' . $doctorsurname . ': ' .$branchname. ' ' .$datetime. '</option>' ;
					}
				?>
			</select>
			<select name="changeOption" >
  				<option value="delete">Delete</option>
  				<option value="edit">Edit</option>
			</select><br>
			<input type="submit" name="submitEditDelete" value="Submit">
		</form><br>
		<div class="btn-group">
			<a href=addAppointment.php><button>Add new Appointment</button></a>
			<a href=patientLogout.php><button>Logout</button></a>
		</div>

</body>
</html>