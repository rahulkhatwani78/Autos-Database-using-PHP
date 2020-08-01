<?php 
	session_start();
	require_once "pdo.php";

	if(!isset($_SESSION['name']))
	{
		die("ACCESS DENIED");
	}
	if(isset($_POST['cancel']))
	{
		header("Location: index.php");
		return;
	}
	if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']))
	{
		if(strlen($_POST['make'])<1 || strlen($_POST['model'])<1 || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1)
		{
			$_SESSION['error'] = "All fields are required";
			header("Location: add.php");
			return;
		}
		else if(!is_numeric($_POST['year']))
		{
			$_SESSION['error'] = "Year must be an integer";
			header("Location: add.php");
			return;	
		}
		else if(!is_numeric($_POST['mileage']))
		{
			$_SESSION['error'] = "Mileage must be an integer";
			header("Location: add.php");
			return;	
		}
		else
		{
			$sql = "INSERT INTO autos(make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':make' => $_POST['make'],
				':model' => $_POST['model'],
				':year' => $_POST['year'],
				':mileage' => $_POST['mileage']));
			$_SESSION['success'] = "Record added";
			header("Location: index.php");
			return;
		}
	}
?>

<html>
	<head>
		<title>Rahul Anilkumar Khatwani's Adding Page</title>
	</head>
	<body>
		<h1>Tracking Automobiles for <?= htmlentities($_SESSION['name'])?></h1>
		<?php 
			if(isset($_SESSION['error']))
			{
				echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
				unset($_SESSION['error']);
			}
		?>
		<form method="post">
			<p>Make: <input type="text" name="make"></p>
			<p>Model: <input type="text" name="model"></p>
			<p>Year: <input type="text" name="year"></p>
			<p>Mileage: <input type="text" name="mileage"></p>
			<p>
				<input type="submit" value="Add">
				<input type="submit" name="cancel" value="Cancel">
			</p>
		</form>
	</body>
</html>