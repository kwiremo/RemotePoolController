<!------This page displays the preferences of the "Pool Equipment Controller 9000"------>
<!------Rene Moise Kwibuka and Christian Wagner----->
<!------04/26th/16------>

<!DOCTYPE html>
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
<title>preferences page</title>
</head>
    <center>
<body bgcolor="skyblue" style = center>
	Choose temperature Unit: <br>
	<form action="preferenceHandling.php" method="get">
		
	<input type="radio" name="radiopreCelc" value="C" > Celcius<br>
	<input type="radio" name="radioprefFahr" value="F"> Fahreinheight<br><br>
	
	Set preferred pool Temperature:
<table>
<tr>
<td>
	<input type="number" name="setTemperature" ><br>
</td>

<td>
	<input type="radio" name="radio" value="F" >F

</td>
<td>
	<input type="radio" name="radio" value="C"> C
</td>	
</tr>
</table>

<table>
	<tr>
		<td>
<input type="submit" name = "OK" value="submit">
</td>

<td>
<form action="dashboard.php">
    <input type="submit" name = "Dashboard" value="Go to Dashboard">
</form>
</td>
</tr>
</table>
	</form>


</body>
	</center>
</html>
