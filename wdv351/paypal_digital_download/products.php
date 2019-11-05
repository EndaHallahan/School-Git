<?php
	session_start();
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Products</title>
		<!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
	</head>
	<body>
		<h1>Products</h1>
		<br>
		<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="8TAN27WJD4TZJ">
		<input type="hidden" name="custom" value="<?php echo session_id(); ?>">
		<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</body>
</html>