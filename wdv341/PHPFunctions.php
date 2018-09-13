<?php 
	function dateFormatAmerican($inDate) {
		return date("m/d/Y", $inDate);
	}
	function dateFormatLiterallyEverywhereElse($inDate) {
		return date("m/d/Y", $inDate);
	}
	function stringFun($inString) {
		echo strlen($inString) . " | ";
		$inString = trim($inString);
		$lowercaseStr = strtolower($inString);
		echo $lowercaseStr . " | ";
		if (substr_count($lowercaseStr, "dmacc") > 0) {
			echo "String contains DMACC!";
		} else {
			echo "String does not contain DMACC!";
		}
	}
	function displayFormatNumber($inNum) {
		echo number_format($inNum);
	}
	function displayFormatCurrency($inNum) {
		setlocale(LC_MONETARY,"en_US");
		echo money_format("%n", $inNum);
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PHP Functions</title>
	</head>
	<body>
		<p>Current American date: <?php echo dateFormatAmerican(time())?></p>
		<p>Current Non-American date: <?php echo dateFormatLiterallyEverywhereElse(time())?></p>
		<p>String: "Secrets in a code.": <?php stringFun("Secrets in a code.")?></p>
		<p>String: "Secrets in a DMACC": <?php stringFun("Secrets in a DMACC.")?></p>
		<p>String: "Secrets in a dmacc.": <?php stringFun("Secrets in a dmacc.")?></p>
		<p><?php displayFormatNumber(1234567890)?></p>
		<p><?php displayFormatCurrency(123456)?></p>
	</body>
</html>