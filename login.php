<?php 
	session_start();

	if(isset($_POST['email']) && isset($_POST['pass']))
	{
		if(strlen($_POST['email'])<1 || strlen($_POST['pass'])<1)
		{
			$_SESSION['error'] = "User name and password are required";
			header("Location: login.php");
			return;
		}
		if($_POST['pass'] == "php123")
		{
			$_SESSION['name'] = $_POST['email'];
			header("Location: index.php");
			return;
		}
		else
		{
			$_SESSION['error'] = "Incorrect Password";
			header("Location: login.php");
			return;
		}
	}
?>
<html>
	<head>
		<title>Rahul Anilkumar Khatwani's Login Page</title>
	</head>
	<body>
		<h1>Please Log In</h1>
		<?php 
			if(isset($_SESSION['error']))
			{
				echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
				unset($_SESSION['error']);
			}
		?>
		<form method="post">
			<p>User Name: <input type="text" name="email"></p>
			<p>Password: <input type="password" name="pass"></p>
			<p>
				<input type="submit" name="login" value="Log In">
				<a href="index.php">Cancel</a>
			</p>
		</form>
		<p>For a password hint, view source and find a password hint in the HTML comments</p>
		<!-- Password is the Language we are learning in this course(all lower case) followed by 123. -->
	</body>
</html>