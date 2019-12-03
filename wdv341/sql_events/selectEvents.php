<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";

	$result = false;

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
			");

		$result = $stmt->execute();
	}
	catch(PDOException $e) {
    	echo "Error: " . $e->getMessage();
    }	

    $errorMsg = "";
    if ($_GET) {
    	$error = $_GET["error"] || "";
	    if ($error == "404") {
	    	$errorMsg = "Could not delete record; record does not exist.";
	    } else if ($error == "500") {
	    	$errorMsg = "Internal error; please try again.";
	    }
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
				    		<td><a href="deleteEvent.php?eventid=<?php echo $row->event_id ?>">Delete</a></td>
				    	</tr>
			<?php
				  	} 
				} else {
					echo "</table><p>Select failed!</p>";
				}
			?>
			<p><?php echo $errorMsg ?></p>
	</table>
	</body>
</html>