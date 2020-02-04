<?php
	// Redirect
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "initial-form.php", true, 303);
	}

	include "connectPDO.php";

	$email = $_SESSION['userEmail'];
	$firstName = "";
	$lastName = "";
	$major = "";
	$portfolio = "";
	$linkedin = "";
	$secondary = "";
	$hometown = "";
	$careerGoals = "";
	$hobbies = "";
	$state = "";
	$minor = "";
	$image = "";

	$formValid = true;
	$formError = "";
	$updateSuccess = false;

	$imageDir = "student_images/";

	$result = false;

	// Fetch current values from database, if any
	try {
		$stmt = $conn->prepare("
			SELECT 
				student_first_name, 
				student_last_name,
				student_major,
				student_portfolio,
				student_linkedin,
				student_secondary,
				student_hometown,
				student_career_goals,
				student_hobbies,
				student_state,
				student_minor,
				student_image
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
		$major = $row->student_major;
		$portfolio = $row->student_portfolio;
		$linkedin = $row->student_linkedin;
		$secondary = $row->student_secondary;
		$hometown = $row->student_hometown;
		$state = $row->student_state;
		$careerGoals = $row->student_career_goals;
		$hobbies = $row->student_hobbies;
		$minor = $row->student_minor;
		$image = $row->student_image;
	}

	// Form submit POST
	if (isset($_POST['info_submit'])) {

		include "ValidatorClass.php";
		$validator = new Validator;

		//Validations
		if (isset($_POST['first-name']) && $validator->notEmpty($_POST['first-name'])) {
			$firstName = $_POST['first-name'];
			if (!$validator->noSpecialChars($firstName)) {
				$formValid = false;
				$formError = "Please enter a valid first name. Forbidden characters: &\"'<>";
			}
		}
		if (isset($_POST['last-name']) && $validator->notEmpty($_POST['last-name'])) {
			$lastName = $_POST['last-name'];
			if (!$validator->noSpecialChars($lastName)) {
				$formValid = false;
				$formError = "Please enter a valid last name. Forbidden characters: &\"'<>";
			}
		}
		if (isset($_POST['major']) && $validator->notEmpty($_POST['major'])) {
			$major = $_POST['major'];
		}
		if (isset($_POST['portfolio-link']) && $validator->notEmpty($_POST['portfolio-link'])) {
			$portfolio = $_POST['portfolio-link'];
			if (!$validator->isURL($portfolio)) {
				$formValid = false;
				$formError = "Please enter a valid link to your portfolio.";
			}
		}
		if (isset($_POST['linkedin-link']) && $validator->notEmpty($_POST['linkedin-link'])) {
			$linkedin = $_POST['linkedin-link'];
			if (!$validator->isURL($linkedin)) {
				$formValid = false;
				$formError = "Please enter a valid link to your LinkedIn account.";
			}
		}
		if (isset($_POST['secondary-link']) && $validator->notEmpty($_POST['secondary-link'])) {
			$secondary = $_POST['secondary-link'];
			if (!$validator->isURL($secondary)) {
				$formValid = false;
				$formError = "Please enter a valid link to your additional website.";
			}
		}
		if (isset($_POST['hometown']) && $validator->notEmpty($_POST['hometown'])) {
			$hometown = $_POST['hometown'];
			if (!$validator->noSpecialChars($hometown)) {
				$formValid = false;
				$formError = "Please enter a valid hometown. Forbidden characters: &\"'<>";
			}
		}
		if (isset($_POST['career-goals']) && $validator->notEmpty($_POST['career-goals'])) {
			$careerGoals = $_POST['career-goals'];
			if (!$validator->noSpecialChars($careerGoals)) {
				$formValid = false;
				$formError = "Please enter a valid career goal. Forbidden characters: &\"'<>";
			}
		}
		if (isset($_POST['hobbies']) && $validator->notEmpty($_POST['hobbies'])) {
			$hobbies = $_POST['hobbies'];
			if (!$validator->noSpecialChars($hobbies)) {
				$formValid = false;
				$formError = "Please enter a valid hobby. Forbidden characters: &\"'<>";
			}
		}
		if (isset($_POST['state']) && $validator->notEmpty($_POST['state'])) {
			$state = $_POST['state'];
			if (!$validator->noSpecialChars($state)) {
				$formValid = false;
				$formError = "Please enter a valid state. Forbidden characters: &\"'<>";
			}
		}
		if (isset($_POST['minor']) && $validator->notEmpty($_POST['minor'])) {
			$minor = $_POST['minor'];
			if (!$validator->noSpecialChars($minor)) {
				$formValid = false;
				$formError = "Please enter a valid minor. Forbidden characters: &\"'<>";
			}
		}
		if ($_FILES['image']['size'] != 0) {
			$fileName = uniqid() . "-" . $_FILES['image']['name'];
			$fileTmp = $_FILES['image']['tmp_name'];
			$fileSize = $_FILES['image']['size'];
      
		    if (!exif_imagetype($fileTmp)){
		       	$formValid = false;
				$formError = "Please upload a valid image file.";
		    }
		    if ($fileSize > 2097152 * 2){
		       	$formValid = false;
				$formError = "Images must be under 4MB.";
		    }

		    if ($formValid) {
		    	// Delete previous image if any
		    	if ($validator->notEmpty($image) && file_exists($imageDir . $image)) {
					if (!unlink($imageDir . $image)) {
						$formError = "Warning: failed to delete previous image.";
					}
				}
				// Save image to directory
		    	if (move_uploaded_file($fileTmp, $imageDir . $fileName)) {
		        	$image = $fileName;
			    } else {
			        $formValid = false;
					$formError = "There was an error uploading this image. Please try again.";
			    }
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
						student_major = ?,
						student_portfolio = ?,
						student_linkedin = ?,
						student_secondary = ?,
						student_hometown = ?,
						student_career_goals = ?,
						student_hobbies = ?,
						student_state = ?,
						student_minor = ?,
						student_image = ?
					WHERE
						student_email = ?
				");
				$stmt->bindParam(1, $firstName);
				$stmt->bindParam(2, $lastName);
				$stmt->bindParam(3, $major);
				$stmt->bindParam(4, $portfolio);
				$stmt->bindParam(5, $linkedin);
				$stmt->bindParam(6, $secondary);
				$stmt->bindParam(7, $hometown);
				$stmt->bindParam(8, $careerGoals);
				$stmt->bindParam(9, $hobbies);
				$stmt->bindParam(10, $state);
				$stmt->bindParam(11, $minor);
				$stmt->bindParam(12, $image);
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
	</head>
	<body>
		<section>
			<a href="logout.php">Log Out</a>
			<p class="errorOut"><?php echo $formError ?> <?php echo $updateSuccess ? "Your information has been updated." : "" ?></p>
			<form name="info_form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<label>First Name
					<input type="text" name="first-name" id="first-name" value="<?php echo $firstName ?>" required>
				</label>
				<label>Last Name
					<input type="text" name="last-name" id="last-name" value="<?php echo $lastName ?>" required>
				</label>

				<label>Email
					<input type="text" name="email" id="email" disabled value="<?php echo $email ?>">
				</label>

				<label>Portrait Photo
					<input type="file" accept="image/*" name="image" id="image">
				</label>
				<div class="photo-container">
					<img src="<?php echo $imageDir . $image ?>">
				</div>

				<label>Major
					<select name="major" id="major">
						<option value="graphic-design" <?php if ($major == "graphic-design") {echo "selected";} ?> >Graphic Design</option>
						<option value="photography" <?php if ($major == "photography") {echo "selected";} ?> >Photography</option>
						<option value="video-production" <?php if ($major == "video-production") {echo "selected";} ?> >Video Production</option>
						<option value="animation" <?php if ($major == "animation") {echo "selected";} ?> >Animation</option>
						<option value="web-dev" <?php if ($major == "web-dev") {echo "selected";} ?> >Web Development</option>
					</select>
				</label>
				<label>Minor
					<input type="text" name="minor" id="minor" value="<?php echo $minor ?>">
				</label>

				<label>Portfolio Website
					<input type="text" name="portfolio-link" id="portfolio-link" value="<?php echo $portfolio ?>">
				</label>
				<label>LinkedIn
					<input type="text" name="linkedin-link" id="linkedin-link" value="<?php echo $linkedin ?>">
				</label>
				<label>Additional Website (optional)
					<input type="text" name="secondary-link" id="secondary-link" value="<?php echo $secondary ?>">
				</label>

				<label>Hometown
					<input type="text" name="hometown" id="hometown" value="<?php echo $hometown ?>">
				</label>
				<label>State
					<input type="text" name="state" id="state" value="<?php echo $state ?>">
				</label>

				<label>Career Goals
					<textarea name="career-goals" id="career-goals"><?php echo $careerGoals ?></textarea>
				</label>
				<label>Hobbies
					<textarea name="hobbies" id="hobbies"><?php echo $hobbies ?></textarea>
				</label>

				<input type="submit" name="info_submit" id="info_submit" value="Submit">
			</form>
		</section>
	</body>
</html>