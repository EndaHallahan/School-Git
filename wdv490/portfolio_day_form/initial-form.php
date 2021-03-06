<?php
	session_start();

	include "connectPDO.php";

	$email = "";
	$password = "";
	$passkey = "";

	$formValid = true;
	$formError = "";

	// Register form submit POST
	if (isset($_POST['register_submit'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$inputPasskey = $_POST['passkey'];	

		include "ValidatorClass.php";
		$validator = new Validator;

		// Validations
		if (!$validator->notEmpty($inputPasskey) || !$validator->noSpecialChars($inputPasskey)) {
			$formValid = false;
			$formError = "Please enter a passkey.";
		}
		if (!$validator->notEmpty($email) 
				|| !$validator->isEmail($email)
				|| !$validator->isShorterThan($email, 50)
				|| !preg_match("/@dmacc.edu$/", $email)
			) {
			$formValid = false;
			$formError = "Please enter a valid DMACC email.";
		} 
		if (!$validator->notEmpty($password) 
				|| !$validator->noSpecialChars($password) 
				|| !$validator->isLongerThan($password, 6)
			) {
			$formValid = false;
			$formError = "Please enter a valid password. Passwords must be longer than six characters.";
		}

		// Required passkey ensures only people who are supposed to can make accounts (theoretically). Give out with URL.
		include "passkey.php";

		if ($formValid) {
			if ($passkey == $inputPasskey) {
				// Hash
				$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
				// Create user entry in database
				try {
					$stmt = $conn->prepare("
						INSERT INTO 
							student_info_2020 (student_email, student_password)
						VALUES
							(?, ?)
						");
					$stmt->bindParam(1, $email);
					$stmt->bindParam(2, $hash);
					$result = $stmt->execute();
				} catch(PDOException $err) {
					$formValid = false;
					if ($err->getCode() == "23000") {
						$formError = "A user with that email already exists.";
					} else {
						$formError = "Add failed: " . $err;
					}
				}

				// Initialize user session
				if ($formValid) {
					$_SESSION["validUser"] = true;
					$_SESSION["userEmail"] = $email;
					header('Location: ' . "student-info-form.php", true, 303);
				}
			} else {
				$formValid = false;
				$formError = "Invalid passkey.";
			}
		} 
		
		// Login submit POST
	} else if (isset($_POST['login_submit'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		include "ValidatorClass.php";
		$validator = new Validator;

		// Validations
		if (!$validator->notEmpty($email) 
				|| !$validator->isEmail($email)
				|| !$validator->isShorterThan($email, 50)
				|| !preg_match("/@dmacc.edu$/", $email)
			) {
			$formValid = false;
			$formError = "Please enter a valid DMACC email.";
		} 
		if (!$validator->notEmpty($password) 
				|| !$validator->noSpecialChars($password)
				|| !$validator->isLongerThan($password, 6)
			) {
			$formValid = false;
			$formError = "Please enter a valid password.";
		}

		if ($formValid) {
			// Check if user exists in database
			try {
				$stmtu = $conn->prepare("
					SELECT 
						student_password
					FROM 
						student_info_2020
					WHERE
						student_email = ?
					LIMIT
						1
					");
				$stmtu->bindParam(1, $email);
				$resultu = $stmtu->execute();

				if ($resultu && $stmtu->rowCount() == 1) {
					$row = $stmtu->fetch(PDO::FETCH_OBJ);
					// Check if password matches
					if (password_verify($password, $row->student_password)) {
						// Create user session, redirect to information form
						$_SESSION["validUser"] = true;
						$_SESSION["userEmail"] = $email;

						header('Location: ' . "student-info-form.php", true, 303);
					} else {
						$formError = "Password is incorrect.";
					}
				} else {
					$formError = "No user with that email.";
				}
			}
			catch(PDOException $e) {
		    	$formError = "Error: " . $e->getMessage();
		    }
		}
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Registration</title>
		<script src="v_.js"></script>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
		<section>
			<p class="info-display faliure"><?php echo $formError ?></p>
			<div>
				<h3>Log In</h3>
				<p>If you have already registered your credentials and want to make changes to your information, enter them in the form below.</p>
				<form name="login_form" data-v_form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<label>DMACC Email
						<input type="email" name="email" id="email" required data-v_length-less-than="50" data-v_is-email-with-domain="dmacc.edu">
					</label>
					<label>Password
						<input type="password" name="password" id="password" required data-v_length-greater-than="6">
					</label>
					<input type="submit" name="login_submit" id="login_submit" value="Submit">
				</form>
			</div>
			<div>
				<h3>Register</h3>
				<p>If you have not yet registered your credentials, do so in the form below. Use your DMACC email address. You will also need to provide your class passkey, which should have been given to you by your instructor.</p>
				<form name="create_entry_form" data-v_form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<label>DMACC Email
						<input type="email" name="email" required data-v_length-less-than="50" data-v_is-email-with-domain="dmacc.edu">
					</label>
					<label>Password
						<input type="password" name="password" required data-v_length-greater-than="6">
					</label>
					<label>Class Passkey
						<input type="text" name="passkey" id="passkey" required>
					</label>
					<input type="submit" name="register_submit" id="register_submit" value="Submit">
				</form>
			</div>
		</section>
	</body>
</html>