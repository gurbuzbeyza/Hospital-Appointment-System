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

		$stmt = $conn->prepare("SELECT Doctor.Id, Doctor.Name, Doctor.Surname FROM Doctor Where Doctor.BranchId =  ?");
		$stmt->bind_param('i', $branchname);
		$branchname = $_GET['branch'];
		$stmt->execute();
		$stmt->bind_result($id, $name, $surname);
		$data = array();
		$stmt->store_result();
		if ($stmt->num_rows) {
			while ($stmt->fetch()) {
				$data[]  = array(
					'id' => $id,
					'name' => $name,
					'surname' => $surname
				);
			}
			header('Content-type: application/json');
			echo json_encode($data);
		}
?>