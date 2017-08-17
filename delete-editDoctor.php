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
		}elseif ($_POST['changeOption'] == "" OR $_POST['doctorId'] == "") {
			header('Location: adminHomepage.php?msg=Please fill required inputs!');

		}
		session_start();
		if ($_POST['changeOption'] == 'edit') {
			$stmt = $conn->prepare("SELECT Name, Surname, BranchId FROM Doctor WHERE Id = ?");
			$stmt->bind_param("i", $doctorid);
			$doctorid = $_POST['doctorId'];
			$stmt->execute();
			$stmt->bind_result($doctorname, $doctorsurname, $doctorbranchid);
			$stmt->fetch();
			$stmt->close();

			$stmt2 = $conn->prepare("SELECT Id, Name FROM Branch");
			$stmt2->execute();
			$stmt2->bind_result($branchid, $branchname);
			$stmt2->store_result();
			$_SESSION['doctorid'] = $doctorid;
			?>
			<form action="editDoctor.php" method="post">
			<?php
			echo 'Doctor Name: <input type="text" name="newName" value=' .$doctorname. '><br><br>';
			echo 'Doctor Surname: <input type="text" name="newSurname" value=' .$doctorsurname. '><br><br>';
			?>
			<select name="branchId" >
				<?php  
					while ($stmt2->fetch()) {
						echo '<option value="' .$branchid. '">' . $branchname . '</option>' ;
					}
				?>
			</select>
			<input type="submit" value="Submit">	
			</form><br>
			<?php
			$stmt2->close();				
			
		}
		else{
			$stmt = $conn->prepare("DELETE FROM Doctor WHERE Id = ?");
			$stmt->bind_param("i", $doctorid);
			$doctorid = $_POST['doctorId'];
			$stmt->execute();
			$stmt->store_result();
			echo "You are successfully deleted the Doctor!";

		}

	?>

</body>
</html>