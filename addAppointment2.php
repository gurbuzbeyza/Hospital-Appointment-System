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
		$stmt = $conn->prepare("SELECT DoctorId FROM Appointment WHERE DateTime = ? ");
		$stmt->bind_param('s', $datetime);
		$datetime = $_POST['dateTime'];
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
		$stmt = $conn->prepare("INSERT INTO Appointment(PatientId, DoctorId, DateTime) VALUES (?, ?, ?)");
		$stmt->bind_param("iis", $patientid, $doctorid, $datetime);
		$stmt->execute();
		$stmt->close();
		echo "You are successfully added a new Appointment!";
		header("Refresh:2; URL=http://localhost/HospitalAppSys/patientHomepage.php");
	?>

</body>
</html>