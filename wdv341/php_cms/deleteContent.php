<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";
	$contentId = $_GET["contentid"];
	$url = "admin.php";

	try {
		$stmt = $conn->prepare("
			DELETE FROM 
				wdv341_cms_content
			WHERE
				cms_content_id = ?
			");

		$stmt->bindParam(1, $contentId);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
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