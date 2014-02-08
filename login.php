<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login </title>
<link href="layout.css" rel="stylesheet" type="text/css">
</head>


	<h1  align="center">Advertisement management</h1>
<br>

<body>
	<form action='login.php' method='POST'>	
	    <p align="center">
		<strong>Username</strong>: 
		<input type='text' name='username' placeholder="username"><br>
		<strong>Password</strong>: 
		<input type='password' name='password' placeholder="password"><br><br>	<br>	          
		<input type='submit' value = 'submit' name='Log in'><br>
		</p>
	</form>
	<form action='register.php' method='link'>
		<p align='center'>
		<input type='submit' value='register'>
		</p>
	</form>	
<?php
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$_SESSION['username']=$username;

	$connect= mysql_connect("127.0.0.1","123","123") or die ("Couldn't connect to the database");		
	mysql_select_db("comp7105cept") or die("Couldn't find database");	
	
	// To protect MySQL injection (more detail about MySQL injection)
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	
	$sql="SELECT * FROM users WHERE username='$username' and password='$password'";
	$result=mysql_query($sql);
	
	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);
	
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1){
/*
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			echo "Name :{$row['name']} <br>" .
			"Subject : {$row['subject']} <br>" .
			"Message : {$row['message']} <br><br>";
			}

		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$role = $row['role'];
		
		
		if($role == 'adminr'){
			header("Location:questionnaire.php");
		}else {
		*/	
		//$_SESSION ['username']= $username;
		header("Location:modify.php");
//		}
		
	}
	else{
		echo"<h2 align=\"center\">"."Invalid Username or Password."."</h2>";
	}

?>
</body>
</html>


