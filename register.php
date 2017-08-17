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
		if (isset($_GET['msg']) and !empty($_GET['msg'])) echo $_GET['msg'];

	?>
	<h3>Register</h3>
	<form action="patRegister.php" method="post">
	Name: <input type="text" name="Name"><br><br>
	Surname: <input type="text" name="Surname"><br><br>
	Username: <input type="text" name="UserName"><br><br>
	Password: <input type="password" name="Password"><br><br>
	<input type="submit" value="Submit">	
	</form><br>

</body>
</html>