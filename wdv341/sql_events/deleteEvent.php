<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";
	$eventId = $_GET["eventid"];
	$url = "selectEvents.php";

	try {
		$stmt = $conn->prepare("
			DELETE FROM 
				wdv341_event
			WHERE
				event_id=?
			");

		$stmt->bindParam(1, $eventId);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if (affectedRows > 0) {
			header('Location: ' . $url, true);
			exit();
		} else {
			header('Location: ' . $url . "?error=404", true, 303);
			exit();
		}
	}
	catch(PDOException $e) {
    	header('Location: ' . $url . "?error=500", true, 303);
    	exit();
    }
?>