<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";
	$errorMsg = "";

	$title = "";
	$body = "";
	$date = "";
	$description = "";
	if (isset($_POST['createSubmit'])) {
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
		$body = htmlspecialchars($_POST['body'], ENT_QUOTES);
		$description = htmlspecialchars($_POST['description'], ENT_QUOTES);
		include "ValidatorClass.php";
		$validator = new Validator;

		if (!$validator->notEmpty($title)) {
			$errorMsg = "Please enter a valid post title.";
		} 

		if (!$validator->notEmpty($body)) {
			$errorMsg = "Please enter a valid post body.";
		}

		if (!$validator->notEmpty($description)) {
			$errorMsg = "Please enter a valid description.";
		}

		if ($errorMsg == "") {
			$now = time();
			try {
				$stmt = $conn->prepare("
					INSERT INTO 
						wdv341_cms_content (cms_content_title, cms_content_content, cms_content_date, cms_content_description)
					VALUES
						(?, ?, ?, ?)
					");
				$stmt->bindParam(1, $title);
				$stmt->bindParam(2, $body);
				$stmt->bindParam(3, $now);
				$stmt->bindParam(4, $description);
				$result = $stmt->execute();
				
				header('Location: ' . "admin.php", true, 303);
			} catch(PDOException $err) {
				$errorMsg = "Add failed: " . $err;
			}
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
			<form name="createContent" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<label>Title: 
					<input type="text" name="title" value="<?php echo $title; ?>">
				</label>
				<div>
					<textarea name="description" class="description" placeholder="Description"><?php echo $description; ?></textarea>
					<textarea name="body" placeholder="Main Content"><?php echo $body; ?></textarea>
					<input type="submit" name="createSubmit" value="[Submit]" class="right">
				</div>
			</form>
			<p><?php echo $errorMsg ?></p>
		</main>
	</body>
</html>