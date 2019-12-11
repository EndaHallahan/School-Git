<?php
	session_start();
	if (!session_status() == PHP_SESSION_ACTIVE || !isset($_SESSION["validUser"])) {
		header('Location: ' . "login.php", true, 303);
	}

	include "pdoConnect.php";
	$result = false;
	try {
		$stmt = $conn->prepare("
			SELECT 
				cms_content_id,
				cms_content_title,
				cms_content_date
			FROM 
				wdv341_cms_content
			");
		$result = $stmt->execute();
	} catch(PDOException $e) {
    	$errorMsg = "Error: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<?php include "head.php" ?>
	</head>
	<body>
		<?php include "header.php" ?>
		<main>
			<div><a href="insertUser.php">Add Administrator</a></div>
			<div><a href="insertContent.php">New Post</a></div>
			<table>
				<caption>Posts</caption>
				<tr>
					<th>Title</th>
					<th>Post Date</th>
					<th></th>
					<th></th>
				</tr>
			<?php
				if ($result) {
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			?>
				    	<tr>
				    		<td><a href="content.php?contentid=<?php echo $row->cms_content_id ?>"><?php echo $row->cms_content_title ?></a></td>
				    		<td><?php echo date('jS F, Y // h:i A', $row->cms_content_date); ?></td>
				    		<td><a href="updateContent.php?contentid=<?php echo $row->cms_content_id ?>">Update</a></td>
				    		<td><a href="deleteContent.php?contentid=<?php echo $row->cms_content_id ?>">Delete</a></td>
				    	</tr>
			<?php
				  	} 
			?>
				</table>
			<?php
				} else {
					echo "</table><p>Select failed!</p>";
				}
			?>		
		</main>
	</body>
</html>