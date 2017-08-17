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

		$stmt = $conn->prepare("UPDATE Doctor SET Name = ?, Surname = ?, BranchId = ? Where Id = ? ");
		$stmt->bind_param("ssii", $newname, $newsurname, $newbranch, $doctorid);
		$doctorid = $_SESSION['doctorid'];
		$newname = $_POST['newName'];
		$newsurname = $_POST['newSurname'];
		$newbranch = $_POST['branchId'];
		$stmt->execute();
		$stmt->close();
		echo "You are successfully updated the Doctor!";
		header("Refresh:2; URL=http://localhost/HospitalAppSys/adminHomepage.php");
	?>

</body>
</html>