<?php
	$yourName = "Enda Hallahan";
	$number1 = 5;
	$number2 = 17;
	$total = $number1 + $number2;
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php echo "<script> const testArray = ['PHP', 'HTML', 'Javascript'];</script>" ?>
		<script>
			function displayArray(inArray, outId) {
				const outElement = document.getElementById(outId);
				inArray.forEach(item => {
					outElement.insertAdjacentHTML("beforeEnd", item + "<br>");
				});
			}

			window.addEventListener("load", () => displayArray(testArray,"testDisplay"));
		</script>
	</head>
	<body>
		<?php echo "<h1>$yourName</h1>" ?>
		<h2><?php echo "$yourName"?></h2>
		<p>
			<?php echo "$number1 + $number2 = $total"; ?>
		</p>
		<p id="testDisplay"></p>
	</body>
</html>