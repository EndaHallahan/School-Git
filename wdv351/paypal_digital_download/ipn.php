<?php

try {

	$host_name = 'db754471969.db.1and1.com';
	$database = 'db754471969';
	$user_name = 'dbo754471969';
	$password = "UnimportantTestPass123!";

    $conn = new PDO("mysql:host=$host_name;dbname=$database", $user_name, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

    $txn_id = $_POST['txn_id'];
    $sess = $_POST['custom'];

	$sql = "INSERT INTO transactions (transaction_id, session_id, purchased)
    VALUES ('$txn_id', '$sess', '1')";

    $conn->exec($sql);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
