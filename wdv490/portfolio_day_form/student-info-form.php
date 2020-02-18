<?php
	// Redirect
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "initial-form.php", true, 303);
	}

	include "connectPDO.php";

	$email = $_SESSION['userEmail'];
	$publicEmail = "";
	$firstName = "";
	$lastName = "";
	$program = "";
	$portfolio = "";
	$linkedin = "";
	$secondary = "";
	$hometown = "";
	$careerGoals = "";
	$hobbies = "";
	$state = "";
	$emphasis = "";

	$formValid = true;
	$formError = "";
	$updateSuccess = false;

	$result = false;

	// Fetch current values from database, if any
	try {
		$stmt = $conn->prepare("
			SELECT 
				student_first_name, 
				student_last_name,
				student_program,
				student_portfolio,
				student_linkedin,
				student_secondary,
				student_hometown,
				student_career_goals,
				student_hobbies,
				student_state,
				student_emphasis,
				student_public_email
			FROM
				student_info_2020
			WHERE
				student_email = ?
			");
		$stmt->bindParam(1, $email);
		$result = $stmt->execute();
	} catch(PDOException $err) {
		$formError = "Select failed: " . $err;
	}

	if ($result && $stmt->rowCount() == 1) {
		$row = $stmt->fetch(PDO::FETCH_OBJ);

		$firstName = $row->student_first_name;
		$lastName = $row->student_last_name;
		$program = $row->student_program;
		$portfolio = $row->student_portfolio;
		$linkedin = $row->student_linkedin;
		$secondary = $row->student_secondary;
		$hometown = $row->student_hometown;
		$state = $row->student_state;
		$careerGoals = $row->student_career_goals;
		$hobbies = $row->student_hobbies;
		$emphasis = $row->student_emphasis;
		$publicEmail = $row->student_public_email;
	}

	// Form submit POST
	if (isset($_POST['info_submit'])) {

		include "ValidatorClass.php";
		$validator = new Validator;

		//Validations
		if (isset($_POST['first-name']) && $validator->notEmpty($_POST['first-name'])) {
			$firstName = $_POST['first-name'];
			if (!$validator->noSpecialChars($firstName) || !$validator->isShorterThan($firstName, 50)) {
				$formValid = false;
				$formError = "Please enter a valid first name. Forbidden characters: &<>";
			}
		}
		if (isset($_POST['last-name']) && $validator->notEmpty($_POST['last-name'])) {
			$lastName = $_POST['last-name'];
			if (!$validator->noSpecialChars($lastName) || !$validator->isShorterThan($lastName, 50)) {
				$formValid = false;
				$formError = "Please enter a valid last name. Forbidden characters: &<>";
			}
		}
		if (isset($_POST['program']) && $validator->notEmpty($_POST['program'])) {
			$program = $_POST['program'];
		}
		if (isset($_POST['portfolio-link']) && $validator->notEmpty($_POST['portfolio-link'])) {
			$portfolio = $_POST['portfolio-link'];
			if (!$validator->isURL($portfolio) || !$validator->isShorterThan($portfolio, 50)) {
				$formValid = false;
				$formError = "Please enter a valid link to your portfolio.";
			}
		}
		if (isset($_POST['linkedin-link']) && $validator->notEmpty($_POST['linkedin-link'])) {
			$linkedin = $_POST['linkedin-link'];
			if (!$validator->isURL($linkedin) || !$validator->isShorterThan($portfolio, 50)) {
				$formValid = false;
				$formError = "Please enter a valid link to your LinkedIn account.";
			}
		}
		if (isset($_POST['secondary-link']) && $validator->notEmpty($_POST['secondary-link'])) {
			$secondary = $_POST['secondary-link'];
			if (!$validator->isURL($secondary) || !$validator->isShorterThan($secondary, 50)) {
				$formValid = false;
				$formError = "Please enter a valid link to your additional website.";
			}
		}
		if (isset($_POST['hometown']) && $validator->notEmpty($_POST['hometown'])) {
			$hometown = $_POST['hometown'];
			if (!$validator->noSpecialChars($hometown) || !$validator->isShorterThan($hometown, 50)) {
				$formValid = false;
				$formError = "Please enter a valid hometown. Forbidden characters: &<>";
			}
		}
		if (isset($_POST['career-goals']) && $validator->notEmpty($_POST['career-goals'])) {
			$careerGoals = $_POST['career-goals'];
			if (!$validator->noSpecialChars($careerGoals) || !$validator->isShorterThan($careerGoals, 255)) {
				$formValid = false;
				$formError = "Please enter a valid career goal. Forbidden characters: &<>";
			}
		}
		if (isset($_POST['hobbies']) && $validator->notEmpty($_POST['hobbies'])) {
			$hobbies = $_POST['hobbies'];
			if (!$validator->noSpecialChars($hobbies) || !$validator->isShorterThan($hobbies, 255)) {
				$formValid = false;
				$formError = "Please enter a valid hobby. Forbidden characters: &<>";
			}
		}
		if (isset($_POST['state']) && $validator->notEmpty($_POST['state'])) {
			$state = $_POST['state'];
		}
		if (isset($_POST['emphasis']) && $validator->notEmpty($_POST['emphasis'])) {
			$emphasis = $_POST['emphasis'];
			if (!$validator->noSpecialChars($emphasis) || !$validator->isShorterThan($emphasis, 50)) {
				$formValid = false;
				$formError = "Please enter a valid emphasis. Forbidden characters: &<>";
			}
		}
		if (isset($_POST['public-email']) && $validator->notEmpty($_POST['public-email'])) {
			$publicEmail = $_POST['public-email'];
			if (!$validator->noSpecialChars($publicEmail) 
					|| !$validator->isShorterThan($publicEmail, 50)
					|| !$validator->isEmail($publicEmail)
				) {
				$formValid = false;
				$formError = "Please enter a valid public email address.";
			}
		}

		// Update record in database
		if ($formValid) {
			try {
				$stmt = $conn->prepare("
					UPDATE 
						student_info_2020
					SET
						student_first_name = ?,
						student_last_name = ?,
						student_program = ?,
						student_portfolio = ?,
						student_linkedin = ?,
						student_secondary = ?,
						student_hometown = ?,
						student_career_goals = ?,
						student_hobbies = ?,
						student_state = ?,
						student_emphasis = ?,
						student_public_email = ?
					WHERE
						student_email = ?
				");
				$stmt->bindParam(1, $firstName);
				$stmt->bindParam(2, $lastName);
				$stmt->bindParam(3, $program);
				$stmt->bindParam(4, $portfolio);
				$stmt->bindParam(5, $linkedin);
				$stmt->bindParam(6, $secondary);
				$stmt->bindParam(7, $hometown);
				$stmt->bindParam(8, $careerGoals);
				$stmt->bindParam(9, $hobbies);
				$stmt->bindParam(10, $state);
				$stmt->bindParam(11, $emphasis);
				$stmt->bindParam(12, $publicEmail);
				$stmt->bindParam(13, $email);
				$result = $stmt->execute();

				$updateSuccess = true;
			} catch(PDOException $err) {
				$formValid = false;
				$formError = "SQL error: " . $err;
			}
		}	
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Student Information Form</title>
		<link rel="stylesheet" href="style.css" type="text/css">
		<script src="scripts.js"></script>
	</head>
	<body>
		<section>
			<a href="logout.php">Log Out</a>
			<p class="info-display <?php echo $updateSuccess ? "success" : "faliure" ?>"><?php echo $formError ?><?php echo $updateSuccess ? "Your information has been updated." : "" ?></p>
			<form name="info_form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<label class="required">First Name
					<input type="text" name="first-name" id="first-name" value="<?php echo $firstName ?>" required data-v_length-lt="50">
				</label>
				<label class="required">Last Name
					<input type="text" name="last-name" id="last-name" value="<?php echo $lastName ?>" required data-v_length-lt="50">
				</label>

				<label class="required">Program
					<select name="program" id="program" required>
						<option value="">--Select a Program--</option>
						<option value="graphic-design" <?php if ($program == "graphic-design") {echo "selected";} ?> >Graphic Design</option>
						<option value="photography" <?php if ($program == "photography") {echo "selected";} ?> >Photography</option>
						<option value="video-production" <?php if ($program == "video-production") {echo "selected";} ?> >Video Production</option>
						<option value="animation" <?php if ($program == "animation") {echo "selected";} ?> >Animation</option>
						<option value="web-dev" <?php if ($program == "web-dev") {echo "selected";} ?> >Web Development</option>
					</select>
				</label>
				<label>Area of emphasis, or secondary program
					<input type="text" name="emphasis" id="emphasis" value="<?php echo $emphasis ?>" data-v_length-lt="50">
				</label>

				<label>DMACC Email
					<input type="email" name="email" id="email" disabled value="<?php echo $email ?>">
				</label>
				<label>Public email (will be displayed publically on the website)
					<input type="email" name="public-email" id="public-email" value="<?php echo $publicEmail ?>" data-v_length-lt="50" data-v_isEmail>
				</label>

				<label>Portfolio Website
					<input type="text" name="portfolio-link" id="portfolio-link" value="<?php echo $portfolio ?>" data-v_length-lt="50" data-v_is-url>
				</label>
				<label>LinkedIn
					<input type="text" name="linkedin-link" id="linkedin-link" value="<?php echo $linkedin ?>" data-v_length-lt="50" data-v_is-url data-v_is-linkedin>
				</label>
				<label>Additional Website
					<input type="text" name="secondary-link" id="secondary-link" value="<?php echo $secondary ?>" data-v_length-lt="50" data-v_is-url>
				</label>

				<label>Hometown
					<input type="text" name="hometown" id="hometown" value="<?php echo $hometown ?>" data-v_length-lt="50">
				</label>
				<label>State
					<select name="state" id="state">
						<?php 
							$states = array("IA", "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC",  
										    "DE", "FL", "GA", "HI", "ID", "IL", "IN", "KS", "KY", "LA",  
										    "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE",  
										    "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI", "SC",  
										    "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY");
							forEach ($states as $value) { 
						?>
							<option value="<?php echo $value;?>" <?php echo ($state == $value) ? " selected='selected'" : "";?>><?php echo $value;?></option>
						<?php
							}
						?>
					</select>
				</label>

				<label data-v_char-counter>Career Goals
					<textarea name="career-goals" id="career-goals" maxlength="255"><?php echo $careerGoals ?></textarea>
				</label>
				<label data-v_char-counter>Hobbies
					<textarea name="hobbies" id="hobbies" maxlength="255"><?php echo $hobbies ?></textarea>
				</label>

				<label class="required">Required</label>
				<input type="submit" name="info_submit" id="info_submit" value="Submit">
			</form>
		</section>
	</body>
</html>