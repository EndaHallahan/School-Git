<?php
	session_start();
	include "pdoConnect.php";
	$loggedin = false;
	$errorMsg = "";
	$result = false;
	if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["validUser"])) {
		$loggedin = true;
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
	    	$errorMsg = "Error: " . $e->getMessage();
	    }	

	    if ($_GET) {
	    	$error = $_GET["error"] || "";
		    if ($error == "404") {
		    	$errorMsg = "Could not delete record; record does not exist.";
		    } else if ($error == "500") {
		    	$errorMsg = "Internal error; please try again.";
		    }
	    }

	} else {
		$username = "";
		$password = "";

		if(isset($_POST['loginSubmit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			try {
				$stmtu = $conn->prepare("
					SELECT 
						event_user_id
					FROM 
						wdv341_event_user
					WHERE
						event_user_name = ?
						AND event_user_password =  ?
					LIMIT
						1
					");
				$stmtu->bindParam(1, $username);
				$stmtu->bindParam(2, $password);
				$resultu = $stmtu->execute();

				if ($resultu && $stmtu->rowCount() == 1) {
					$_SESSION["validUser"] = true;
					$loggedin = true;
					header('Location: ' . "login.php", true, 303);
				} else {
					$errorMsg = "Invalid username or password.";
				}
			}
			catch(PDOException $e) {
		    	$errorMsg = "Error: " . $e->getMessage();
		    }
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
		<?php
			if ($loggedin && $result) {
		?>
			<a href="logout.php">Log out</a>
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
			</table>
		<?php	
			} else {
		?>
			<form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="text" name="username" value="<?php echo $username; ?>">
				<input type="text" name="password" value="<?php echo $password; ?>">
				<input type="submit" name="loginSubmit" value="Submit">
			</form>
		<?php 
			}
		?>
		<p><?php echo $errorMsg ?></p>		
	</body>
</html>