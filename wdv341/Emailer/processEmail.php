<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Untitled</title>

		<?php 
			include 'Emailer.php';
			$emailer = new Emailer();
		?>

	</head>
	<body>
		<form method="post" action= "processEmail.php">
			<span for="from">From:</span><br>
			<input type="text" name="from">
			<br><br>
			<span>To:</span><br>
			<input type="text" name="to">
			<br><br>
			<span>Subject:</span><br>
			<input type="text" name="subject">
			<br><br>
			<span>Message:</span> <br>
			<textarea rows="10" cols="70" name="message"></textarea>
			<br><br>
			<input type="submit">
		</form>

		<?php
            if($_SERVER['REQUEST_METHOD']=='POST') {	
           		$emailer->setSenderAddress($_POST["from"]);
           		$emailer->setRecieverAddress($_POST["to"]);
           		$emailer->setSubject($_POST["subject"]);
           		$emailer->setMessage($_POST["message"]);

           		echo $emailer->getSenderAddress() . "<br>";
           		echo $emailer->getRecieverAddress() . "<br>";
           		echo $emailer->getSubject() . "<br>";
           		echo $emailer->getMessage() . "<br>";

              	if ($emailer->sendEmail()) {
              		echo "Message sent!";
              	} else {
              		echo "Message failed to send!";
              	}
            } 
        ?>
	</body>
</html>