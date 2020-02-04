<?php 
	session_start();
	session_unset();
	session_destroy();
	header('Location: ' . "initial-form.php", true, 303);
?>