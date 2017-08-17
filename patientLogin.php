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
		}elseif ($_POST['UserName'] == "" OR $_POST['Password'] == "") {
			header('Location: homepage.php?msg=Please fill required inputs!');

		}

		$stmt = $conn->prepare("SELECT UserName, Password FROM Patient WHERE UserName = ? AND Password = ?");
		$stmt->bind_param("ss", $username, $password);

		$username = $_POST['UserName'];
		$password = $_POST['Password'];

		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows) {
			session_start();
			$_SESSION["UserName"] = $username;
			echo 'Welcome ' .$_SESSION["UserName"]. '';

			$stmt = $conn->prepare("SELECT Id FROM Patient WHERE UserName = ?");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->bind_result($patientid);
			$stmt->fetch();
			$_SESSION["patientid"] = $patientid;
			echo 'your id is ' .$_SESSION["patientid"]. '';;
			header('Location: patientHomepage.php');

		}
		else{

			header('Location: homepage.php?msg=Your username or password is wrong. Please try again!'); 
		}

	?>

</body>
</html>