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

		if($stmt = $conn->prepare("INSERT INTO Branch (Name) VALUES (?) ")){
			$stmt->bind_param('s', $branchname);
			$branchname = $_POST['newName'];
			$stmt->execute();
			echo "You are successfully added a new Branch!";
			header("Refresh:2; URL=http://localhost/HospitalAppSys/adminHomepage.php");
		}
		
		?>
</body>
</html>