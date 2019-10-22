<?php 
	include "ValidatorClass.php";
	$validator = new Validator;
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Validator Tester</title>
	</head>
	<body>
		<h3>notEmpty</h3>
		<p>"": <?php echo $validator->notEmpty("") ? "Failed" : "Passing" ?></p>
		<p>" ": <?php echo $validator->notEmpty(" ") ? "Failed" : "Passing" ?></p>
		<p>"a": <?php echo $validator->notEmpty("a") ? "Passing" : "Failed" ?></p>
		<p>"null": <?php echo $validator->notEmpty("null") ? "Passing" : "Failed" ?></p>

		<h3>isNumeric</h3>
		<p>"": <?php echo $validator->isNumeric("") ? "Failed" : "Passing" ?></p>
		<p>" ": <?php echo $validator->isNumeric(" ") ? "Failed" : "Passing" ?></p>
		<p>"a": <?php echo $validator->isNumeric("a") ? "Failed" : "Passing" ?></p>
		<p>"null": <?php echo $validator->isNumeric("null") ? "Failed" : "Passing" ?></p>
		<p>"1,000": <?php echo $validator->isNumeric("1,000") ? "Failed" : "Passing" ?></p>
		<p>"1000": <?php echo $validator->isNumeric("100") ? "Passing" : "Failed" ?></p>
		<p>"0": <?php echo $validator->isNumeric("100") ? "Passing" : "Failed" ?></p>	

		<h3>isLessThanCharacters</h3>
		<p>" ", 0: <?php echo $validator->isLessThanCharacters(" ", 0) ? "Failed" : "Passing" ?></p>
		<p>"alphabets", 8: <?php echo $validator->isLessThanCharacters("alphabets", 8) ? "Failed" : "Passing" ?></p>
		<p>"alphabet", 8: <?php echo $validator->isLessThanCharacters("alphabet", 8) ? "Passing" : "Failed" ?></p>
		<p>"", 0: <?php echo $validator->isLessThanCharacters("", 0) ? "Passing" : "Failed" ?></p>
		<p>"", 8: <?php echo $validator->isLessThanCharacters("", 8) ? "Passing" : "Failed" ?></p>
		<p>" ", 8: <?php echo $validator->isLessThanCharacters(" ", 8) ? "Passing" : "Failed" ?></p>
		<p>"a", 8: <?php echo $validator->isLessThanCharacters("a", 8) ? "Passing" : "Failed" ?></p>

		<h3>noSpecialChars</h3>
		<p>"": <?php echo $validator->noSpecialChars("") ? "Passing" : "Failed" ?></p>
		<p>" ": <?php echo $validator->noSpecialChars(" ") ? "Passing" : "Failed" ?></p>
		<p>"alphabet": <?php echo $validator->noSpecialChars("alphabet") ? "Passing" : "Failed" ?></p>
		<p>"<": <?php echo $validator->noSpecialChars("<") ? "Failed" : "Passing" ?></p>
		<p>">": <?php echo $validator->noSpecialChars(">") ? "Failed" : "Passing" ?></p>
		<p>""": <?php echo $validator->noSpecialChars("\"") ? "Failed" : "Passing" ?></p>
		<p>"'": <?php echo $validator->noSpecialChars("'") ? "Failed" : "Passing" ?></p>
		<p>"&": <?php echo $validator->noSpecialChars("&") ? "Failed" : "Passing" ?></p>

		<h3>isPhone</h3>
		<p>"": <?php echo $validator->isPhone("") ? "Failed" : "Passing" ?></p>
		<p>" ": <?php echo $validator->isPhone(" ") ? "Failed" : "Passing" ?></p>
		<p>"1": <?php echo $validator->isPhone("1") ? "Failed" : "Passing" ?></p>
		<p>"100": <?php echo $validator->isPhone("100") ? "Failed" : "Passing" ?></p>
		<p>"12345678901": <?php echo $validator->isPhone("12345678901") ? "Failed" : "Passing" ?></p>
		<p>"123-456-7890": <?php echo $validator->isPhone("123-456-7890") ? "Failed" : "Passing" ?></p>
		<p>"(123) 456 7890": <?php echo $validator->isPhone("123-456-7890") ? "Failed" : "Passing" ?></p>
		<p>"1234567890": <?php echo $validator->isPhone("1234567890") ? "Passing" : "Failed" ?></p>

		<h3>isPhone</h3>
		<p>"": <?php echo $validator->isEmail("") ? "Failed" : "Passing" ?></p>
		<p>" ": <?php echo $validator->isEmail(" ") ? "Failed" : "Passing" ?></p>
		<p>"alphabet": <?php echo $validator->isEmail("alphabet") ? "Failed" : "Passing" ?></p>
		<p>"alphabet.com": <?php echo $validator->isEmail("alphabet.com") ? "Failed" : "Passing" ?></p>
		<p>"alphabet@com": <?php echo $validator->isEmail("alphabet@com") ? "Failed" : "Passing" ?></p>
		<p>"alphabet@mail.com": <?php echo $validator->isEmail("alphabet@mail.com") ? "Passing" : "Failed" ?></p>
		<p>"alpha.bet@mail.com": <?php echo $validator->isEmail("alpha.bet@mail.com") ? "Passing" : "Failed" ?></p>

	</body>
</html>