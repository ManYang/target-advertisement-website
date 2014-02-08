<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Modify Parameters </title>
<link href="layout.css" rel="stylesheet" type="text/css">
<?php
	session_start();
	if (!isset($_SESSION['username']))
	header("Location:login.php");
?>
</head>

<body>
<div class="container">
	<h1  align="center">modify</h1>
<br>
<form method='get' action="home.php">
<p align='center'>
		<strong>Top Ad Bar Width</strong>: 
		<input type='text' name='topAdWidth' placeholder="enter px"><br>
		<strong>Top Ad Bar Height</strong>: 
		<input type='text' name='topAdHeight' placeholder="enter px"><br><br>		          
		<input type='submit' value = 'topAd' name='topAd'><br>
</p>
</form>

<form method='get' action="home.php">
<p align='center'>
		<strong>Left Ad Bar Width</strong>: 
		<input type='text' name='leftAdWidth' placeholder="enter px"><br>
		<strong>Left Ad Bar Height</strong>: 
		<input type='text' name='leftAdHeight' placeholder="enter px"><br><br>		          
		<input type='submit' value = 'leftAd' name='leftAd'><br>
</p>
</form>

<form method='get' action="home.php">
<p align='center'>
		<strong>Right Ad Bar Width</strong>: 
		<input type='text' name='rightAdWidth' placeholder="enter px"><br>
		<strong>Right Ad Bar Height</strong>: 
		<input type='text' name='rightAdHeight' placeholder="enter px"><br><br>		          
		<input type='submit' value = 'rightAd' name='rightAd'><br>
</p>
</form>
</div>

</body>
</html>
