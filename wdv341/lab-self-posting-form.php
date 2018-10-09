<?php

	//BEGIN FORM VALIDATION
	
	$valid_form = true;		

  $lab_name = "";
  $lab_email = "";
  $lab_username = "";
  $name_errMsg = "";
  $email_errMsg = "";
  $message = "";

  if(isset($_POST["button"])) {
    $lab_name = $_POST["lab_name"];
    $lab_email = $_POST["lab_email"];
    $lab_username = $_POST["lab_username"];

    //validate name - Cannot be empty
    if(empty($lab_name)) {
      $name_errMsg = "Please enter a name";
      $valid_form = false;
    }

    //validate email using PHP filter
    if(!filter_var($lab_email, FILTER_VALIDATE_EMAIL)) {
      $email_errMsg = "Invalid email";
      $valid_form = false;  
    }

    //Honeypot
    if(!empty($lab_username)) {
      $valid_form = false; 
    }

    if($valid_form) {
      $message = "Success!";
    } else {
      $message = "Failed!";
    }
  }	
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WDV341 Intro PHP</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Unit-7 and Unit-8 Form Validations and Self Posting Forms.</h2>
<h3>In Class Lab - Self Posting Form</h3>
<p><strong>Instructions:</strong></p>
<ol>
  <li>Modify this page as needed to convert it into a PHP self posting form.</li>
  <li>Use the validations provided on the page for the server side validation. You do NOT need to code any validations.</li>
  <li>Modify the page as needed to display any input errors.</li>
  <li>Include some form of form protection.</li>
  <li>You do NOT need to do any database work with this form. </li>
</ol>
<p>When complete:</p>
<ol>
  <li>Post a copy on your host account.</li>
  <li>Push a copy to your repo.</li>
  <li>Submit the assignment on Blackboard. Include a link to your page and to your repo.</li>
</ol>
<form name="form1" method="post" action="lab-self-posting-form.php">
  <p>
    <label for="lab_name">Name:</label>
    <input type="text" name="lab_name" id="lab_name">
    <span style="color:red;"> <?php echo $name_errMsg; ?> </span>
  </p>
  <p>
    <label for="lab_email">Email:</label>
    <input type="text" name="lab_email" id="lab_email">
    <span style="color:red;"> <?php echo $email_errMsg; ?> </span>
  </p>
  <p> 
    <input type="text" name="lab_username" id="lab_username" style="display:none;">
  </p>
  <p>
    <input type="submit" name="button" id="button" value="Submit">
    <input type="reset" name="button2" id="button2" value="Clear">
  </p>
  <p> <?php echo $message; ?> </p>
</form>
<p>&nbsp;</p>
</body>
</html>
