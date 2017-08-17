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
		if (!isset($_SESSION["AdminUserName"])) {
			die ("You are not logged in. Please click <a href= adminLogin.php> login </a>");
		}
		?>
		<form action="addBranch2.php" method="post">
		Branch Name: <input type="text" name="newName" value=><br><br>
		<input type="submit" value="Submit">	
		</form><br>
</body>
</html>