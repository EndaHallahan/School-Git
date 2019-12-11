<?php
	session_start();
	include "pdoConnect.php";
	$loggedin = false;
	$errorMsg = "";
	$result = false;
	if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["validUser"])) {
		header('Location: ' . "admin.php", true, 303);
	} else {
		$username = "";
		$password = "";

		if(isset($_POST['loginSubmit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

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
					$stmtu = $conn->prepare("
						SELECT 
							cms_user_password
						FROM 
							wdv341_cms_users
						WHERE
							cms_user_name = ?
						LIMIT
							1
						");
					$stmtu->bindParam(1, $username);
					$resultu = $stmtu->execute();

					if ($resultu && $stmtu->rowCount() == 1) {
						$row = $stmtu->fetch(PDO::FETCH_OBJ);
						if (password_verify($_POST['password'], $row->cms_user_password)) {
							$_SESSION["validUser"] = true;
							$loggedin = true;
							header('Location: ' . "admin.php", true, 303);
						} else {
							$errorMsg = "Password is incorrect.";
						}
					} else {
						$errorMsg = "No user by that name.";
					}
				}
				catch(PDOException $e) {
			    	$errorMsg = "Error: " . $e->getMessage();
			    }
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
				<label>Username: 
					<input type="text" name="username" value="<?php echo $username; ?>">
				</label>
				<label>Password: 
					<input type="password" name="password" value="<?php echo $password; ?>">
				</label>
				<input type="submit" name="loginSubmit" value="[Submit]">
			</form>
			<p><?php echo $errorMsg ?></p>
		</main>	
	</body>
</html>