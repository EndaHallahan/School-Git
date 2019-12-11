<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";

	$title = "";
	$body = "";
	$id = "";
	$description = "";
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
					cms_content_description
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

	} else if (isset($_POST['updateSubmit'])) {
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
		$body = htmlspecialchars($_POST['body'], ENT_QUOTES);
		$id = htmlspecialchars($_POST['id'], ENT_QUOTES);
		$description = htmlspecialchars($_POST['description'], ENT_QUOTES);
		try {
			$stmt = $conn->prepare("
				UPDATE
					wdv341_cms_content
				SET
					cms_content_title = ?,
					cms_content_content = ?,
					cms_content_description = ?
				WHERE
					cms_content_id = ?
				");
			$stmt->bindParam(1, $title);
			$stmt->bindParam(2, $body);
			$stmt->bindParam(3, $description);
			$stmt->bindParam(4, $id);

			$stmt->execute();

			$affectedRows = $stmt->rowCount();

			header('Location: ' . $url . "?contentid=" . $id, true);

			if ($affectedRows > 0) {
				header('Location: ' . $url . "?success=true&contentid=" . $id, true);
				exit();
			} else {
				header('Location: ' . $url . "?success=false&contentid=" . $id, true);
				exit();
			}
		}
		catch(PDOException $e) {
			$errorMsg = "Failed to update! " . $e;
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
				if ($result) {
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			?>
					<form name="updateContent" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<label>Title:
							<input type="text" name="title" value="<?php echo $row->cms_content_title; ?>">
						</label>
						<div>
							<textarea name="description" class="description"><?php echo $row->cms_content_description; ?></textarea>
							<textarea name="body"><?php echo $row->cms_content_content; ?></textarea>
							<input type="submit" name="updateSubmit" value="[Save Changes]" class="right">
						</div>
						<input type="text" name="id" value="<?php echo $row->cms_content_id; ?>" style="display: none">
					</form>
			<?php
				  	} 
				} else {
					echo "</table><p>Select failed!</p>";
				}
			?>

			<p>
				<?php
					if (isset($_GET['success'])) {
						$success = $_GET['success'] === "true";
						if ($success) {
							echo "Content updated!";
						} else {
							echo "Content not updated.";
						}
					}
				?>
				<p><?php echo $errorMsg; ?></p>
			</p>
		</main>
	</body>
</html>