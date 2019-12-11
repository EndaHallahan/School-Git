<?php
	session_start();
	include "pdoConnect.php";
	$result = false;
	try {
		$stmt = $conn->prepare("
			SELECT 
				cms_content_id,
				cms_content_title,
				cms_content_date,
				cms_content_description
			FROM 
				wdv341_cms_content
			");
		$result = $stmt->execute();
	} catch(PDOException $e) {
    	$errorMsg = "Error: " . $e->getMessage();
    }
    date_default_timezone_set('UTC');
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<?php include "head.php" ?>
	</head>
	<body>
		<?php include "header.php" ?>
		<main>
			<h2>Recent Posts</h2>
			<?php
				if ($result) {
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
			?>
					<div class="post-card">
						<h2><a href=<?php echo "content.php?contentid=". $row->cms_content_id; ?>><?php echo $row->cms_content_title; ?></a></h2>
						<div><?php echo date('jS F, Y // h:i A', $row->cms_content_date); ?></div>
						<p><?php echo $row->cms_content_description; ?></p>
					</div>
			<?php
				  	} 
				}
			?>
		</main>
	</body>
</html>