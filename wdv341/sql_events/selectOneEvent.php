<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}
	
	include "pdoConnect.php";



	$result = false;

	$id = 1;

	try {
		$stmt = $conn->prepare("
			SELECT 
				event_id, 
				event_name, 
				event_description, 
				event_presenter, 
				event_date, 
				event_time
			FROM 
				wdv341_event
			WHERE
				event_id = ?
			LIMIT 
				1
			");

		$stmt->bindParam(1, $id);

		$result = $stmt->execute();
	}
	catch(PDOException $e) {
    	echo "Error: " . $e->getMessage();
    }	
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Select Events</title>
	</head>
	<body>
		<table>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Description</th>
				<th>Presenter</th>
				<th>Date</th>
				<th>Time</th>
			</tr>
			<?php
				if ($result) {
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			?>
				    	<tr>
				    		<td><?php echo $row->event_id ?></td>
				    		<td><?php echo $row->event_name ?></td>
				    		<td><?php echo $row->event_description ?></td>
				    		<td><?php echo $row->event_presenter ?></td>
				    		<td><?php echo $row->event_date ?></td>
				    		<td><?php echo $row->event_time ?></td>
				    	</tr>
			<?php
				  	} 
				} else {
					echo "</table><p>Select failed!</p>";
				}
			?>
	</table>
	</body>
</html>