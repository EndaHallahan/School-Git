<?php

session_start();

$purchase_verified = false;

$sess = session_id();

try {

	$host_name = 'db754471969.db.1and1.com';
	$database = 'db754471969';
	$user_name = 'dbo754471969';
	$password = "UnimportantTestPass123!";

    $conn = new PDO("mysql:host=$host_name;dbname=$database", $user_name, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $conn->prepare("SELECT session_id, transaction_id FROM transactions WHERE session_id = '$sess'");
	$sql->execute();
	if ($sql->rowCount() > 0) {
    	$purchase_verified = true;
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;

?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Delivery</title>
		<!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
	</head>
	<body>
		<h1>Your Products:</h1>
		<p>(If nothing shows up at first, wait a minute and refresh the page)</p>
		<?php if($purchase_verified) : ?>
			<ul>
				<li><a href="content.docx" download>Content.docx</a></li>
				<li><a href="content.pdf" download>Content.pdf</a></li>
				<li><a href="content.png" download>Content.png</a></li>
				<li><a href="content.zip" download>Content.zip</a></li>
				<li><a href="rocket-power-by-kevin-macleod" download>Catchy song</a></li>
			</ul>  
		<?php endif; ?>
		<br>
		<a href="http://www.ed.argabarga.org/wdv351/paypal_digital_download/products.php">Home</a>
	</body>
</html>