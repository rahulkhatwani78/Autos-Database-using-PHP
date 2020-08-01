<?php 
	session_start();
	unset($_SESSION['name']);
	header("Location: index.php");
	return;
?>

<html>
	<head>
		<title>Rahul Anilkumar Khatwani's Logout Page</title>
	</head>
</html>