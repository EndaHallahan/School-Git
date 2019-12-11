<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";

	$errorMsg = "";
	$password = "";
	$username = "";
	if (isset($_POST['createSubmit'])) {
		$password = $_POST['password'];
		$username = $_POST['username'];
		include "ValidatorClass.php";
		$validator = new Validator;

		if (!$validator->notEmpty($username) || !$validator->noSpecialChars($username)) {
			$errorMsg = "Please enter a valid username.";
		} 

		if (!$validator->notEmpty($password) || !$validator->noSpecialChars($password)) {
			$errorMsg = "Please enter a valid password.";
		}

		if ($errorMsg == "") {
			try {
				$stmt = $conn->prepare("
					INSERT INTO 
						wdv341_cms_users (cms_user_name, cms_user_password)
					VALUES
						(?, ?)
					");
				$stmt->bindParam(1, $username);
				$hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10]);
				$stmt->bindParam(2, $hash);
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
			<form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="text" name="username" value="<?php echo $username; ?>">
				<input type="text" name="password" value="<?php echo $password; ?>">
				<input type="submit" name="createSubmit" value="Submit">
			</form>
			<p><?php echo $errorMsg ?></p>
		</main>
	</body>
</html>