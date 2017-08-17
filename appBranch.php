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
		if (isset($_GET['msg']) and !empty($_GET['msg'])) echo $_GET['msg'];
		
		$stmt = $conn->prepare("SELECT Id, Name FROM Branch");
		$stmt->execute();
		$stmt->bind_result($id, $name);
		$stmt->store_result();
		?>
		
		<form method="post" action="past-futureApp.php">
			<p>Choose a branch</p>
			<select name="branchName" >
				<?php 
					echo '<option value="' .ALL. '"> ALL </option>' ;
					while ($stmt->fetch()) {
						echo '<option value="' .$name. '">' . $name . '</option>' ;
					}
				?>
			</select>
			<select name="changeOption" >
  				<option value="past">Past</option>
  				<option value="future">Future</option>
			</select>
			<input type="submit" name="submitPastFuture" value="Submit">
		</form><br>

</body>
</html>