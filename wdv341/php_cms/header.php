<?php
	if (session_status() != PHP_SESSION_ACTIVE) {
		session_start();
	}

	$loggedin = false;

	if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["validUser"])) {
		$loggedin = true;
	}
?>

<header>
	<h1><a href="index.php">Argabarga</a></h1>
</header>
<hr>
<nav>
	<ul class= "nav">
		<li class="right"><a href="#" onclick="setTheme()">Theme</a></li>
		<li><a href="contact.php">Contact</a></li>
		<?php
			if ($loggedin) {
		?>
			<li><a href="admin.php">Admin</a></li>
			<li class="right"><a href="logout.php">Log Out</a></li>
		<?php
			} else {
		?>
			<li class="right"><a href="login.php">Log In</a></li>
		<?php
			}
		?>
	</ul>
</nav>
<br>
<hr>