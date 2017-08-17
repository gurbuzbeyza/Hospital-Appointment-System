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
		if ($conn->connect_error){
		    die("Connection failed: " . $conn->connect_error);
		}
		elseif ($_POST['UserName'] == "" OR $_POST['Password'] == "" OR $_POST['Name'] == "" OR $_POST['Surname'] == "") {
			header('Location: homepage.php?msg=Please fill required inputs!');
		}
		$stmt = $conn->prepare("SELECT UserName FROM Patient WHERE UserName = ?");
		$stmt->bind_param("s", $username);

		$username = $_POST['UserName'];
		$stmt->execute();	
		$stmt->store_result();
		if ($stmt->num_rows==0) {
			$stmt = $conn->prepare("INSERT INTO Patient (UserName, Name, Surname, Password) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("ssss", $username, $name, $surname, $password);
			$name = $_POST['Name'];
			$surname = $_POST['Surname'];		
			$username = $_POST['UserName'];
			$password = $_POST['Password'];
			$stmt->execute();
			echo "<h3>You are successfully registered!</h3>";
			header("Refresh:2; URL=http://localhost/HospitalAppSys/homepage.php");
		}
		else {
			header('Location: register.php?msg=There is already a username  ' .$username.' Please choose a different name!');
		}

	?>

</body>
</html>