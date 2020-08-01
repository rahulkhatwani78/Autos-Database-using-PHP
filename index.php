<?php 
	session_start();
	require_once "pdo.php";
?>

<html>
	<head>
		<title>Rahul Anilkumar Khatwani's Index Page</title>
	</head>
	<body>
		<h1>Welcome to the Automobiles Database</h1>
		<?php
			if(!isset($_SESSION['name']))
			{
				echo '<p><a href="login.php">Please log in</a></p>'."\n";
				echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>'."\n";
			}
			else
			{
				if(isset($_SESSION['success']))
				{
					echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
					unset($_SESSION['success']);
				}
				if(isset($_SESSION['error']))
				{
					echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
					unset($_SESSION['error']);
				}
				$stmt = $pdo->query("SELECT * FROM autos");
				if($stmt->fetch(PDO::FETCH_ASSOC) === false)
				{
					echo "<p>No rows found</p>\n";
				}
				else
				{
					echo '<table border="1">';
					echo "<tr>";
					echo "<th>Make</th>";
					echo "<th>Model</th>";
					echo "<th>Year</th>";
					echo "<th>Mileage</th>";
					echo "<th>Action</th>";
					echo "</tr>";
					$stmt = $pdo->query("SELECT * FROM autos");
					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo "<tr><td>";
						echo $row['make'];
						echo "</td><td>";
						echo $row['model'];
						echo "</td><td>";
						echo $row['year'];
						echo "</td><td>";
						echo $row['mileage'];
						echo "</td><td>";
						echo '<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ';
						echo '<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>';
						echo "</td></tr>";
					}
					echo "</table>";
				}
				echo '<p><a href="add.php">Add New Entry</a></p>';
				echo '<p><a href="logout.php">Logout</a></p>';
			}
		?>
	</body>
</html>