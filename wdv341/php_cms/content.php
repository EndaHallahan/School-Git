<?php 
	session_start();
	include "pdoConnect.php";

	$id = "";
	$result = false;
	$errorMsg = "";

	if (isset($_GET['contentid'])) {
		$id = $_GET["contentid"];
		try {
			$stmt = $conn->prepare("
				SELECT 
					cms_content_id,
					cms_content_title,
					cms_content_content,
					cms_content_date
				FROM 
					wdv341_cms_content
				WHERE
					cms_content_id = ?
				LIMIT
					1
				");
			$stmt->bindParam(1, $id);
			$result = $stmt->execute();
		} catch(PDOException $e) {
	    	$errorMsg = "Error: " . $e->getMessage();
	    }
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<?php include "head.php" ?>
	</head>
	<body>
		<?php include "header.php" ?>
		<main>
			<?php
				if ($result && $stmt->rowCount() == 1) {
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			?>
					<h1><?php echo $row->cms_content_title; ?></h1>
					<div><?php echo date('jS F, Y // h:i A', $row->cms_content_date); ?></div>
					<p><?php echo $row->cms_content_content; ?></p>
			<?php
				  	} 
				} else {
			?>
					<h1>Error 404: Content does not exist.</h1>
			<?php
				}
			?>
		</main>
	</body>
</html>