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
		}elseif ($_POST['changeOption'] == "" OR $_POST['branchId'] == "") {
			header('Location: adminHomepage.php?msg=Please fill required inputs!');

		}
		session_start();
		if ($_POST['changeOption'] == 'edit') {
			$stmt = $conn->prepare("SELECT Name FROM Branch WHERE Id = ?");
			$stmt->bind_param("i", $branchid);
			$branchid = $_POST['branchId'];
			$stmt->execute();
			$stmt->bind_result($branchname);
			$stmt->fetch();
			$_SESSION['branchid'] = $branchid;
			?>
			<form action="editBranch.php" method="post">
			<?php
			echo 'Branch Name: <input type="text" name="newName" value=' .$branchname. '><br><br>'
			?>
			<input type="submit" value="Submit">	
			</form><br>
			<?php
		}
		else{
			$stmt = $conn->prepare("DELETE d FROM Doctor d JOIN Branch b ON b.Id = d.BranchId WHERE b.Id = ?");
			$stmt->bind_param("i", $branchid);
			$branchid = $_POST['branchId'];
			$stmt->execute();
			$stmt->store_result();
			$stmt = $conn->prepare("DELETE FROM Branch WHERE Id = ?");
			$stmt->bind_param("i", $branchid);
			$branchid = $_POST['branchId'];
			$stmt->execute();
			$stmt->store_result();
			echo "You are successfully deleted the Branch and related Doctors!";
			header("Refresh:2; URL=http://localhost/HospitalAppSys/adminHomepage.php");
		}

	?>

</body>
</html>