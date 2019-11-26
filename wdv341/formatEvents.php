<?php
    function dateIndicator($date) {
        $prefix = "";
        $suffix = "";
        $todaysDate = getDate();
        $todaysTime = time();
        if (strtotime($date) > $todaysTime) {
            $prefix = $prefix . "<i>";
            $suffix = "</i>" . $suffix;
        }
        if (substr($date, 0, 2) == strval($todaysDate["mon"])) {
            $prefix = $prefix . "<span class='currentMonth'>";
            $suffix = "</span>" . $suffix;
        }
        return $prefix . $date . $suffix;
    }

    include "pdoConnect.php";

    $result = false;

    try {
        $stmt = $conn->prepare("
            SELECT 
                event_id, 
                event_name, 
                event_description, 
                event_presenter, 
                event_date,
                DATE_FORMAT(event_date, '%m/%d/%y') as event_date_formatted,
                event_time
            FROM 
                wdv341_event_two
            ORDER BY
                event_date DESC
            ");

        $result = $stmt->execute();
        $count = $stmt -> rowCount();
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }   

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WDV341 Intro PHP  - Display Events Example</title>
    <style>
		.eventBlock{
			width:500px;
			margin-left:auto;
			margin-right:auto;
			background-color:#CCC;	
		}
		
		.displayEvent{
			text_align:left;
			font-size:18px;	
		}
		
		.displayDescription {
			margin-left:100px;
		}

        .currentMonth {
            color: red;
        }
	</style>
</head>

<body>
    <h1>WDV341 Intro PHP</h1>
    <h2>Example Code - Display Events as formatted output blocks</h2>   
    <h3><?php echo $count ?> events are available today.</h3>

<?php
    if ($result) {
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
?>
    <div class="eventBlock">    
        <div>
            <span class="displayEvent">Event: <?php echo $row->event_id ?></span>
            <span>Presenter: <?php echo $row->event_presenter ?></span>
        </div>
        <div>
            <span class="displayDescription">Description: <?php echo $row->event_description ?></span>
        </div>
        <div>
            <span class="displayTime">Time: <?php echo $row->event_time ?></span>
        </div>
        <div>
            <span class="displayDate">Date: <?php echo dateIndicator($row->event_date_formatted) ?></span>
        </div>
    </div>

<?php
        } 
    } else {
        echo "<p>Select failed!</p>";
    }
?>

<?php
	$conn = null;
?>
</div>	
</body>
</html>