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
		}elseif ($_POST['newName'] == "") {
			header('Location: delete-editBranch.php?msg=Please fill required inputs!');
		}
		session_start();
		$stmt = $conn->prepare("UPDATE Branch SET Name = ? Where Id = ? ");
		$stmt->bind_param("si", $newName, $branchid);
		$branchid = $_SESSION['branchid'];
		$newName = $_POST['newName'];
		$stmt->execute();
		echo "You are successfully updated the Branch and related Doctors!";
		header("Refresh:2; URL=http://localhost/HospitalAppSys/adminHomepage.php");
	?>

</body>
</html>