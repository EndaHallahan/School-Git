<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Argabarga</title>
<link rel="stylesheet" href="themes/style.css" type="text/css">
<?php
if(isset($_COOKIE['theme'])) { 
     echo '<link rel="stylesheet" id="theme" href="themes/' . $_COOKIE['theme'] . '-style.css" type="text/css">'; 
} else { 
     echo '<link rel="stylesheet" id="theme" href="themes/dark-style.css" type="text/css">'; 
} 
?>
<link rel="icon" type="image/png" sizes="16x16" href="http://www.ed.argabarga.org/favicon-16x16.png">
<script src="script.js" defer></script>