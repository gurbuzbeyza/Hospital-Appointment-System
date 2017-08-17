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
	<h1>Welcome to THE Hospital Appointment System (HAS)</h1>
	<form action="patientLogin.php" method="post">
		Username: <input type="text" name="UserName"><br><br>
		Password: <input type="password" name="Password"><br><br>
		<input type="submit" value="Submit">	
	</form><br>
	<div class="btn-group">
		<a href=register.php><button button1>Register</button></a>
		<a href=adminLogin.php><button button2>Admin Login</button></a>
	</div>

</body>
</html>