<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP - Self Posting Form</title>
<style>

#orderArea	{
	width:600px;
	border:thin solid black;
	margin: auto auto;
	padding-left: 20px;
}

#orderArea h3	{
	text-align:center;	
}
.error	{
	color:red;
	font-style:italic;	
}

</style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Unit-5 and Unit-6 Self Posting - Form Validation Assignment


</h2>
<p>&nbsp;</p>


<div id="orderArea">
<form name="form3" method="post" action="customerRegistrationForm.php">
  <h3>Customer Registration Form</h3>

      <p>
        <label for="cust_name">Name:</label>
        <input type="text" name="cust_name" id="textfield" value="<?php if (isset($_POST['cust_name'])) {echo $_POST['cust_name'];} ?>">
      </p>
      <p>
        <label for="cust_phone">Phone Number:</label>
        <input type="text" name="cust_phone" id="textfield2" value="<?php if (isset($_POST['cust_phone'])) {echo $_POST['cust_phone'];} ?>">
      </p>
      <p>
        <label for="cust_email">Email Address: </label>
        <input type="text" name="cust_email" id="textfield3"value="<?php if (isset($_POST['cust_email'])) {echo $_POST['cust_email'];} ?>">
      </p>
      <p>
        <label for="cust_reg">Registration: </label>
        <select name="cust_reg" id="select">
          <option value="">Choose Type</option>
          <option value="evt01" <?php if (isset($_POST['cust_reg']) && $_POST['cust_reg'] == "evt01") {echo "selected";} ?>>Attendee</option>
          <option value="evt02" <?php if (isset($_POST['cust_reg']) && $_POST['cust_reg'] == "evt02") {echo "selected";} ?>>Presenter</option>
          <option value="evt03" <?php if (isset($_POST['cust_reg']) && $_POST['cust_reg'] == "evt03") {echo "selected";} ?>>Volunteer</option>
          <option value="evt04" <?php if (isset($_POST['cust_reg']) && $_POST['cust_reg'] == "evt04") {echo "selected";} ?>>Guest</option>
        </select>
      </p>
      <p>Badge Holder:</p>
      <p>
        <input type="radio" name="badge_type" id="radio" value="clip" <?php if (isset($_POST['badge_type']) && $_POST['badge_type'] == "clip") {echo "checked";} ?>>
        <label for="radio1">Clip</label> <br>
        <input type="radio" name="badge_type" id="radio2" value="lanyard" <?php if (isset($_POST['badge_type']) && $_POST['badge_type'] == "lanyard") {echo "checked";} ?>>
        <label for="radio2">Lanyard</label> <br>
        <input type="radio" name="badge_type" id="radio3" value="magnet" <?php if (isset($_POST['badge_type']) && $_POST['badge_type'] == "magnet") {echo "checked";} ?>>
        <label for="radio3">Magnet</label>
      </p>
      <p>Provided Meals (Select all that apply):</p>
      <p>
        <input type="checkbox" name="fri_dinner" id="checkbox" <?php if (isset($_POST['fri_dinner'])) {echo "checked";} ?>>
        <label for="fri_dinner">Friday Dinner</label><br>
        <input type="checkbox" name="sat_lunch" id="checkbox2" <?php if (isset($_POST['sat_lunch'])) {echo "checked";} ?>>
        <label for="sat_lunch">Saturday Lunch</label><br>
        <input type="checkbox" name="sun_brunch" id="checkbox3" <?php if (isset($_POST['sun_brunch'])) {echo "checked";} ?>>
        <label for="sun_brunch">Sunday Award Brunch</label>
      </p>
      <p>
        <label for="cust_req">Special Requests/Requirements: (Limit 200 characters)<br>
        </label>
        <textarea name="cust_req" cols="40" rows="5" id="textarea"><?php if (isset($_POST['cust_req'])) {echo $_POST['cust_req'];} ?></textarea>
      </p>
   
  <p>
    <input type="submit" name="submit" id="button3" value="Submit">
    <input type="reset">
    <input type="checkbox" name="honey" id="checkbox" style="display:none;">
  </p>
  <p>
  	<?php 
		if (isset($_POST["submit"])){
			if (!isset($_POST["honey"])){
				echo "Form submitted successfully!";
			} else {
				echo "Form failed!";
			}
		}
	?>
  </p>
</form>
</div>

</body>
</html>