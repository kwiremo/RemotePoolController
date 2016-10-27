<!------The page that handles the scheduler and displays when the controller was set.------>
<!------Rene Moise Kwibuka and Christian Wagner----->
<!------04/26th/16------>

<html>
	
		
		<style>
body {
	display: block;
	margin: 80px;
}
body:focus{
	outline: none;
}
</style>
	  <center>
<body bgcolor="skyblue" style = center>	

	<?php	
	

		
		#Get the equipment to contol
		$eqToControl= $_POST["radioCont"];
		
	
		# The set date by the user from which the pump will run.
		$startDate = $_POST["year"] . "-" . $_POST["month"]. "-" .  $_POST["day"] ;
		$startDate = $startDate . " ". $_POST["hour"] . ":" . $_POST["minute"]; 
		$setDate=date_create($startDate,timezone_open("America/Chicago"));
		$date_Start = date_format($setDate, "y/m/d H:i") ."<br>";
		
		
		# Date to stop automation
		$stopDate = $_POST["yearStop"] . "-" . $_POST["monthStop"]. "-" .  $_POST["dayStop"] ;
		$stopDate = $stopDate . " ". $_POST["hourStop"] . ":" . $_POST["minuteStop"]; 
		$setStopDate=date_create($stopDate,timezone_open("America/Chicago"));
		$setDate_Stop = date_format($setStopDate, "y/m/d H:i") ."<br>";
		
		
		# How frequent is gonna be running
		$frequency = $_POST["radio"];
		
		
		# Pump stop time set by the user
		$date_End = $_POST["Period"];
		$dateStop = $setDate;
		if($_POST["radioDurat"] == "M")
		{
			$dateStop->add(new DateInterval(("PT".$date_End."M")));		
		}	
		else if ($_POST["radioDurat"] == "H")
		{
			$dateStop->add(new DateInterval(("PT".$date_End."H")));
		}
		else
		{
			$dateStop->add(new DateInterval(("PT".$date_End."H")));
		}
		
		$dateStop = date_format($dateStop, "y/m/d H:i") ."<br>";		

		
		# Create connection to database.
		$conn = new mysqli(localhost, admin, Cwagsm, setDateUser);
		
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		# Querry statement
		$sql = "INSERT INTO dateRecords (date, frequency, date_End, stopDate, eqToControl)
			VALUES ('$date_Start', '$frequency', '$dateStop', '$setDate_Stop', '$eqToControl')";

		# Execute querry
		if ($conn->query($sql) === TRUE) 
		{
		    echo "The pump was scheduled to run at ";
			if($frequency == " 1 week")
			{
				echo "weekly starting from : ";
			}
			else if ($frequency == " 1 day")
			{
				echo " daily starting from : ";
			}
			else if($frequency == " 1 day")
			
			{
				echo ("Every 2 minutes starting from: ");
			}
						
		} else 
		{
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		# Querry statement
		$sql = "SELECT  id, date, date_End FROM dateRecords ORDER by id DESC LIMIT 1";
		
		# Execute querry
		$result = $conn->query($sql);
		
		#Check if we retrieved any data
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
			echo $row["date"]. "<br>";
			
			
			
			}
		} else {
			echo "No data to show";
		}
		
		# Close connection once finished.
		$conn->close();		
	?>	

<p> Please click the button below to go back to the Dashboard </p>
<form action="dashboard.php">
    <input type="submit" name = "Dashboard" value="Go to Dashboard">
</form>
</body>
  </center>
</html>
