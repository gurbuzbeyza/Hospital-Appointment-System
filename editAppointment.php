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
		$stmt = $conn->prepare("SELECT Id FROM Patient WHERE UserName = ? ");
		$stmt->bind_param('s', $patientname);
		$patientname = $_SESSION["UserName"];
		$stmt->execute();
		$stmt->bind_result($patientid);
		$stmt->fetch();
		$stmt->close();
		$stmt = $conn->prepare("SELECT DoctorId FROM Appointment WHERE DateTime = ? AND Id != ? ");
		$stmt->bind_param('si', $datetime, $appointmentid);
		$datetime = $_POST['dateTime'];
		$appointmentid = $_SESSION['appointmentid'];
		$stmt->execute();
		$stmt->bind_result($docid);
		$doctorid = $_POST['doctor'];
		$stmt->store_result();
		while ($stmt->fetch()) {
			if ($docid==$doctorid) {
				header('Location: patientHomepage.php?msg=The doctor has already an appointment in given date and time!');
			}
		}
		$stmt->close();
		$stmt = $conn->prepare("UPDATE Appointment SET PatientId = ?, DoctorId = ?, DateTime = ? Where Id = ? ");
		$stmt->bind_param("iisi", $patientid, $doctorid, $datetime, $appointmentid);
		$stmt->execute();
		$stmt->close();
		echo "You are successfully updated the Appointment!";
		header("Refresh:2; URL=http://localhost/HospitalAppSys/patientHomepage.php");
	?>

</body>
</html>