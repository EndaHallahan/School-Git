<?php
	session_start();
	$errorMsg = "";
	$email = "";

	if (isset($_POST['sendSubmit'])) {
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		include "ValidatorClass.php";
		$validator = new Validator;

		if (!$validator->notEmpty($email)) {
			$errorMsg = "Please enter an email.";
		} 

		if (!$validator->isEmail($email)) {
			$errorMsg = "Please enter a valid email address.";
		}

		if ($errorMsg == "") {
			include 'EmailerClass.php';
			$emailer = new Emailer();

			$subj = "Argabarga Confirmation";
			$msg = "Confirmation email sent from Argabarga.com!";

			$emailer->setSenderAddress("xxx");
       		$emailer->setRecieverAddress($_POST["email"]);
       		$emailer->setSubject($subj);
       		$emailer->setMessage($msg);

          	if ($emailer->sendEmail()) {
          		echo "Message sent!";
          	} else {
          		echo "Message failed to send!";
          		echo error_get_last()['message'];
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
			<form name="sendConfirmation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<label>Your Email Address: 
					<input type="email" name="email" value="<?php echo $email; ?>">
				</label>
				<div>
					<input type="submit" name="sendSubmit" value="[Send Confirmation]">
				</div>
			</form>
			<p><?php echo $errorMsg ?></p>
		</main>
	</body>
</html>