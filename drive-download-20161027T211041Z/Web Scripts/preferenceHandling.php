<!------This page handles the preferences set by the user------>
<!------Rene Moise Kwibuka and Christian Wagner----->
<!------04/26th/16------>
<html>
<body bgcolor="skyblue" style = center>	
<?php

#This script handles the on and off buttons. It saves the equipment status into the database.
		$conn = new mysqli(localhost, admin, Cwagsm, equStatus);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$setmode17 = shell_exec("gpio -g mode 25 out");
		
			if(isset($_GET['onHeater']))
			{
				$gpio_on = shell_exec("gpio -g write 25 1");
				$sql = "INSERT INTO heater (running )
				VALUES (1)";

				if ($conn->query($sql) === TRUE) 
				{
		    			echo "Recorded";
				}			
			
				else 
				{
			   	 	echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				$gpio_on = shell_exec("gpio -g write 18 1");
				$sql = "INSERT INTO pump (running )
				VALUES (1)";

				if ($conn->query($sql) === TRUE) 
				{
		    			echo "Recorded";
				}	
				
			}
			else if(isset($_GET['offHeater'])){
					$gpio_off = shell_exec("gpio -g write 25 0");
					$sql = "INSERT INTO heater (running )
					VALUES (0)";
	
					if ($conn->query($sql) === TRUE) 
					{
			    			echo "Recorded";
					}			
				
					else 
					{
				   	 	echo "Error: " . $sql . "<br>" . $conn->error;
					}
					echo "LED is off" . "<br";
			}


		#This script handles the on and off buttons. It saves the equipment status into the database.
		$conn = new mysqli(localhost, admin, Cwagsm, equStatus);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$setmode17 = shell_exec("gpio -g mode 18 out");
		
			if(isset($_GET['on']))
			{
				$gpio_on = shell_exec("gpio -g write 18 1");
				$sql = "INSERT INTO pump (running )
				VALUES (1)";

				if ($conn->query($sql) === TRUE) 
				{
		    			echo "Recorded";
				}			
			
				else 
				{
			   	 	echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				
				echo "LED is on" . "<br";
			}
			else if(isset($_GET['off'])){
					$gpio_off = shell_exec("gpio -g write 18 0");
					$gpio_off = shell_exec("gpio -g write 25 0");
					
					$sql = "INSERT INTO pump (running )
					VALUES (0)";
	
					if ($conn->query($sql) === TRUE) 
					{
			    			echo "Recorded";
					}			
				
					else 
					{
				   	 	echo "Error: " . $sql . "<br>" . $conn->error;
					}
					
					$sql = "INSERT INTO heater (running )
					VALUES (0)";
	
					if ($conn->query($sql) === TRUE) 
					{
			    			echo "Recorded";
					}	
			}
	
	
			#This script reads the user temperature preferences and save them in the database.
		$conn = new mysqli(localhost, admin, Cwagsm, measurements);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		
			if(isset($_GET['radiopreCelc']))
			{
				#Inserting  Celcius values
				$sql = "INSERT INTO tempUnit(unit )
				VALUES (1)";

				if ($conn->query($sql) === TRUE) 
				{
		    			echo "Recorded";
				}			
			
				else 
				{
			   	 	echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			else if(isset($_GET['radioprefFahr']))
			{
				#Inserting  Fahrenheight values
					$sql = "INSERT INTO tempUnit (unit )
					VALUES (0)";
	
					if ($conn->query($sql) === TRUE) 
					{
			    			echo "Recorded";
					}			
				
					else 
					{
				   	 	echo "Error: " . $sql . "<br>" . $conn->error;
					}
			}
			
			$desiredTemp = $_GET['setTemperature'];
			echo $_GET['radio'] ;
			
			if($_GET['radio'] == "F")
			{
				$desiredTemp  = ($desiredTemp - 32) * 5/9;
				echo $desiredTemp;
			}
			else
			{
				#It is already Celcius, leave it alone.
			}
	
			
			
				$conn = new mysqli(localhost, admin, Cwagsm, preferences);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		
			if($desiredTemp > 0 && $desiredTemp <100)
			{
				#Inserting  Celcius values
				$sql = "INSERT INTO desiredTemp(temperature )
				VALUES ($desiredTemp)";

				if ($conn->query($sql) === TRUE) 
				{
		    			echo "Recorded";
				}			
			
				else 
				{
			   	 	echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			
	#Immediately return back to the dashboard.
	header('Location: dashboard.php');

?>
</body>
</html>
