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
		elseif ($_POST['newName']=='') {
			header('Location: homepage.php?msg=Please fill required inputs!');
		}
		session_start();
		if (!isset($_SESSION["AdminUserName"])) {
			die ("You are not logged in. Please click <a href= adminLogin.php> login </a>");
		}

		if($stmt2 = $conn->prepare("INSERT INTO Doctor (Name, Surname, BranchId) VALUES (?, ?, ?) ")){
			$stmt2->bind_param('ssi', $doctorname, $doctorsurname, $doctorbranchid);
			$doctorname = $_POST['newName'];
			$doctorsurname = $_POST['newSurname'];
			$doctorbranchid = $_POST['branchId'];
			$stmt2->execute();
			$stmt2->close();
			echo "You are successfully added a new Doctor!";
			header("Refresh:2; URL=http://localhost/HospitalAppSys/adminHomepage.php");
		}
		else{
			echo 'Error: ' . $conn->error . "<BR />\n";
		}
		
		?>
</body>
</html>