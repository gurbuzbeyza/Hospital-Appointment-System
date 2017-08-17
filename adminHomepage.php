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
		
		<form method="post" action="delete-editBranch.php">
			<p>Choose a branch</p>
			<select name="branchId" >
				<?php 
				echo "Branches:"; 
					while ($stmt->fetch()) {
						echo '<option value="' .$id. '">' . $name . '</option>' ;
					}
				?>
			</select>
			<select name="changeOption" >
  				<option value="delete">Delete</option>
  				<option value="edit">Edit</option>
			</select>
			<input type="submit" name="submitEditDelete" value="Submit">
		</form><br>
		<div class="btn-group">
			<a href=addBranch.php><button>Add new Branch</button></a><br><br><br>
		</div>
	<?php	
		$stmt = $conn->prepare("SELECT Id, Name, Surname FROM Doctor");

		$stmt->execute();
		$stmt->bind_result($id, $name, $surname);
		$stmt->store_result();
		?>
		
		<form method="post" action="past-previousApp.php">
			<p>Choose a doctor</p>
			<select name="doctorId" >
				<?php  
					while ($stmt->fetch()) {
						echo '<option value="' .$id. '">' . $name . ' ' .$surname. '</option>' ;
					}
				?>
			</select>
			<select name="changeOption" >
  				<option value="delete">Delete</option>
  				<option value="edit">Edit</option>
			</select>
			<input type="submit" name="submit_register_course" value="Submit">
		</form><br>
		<div class="btn-group">
			<a href=addDoctor.php><button>Add new Doctor</button></a>
			<a href=adminLogout.php><button>Logout</button></a><br>
			<a href=appBranch.php><button>Show Appointments Of Branches</button></a>
		</div>

</body>
</html>