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
			header("Location: edit.php?autos_id=".$_GET['autos_id']);
			return;
		}
		else if(!is_numeric($_POST['year']))
		{
			$_SESSION['error'] = "Year must be an integer";
			header("Location: edit.php?autos_id=".$_GET['autos_id']);
			return;	
		}
		else if(!is_numeric($_POST['mileage']))
		{
			$_SESSION['error'] = "Mileage must be an integer";
			header("Location: edit.php?autos_id=".$_GET['autos_id']);
			return;	
		}
		else
		{
			$sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE autos_id = :autos_id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':make' => $_POST['make'],
				':model' => $_POST['model'],
				':year' => $_POST['year'],
				':mileage' => $_POST['mileage'],
				':autos_id' => $_POST['autos_id']));
			$_SESSION['success'] = "Record edited";
			header("Location: index.php");
			return;
		}
	}

	$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :xyz");
	$stmt->execute(array(':xyz' => $_GET['autos_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row === false)
	{
		$_SESSION['error'] = "Bad value for autos_id";
		header("Location: index.php");
		return;
	}

	$make = htmlentities($row['make']);
	$model = htmlentities($row['model']);
	$year = htmlentities($row['year']);
	$mileage = htmlentities($row['mileage']);
	$autos_id = $row['autos_id']; 
?>

<html>
	<head>
		<title>Rahul Anilkumar Khatwani's Editing Page</title>
	</head>
	<body>
		<h1>Editing Automobiles</h1>
		<?php 
			if(isset($_SESSION['error']))
			{
				echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
				unset($_SESSION['error']);
			}
		?>
		<form method="post">
			<p>Make: <input type="text" name="make" value="<?= $make ?>"></p>
			<p>Model: <input type="text" name="model" value="<?= $model ?>"></p>
			<p>Year: <input type="text" name="year" value="<?= $year ?>"></p>
			<p>Mileage: <input type="text" name="mileage" value="<?= $mileage ?>"></p>
			<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
			<p>
				<input type="submit" value="Save">
				<input type="submit" name="cancel" value="Cancel">
			</p>
		</form>
	</body>
</html>