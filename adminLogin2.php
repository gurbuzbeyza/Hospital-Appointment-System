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

		$stmt = $conn->prepare("SELECT UserName, Password FROM Admin WHERE UserName = ? AND Password = ?");
		$stmt->bind_param("ss", $adminusername, $password);

		$adminusername = $_POST['UserName'];
		$password = $_POST['Password'];

		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows) {
			session_start();
			$_SESSION["AdminUserName"] = $adminusername;
			echo 'Welcome ' .$_SESSION["UserName"]. '';

			$stmt = $conn->prepare("SELECT Id FROM Admin WHERE UserName = ?");
			$stmt->bind_param("s", $adminusername);
			$stmt->execute();
			$stmt->bind_result($adminid);
			$stmt->fetch();
			$_SESSION["adminid"] = $adminid;
			echo 'your id is ' .$_SESSION["patientid"]. '';;
			header('Location: adminHomepage.php');

		}
		else{

			header('Location: adminLogin.php?msg=Your username or password is wrong. Please try again!'); 
		}

	?>

</body>
</html>