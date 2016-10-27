<!------This file displays the dashboard of "Pool Equipment Controller 9000"------>
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
	<head>
	     	<meta name="viewport" content="width=device-width" />
	     	<title>DASHBOARD</title>
			<link rel="stylesheet" href="styles.css">
			<link rel="stylesheet" type="text/css" href="onformat.css">
    </head>
    <center>
		<h1>POOL EQUIPMENT CONTROLLER 9000 DASHBOARD</h1>
	<body bgcolor="skyblue">
		
	<table>
		<tr>
			
	<td>

	<form action="display2.php">
		<input type="submit" name = "WATER TEMPERATURE HISTORY" value="WATER TEMPERATURE HISTORY">
	</form>
	</td>
			<td>
	<form method="get" action="preferences.php">
		<input type="submit" name = "PREFERENCES" value="PREFERENCES">
	</form>
	</td>
	
	<td>
	
	<form action="Scheduler.php">
    <input type="submit" name = "SCHEDULER" value="SCHEDULER">
	</form>
	</td>
	
	<td>

	<form action="display.php">
		<input type="submit" name = "AIR TEMPERATURE HISTORY" value="AIR TEMPERATURE HISTORY">
	</form>
	</td>
	</tr>
	</table>
		
		<table>
			<tr>
			   <th> PUMP CONTROL
			   <th> </th>
			   <th> HEATER CONTROL
			</tr>

			<tr>
				
				<td>
				
			<!---- This is the button to turn the PUMP on/off---->
				<form method="get" action="preferenceHandling.php">
						 <input type="submit" value="ON" name="on">
						 <input type="submit" value="OFF" name="off">
				</form>
				</td>
		
				<td></td>
				
				<td>
			<!---- This is the button to turn the HEATER on/off---->
				<form method="get" action="preferenceHandling.php">
						 <input type="submit" value="ON" name="onHeater">
						 <input type="submit" value="OFF" name="offHeater">
				</form>
				</td>
			
		   </tr>
		
		</table>
		
		<P><b>EQUIPMENT STATUS</b></P>
		<?php
		
		# Get the current date
		$today = date("Y-m-d H:i");
		
		$conn = new mysqli(localhost, admin, Cwagsm, equStatus);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT  running, date FROM pump ORDER by date DESC LIMIT 1";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
					if($row["running"] == 1)
					{
						echo "THE PUMP IS ON FOR: ";
						$datestr = new DateTime($today);
						$strEnd = new DateTime($row["date"]);
						$datediff = $datestr ->diff($strEnd);
						print $datediff->format("%D")." DAYS : ";
						print $datediff->format("%H")." HRS : ";	
						print $datediff->format("%I")." MIN "."<br>";	
					}
					else
					{
						echo "THE PUMP IS OFF FOR: ";
						$datestr = new DateTime($today);
						$strEnd = new DateTime($row["date"]);
						$datediff = $datestr ->diff($strEnd);
						print $datediff->format("%D")." DAYS : ";	
						print $datediff->format("%H")." HRS : ";	
						print $datediff->format("%I")." MIN "."<br>";			
					}
				
			    }
			} else {
			    echo "0 results";
			}
			
			$sql = "SELECT  running, date FROM heater ORDER by date DESC LIMIT 1";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
					if($row["running"] == 1)
					{
						echo "THE HEATER IS ON FOR: ";
						$datestr = new DateTime($today);
						$strEnd = new DateTime($row["date"]);
						$datediff = $datestr ->diff($strEnd);
						print $datediff->format("%D")." DAYS : ";
						print $datediff->format("%H")." HRS : ";	
						print $datediff->format("%I")." MIN "."<br>"."<br>";	
					}
					else
					{
						echo "THE HEATER IS OFF FOR: ";
						$datestr = new DateTime($today);
						$strEnd = new DateTime($row["date"]);
						$datediff = $datestr ->diff($strEnd);
						print $datediff->format("%D")." DAYS : ";	
						print $datediff->format("%H")." HRS : ";	
						print $datediff->format("%I")." MIN "."<br>"."<br>";			
					}			
			    }
			} else {
			    echo "0 results";
			}

		$conn->close();
		?>
		
		<P> <b>TEMPERATURES</b></P>
	
				<?php
		
		$sqlq = "SELECT unit FROM tempUnit order by date desc LIMIT 1";
			$conn = new mysqli(localhost, admin, Cwagsm, measurements);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			
			#Getting the temperature unit from the database			
			$res = $conn->query($sqlq);
			$ro = $res->fetch_assoc();
			$unit = $ro["unit"];
			
			
		$conn = new mysqli(localhost, admin, Cwagsm, preferences);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT  temperature FROM desiredTemp ORDER by date DESC LIMIT 1";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) 
			{
			    // output data of each row
			    while($row = $result->fetch_assoc()) 
			    {
					$temp = $row["temperature"];
					#If Celcius
					if($unit == 1)
					{	
						echo "PREFERRED POOL TEMPERATURE: " . number_format((float)$temp, 2, '.', '')." ℃"."<br>";
					}
					#If Fahreinheight
					else if ($unit == 0)
					{
						echo "PREFFERED POOL TEMPERATURE: " . (number_format((float)$temp, 1, '.', '')*9/5+32)." ℉"."<br>";					
					}	
				}
			}		
		?>
			<?php

			$servername = "localhost";
			$username = "admin";
			$password = "Cwagsm";
			$dbname = "measurements";
			$temperature;
			header("Refresh:60");
			$tempSet = $_POST["radiopref"];
			#echo $tempSet;
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql = "SELECT temperature FROM temperature order by dtg desc LIMIT 1";
			$sql1 = "SELECT unit FROM tempUnit order by date desc LIMIT 1";
			$sql2 = "SELECT temp FROM water_temp order by date desc LIMIT 1";
			
			#Getting the air temperature from the database
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$temperature = $row["temperature"];
			
			#Getting the water temperature from the database
			$result3 = $conn->query($sql2);
			$row3 = $result3->fetch_assoc();
			$waterTemperature = $row3["temp"];
			
			#Getting the temperature unit from the database			
			$result2 = $conn->query($sql1);
			$row2 = $result2->fetch_assoc();
			$unit = $row2["unit"];
		
			
			if ($result->num_rows > 0) 
			{
				if($result2->num_rows > 0)
				{				
					#If Celcius
					if($unit == 1)
					{	
						echo "AIR TEMPERATURE		: " . number_format((float)$temperature, 2, '.', '')." ℃"."<br>";
						echo "WATER TEMPERATURE		: " . number_format((float)$waterTemperature, 2, '.', '')." ℃"."<br>";

					}
					#If Fahreinheight
					else if ($unit == 0)
					{
						echo "AIR TEMPERATURE		: " . (number_format((float)$temperature, 1, '.', '')*9/5+32)." ℉"."<br>";
						echo "WATER TEMPERATURE		: " . (number_format((float)$waterTemperature, 1, '.', '')*9/5+32)." ℉"."<br>";
					}							
				}
				#Default to catch errors
				else
				{		
					echo "Air Temperature: " .$temperature." ℃"."<br>";
					echo "Water Temperature: " .$waterTemperature." ℃"."<br>";
				}
			} 
			else 
			{
			    echo "Temperature could not be found";
			}
			$conn->close();
		?>
		
		
		<P> <b>CURRENT DATE AND TIME</b></P>
		<!---- This part of the code displays current time---->

		<script type="text/javascript"> 

			function display_c()
			{
				var refresh=1000; // Refresh rate in milli seconds
				mytime=setTimeout('display_ct()',refresh)
			}
		
			function display_ct() 
			{
				var strcount
				var x = new Date()
				var hours = x.getHours();
				var hh = hours;
				var minutes = x.getMinutes();
				
				if(hours >12)
				{
					hours = hours - 12;
				}
				
				if(hh > 12)
				{
					if (minutes < 10)
					{
						var x1= (x.getMonth()+1) + "/" + x.getDate() + "/" + x.getFullYear(); 
						x1 = x1 + " - " + hours + ":" + "0"+ x.getMinutes() + " PM" ;
					}
					else
					{
						var x1= (x.getMonth()+1) + "/" + x.getDate() + "/" + x.getFullYear(); 
						x1 = x1 + " - " + hours + ":" + x.getMinutes() + " PM" ;
					}
				}
				else
				{
					if (minutes <10)
					{
						var x1= (x.getMonth()+1) + "/" + x.getDate() + "/" + x.getFullYear(); 
						x1 = x1 + " - " + hours + ":" + "0" + x.getMinutes() + " AM" ;
					}
					else
					{
						var x1= (x.getMonth()+1) + "/" + x.getDate() + "/" + x.getFullYear(); 
						x1 = x1 + " - " + hours + ":" + x.getMinutes() + " AM" ;
					}
				}
				
				
				document.getElementById('ct').innerHTML = x1;
				
				document.getElementById('temp').innerHTML = my_var;
				tt=display_c();
			}
		
		</script>

	
	</head>
		
		<body onload=display_ct();>
	<span id='ct' ></span>
	<span id='temp' ></span>


	</body>
	</center>
</html>
