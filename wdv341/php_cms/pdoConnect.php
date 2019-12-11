<?php
$host_name = 'xxx';
$database = 'xxx';
$user_name = 'xxx';
$password = "xxx";

try {
    $conn = new PDO("mysql:host=$host_name;dbname=$database", $user_name, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    error_log("Could not connect to database! Error: " . $e->getMessage(), 0);
     error_log("Could not connect to database! Error: " . $e->getMessage(), 1, "xxx");
    }
?>