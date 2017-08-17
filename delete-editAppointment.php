<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="jquery.datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="mystyle.css">

	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $.getJSON("get_branches.php", function (data) {
                var items = "<option value='0'>Choose branch</option>";
                $.each(data, function (i, branch) {
                    items += "<option value='" + branch["id"] + "'>" + branch["name"] + "</option>";
                });
                $("#branch").html(items);
            });

            $("#branch").change(function () {
            $.getJSON("get_doctors.php?branch=" + $("#branch").val(), function (data) {

                    var items = "";
                    items += "<option value='0'>Choose doctor</option>";
                    $.each(data, function (i, doctor) {
                        items += "<option value='" + doctor["id"] + "'>" + doctor["name"] + ' ' + doctor["surname"] + "</option>";
                    });
                    if ($('#branch option:selected').text() != 'Choose branch') {
                        $("#submitButton").attr("disabled", false);
                        $("#doctor").attr("disabled", false);
                        $("#doctor").html(items);
                    }
                });
            });

            $("#date").change(function () {
                $.getJSON("get_date_time.php?id=" + $("#doctor").val() + "&date="+$("#date").val(), function (data) {
                    items = "";
                    $.each(data, function (i, time) {
                        items += "<option value='" + time + "'>" + time + "</option>";
                    });
                    if ($('#doctor option:selected').text() != 'Choose Doctor') {
                        $("#time").attr("disabled", false);
                        $("#time").html(items);
                    }
                });
            });
        });
	</script>

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
		}elseif ($_POST['changeOption'] == "" OR $_POST['appointmentId'] == "") {
			header('Location: patientHomepage.php?msg=Please fill required inputs!');

		}
		session_start();
		if (!isset($_SESSION["UserName"])) {
			die ("You are not logged in. Please click <a href= homepage.php> login </a>");
		}
		if (isset($_GET['msg']) and !empty($_GET['msg'])) echo $_GET['msg'];
		if ($_POST['changeOption'] == 'edit') {
			$stmt = $conn->prepare("SELECT Appointment.Id, Doctor.Name, Doctor.Surname, Appointment.DateTime, Branch.Name FROM Appointment INNER JOIN Patient INNER JOIN Doctor INNER JOIN Branch ON Doctor.BranchId = Branch.Id AND Doctor.Id = Appointment.DoctorId AND Patient.Id = Appointment.PatientId AND Appointment.Id = ?");
			$stmt->bind_param("i", $appointmentid);
			$appointmentid = $_POST['appointmentId'];
			$stmt->execute();
			$stmt->bind_result($appointmentid, $doctorname, $doctorsurname, $datetime, $branchname);
			$stmt->fetch();
			$stmt->close();

			$_SESSION['appointmentid'] = $appointmentid;
			echo 'your current appointment is ' . $doctorname . ' ' . $doctorsurname . ': ' .$branchname. ' ' .$datetime. '';

			?>
			<form action="editAppointment.php" method="POST">
		        <label for="branch">Choose Branch</label>
		        <br />
		        <select class="select-list" id="branch" name="branch" required ></select>
		        <br />
		        <br />
		        <label for="doctor">Choose Doctor</label>
		        <br />
		        <select class="select-list" id="doctor" name="doctor"  ></select>
		        <br />
		        <br />
		        <p>Choose Date and Time</p>
		    	<input type="text" id="datetimepicker" name="dateTime" />
		        <input type=submit id="submitButton" value="Create">
		    </form>


		    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		    <!-- Include all compiled plugins (below), or include individual files as needed -->
		    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		    <script src="jquery.datetimepicker.full.js"></script>
		    <script>
		      $("#datetimepicker").datetimepicker(
		        {
		          step:5,
		          minTime:'05:00',
		        onGenerate:function( ct ){
		          jQuery(this).find('.xdsoft_date.xdsoft_weekend')
		          .addClass('xdsoft_disabled');
		          }
		        }
		      );
		    </script>
			<?php
		}
		else{
			$stmt = $conn->prepare("DELETE FROM Appointment WHERE Id = ?");
			$stmt->bind_param("i", $appointmentid);
			$appointmentid = $_POST['appointmentId'];
			$stmt->execute();
			$stmt->store_result();
			echo "You are successfully deleted the Appointment!";
			header("Refresh:2; URL=http://localhost/HospitalAppSys/patientHomepage.php");

		}

	?>
	
</body>
</html>