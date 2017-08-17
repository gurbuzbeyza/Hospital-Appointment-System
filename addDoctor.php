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
		$stmt2 = $conn->prepare("SELECT Id, Name FROM Branch");
		$stmt2->execute();
		$stmt2->bind_result($branchid, $branchname);
		$stmt2->store_result();
		?>
		<form action="addDoctor2.php" method="post">
			Doctor Name: <input type="text" name="newName" value=><br><br>
			Doctor Surname: <input type="text" name="newSurname" value=><br><br>
			Branch:
			<select name="branchId" >
				<?php  
					while ($stmt2->fetch()) {
						echo '<option value="' .$branchid. '">' . $branchname . '</option>' ;
					}
				?>
			</select>			
			<input type="submit" value="Submit">	
		</form><br>
</body>
</html>