
<?php
    include('CommonMethods.php');
    $COMMON = new Common($debug);
    $debug = false;
    // Create connection
    date_default_timezone_set('America/Chicago');
?>

<?php
    function GetTimestampofFirst()
    {
        global $COMMON;
        $query = "SELECT * FROM `ProjectDB` LIMIT 1";
        $execute = $COMMON->executeQuery($query, $this);
        $return = $execute->fetch(PDO::FETCH_ASSOC);
        return $return['timestamp'];
    }

    function GetTimestampofLast()
    {
        global $COMMON;
        $query = "SELECT * FROM `ProjectDB` ORDER BY `id` DESC LIMIT 1";
        $execute = $COMMON->executeQuery($query, $this);
        $return = $execute->fetch(PDO::FETCH_ASSOC);
        return $return['timestamp'];
    }
    function why(){
        $sql = "SELECT `timestamp` FROM `ProjectDB`";
        global $COMMON;
        global $debug;
        $rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
        $row = $rs->fetch(PDO::FETCH_ASSOC);
        //echo $row;
        return $row;
    }
?>
<html>
    <head lang="en-US">
       <meta charset="UTF-8">
       <title>Timeframe Selection</title>
       <link rel="stylesheet" type="text/css" href="./timeframe.css?<?php echo time();?>"/>
       <link href="https://fonts.googleapis.com/css?family=Cousine:400,700" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:400,700,900|Euphoria+Script" rel="stylesheet">
       <meta name="viewport" content="wideth=device-width, initial-scale=1.0">
    </head>
    <body>
    	<?php
    		$option = $_GET['topics'];
    		if($option == "number" || $option == "average" || $option == "graph" || $option == $stats)
    		{
    			echo
    			('
                <p class="timeframeSelect">Please select the timeframe that you are interested in:</p>
			        <form action="timeframe.php" method="get" class="timeframeForm">
			            
			            <div>
			                <input type="radio" id="timeframe1" name="timeframe" value="year">
			                <label for="timeframe1">Year</br></label>

			                <input type="radio" id="timeframe2" name="timeframe" value="month">
			                <label for="timeframe2">Month</br></label>

			                <input type="radio" id="timeframe3" name="timeframe" value="week">
			                <label for="timeframe3">Week</br></label>

			                <input type="radio" id="timeframe4" name="timeframe" value="day">
			                <label for="timeframe4">Day</br></label>

			                <input type="radio" id="timeframe5" name="timeframe" value="hour">
			                <label for="timeframe5">Hour</br></label>

			                <input type="hidden" name="topics" value="'.$option.'"

			            </div>
			            <div>
			                <button type="submit" class="button">Continue to Select a Time</button>
			            </div>
			        </form>
			    ');	
    		}
    		elseif($option == "highlow")
    		{
    			echo
    			('
			        <form action="timeframe.php" method="get">
			            <p>Please select the timeframe that you are interested in:</p>
			            <div>
			                <input type="radio" id="timeframe3" name="timeframe" value="week">
			                <label for="timeframe3">Week</br></label>

			                <input type="radio" id="timeframe4" name="timeframe" value="day">
			                <label for="timeframe4">Day</br></label>

			                <input type="hidden" name="topics" value="'.$option.'"
			            </div>
			            <div>
			                <button type="submit">Continue to Select a Time</button>
			            </div>
			        </form>
			    ');	
    		}

    		$type = $_GET['timeframe'];
    		if($type != NULL)
    		{
    			echo('<form action="result.php" method="post">');
	            switch ($type) 
	            {
	                case "year":
	                    echo('Select the year you are interested in:</br>');
	                    for($i=$firstYear; $i<=$lastYear; $i++){
	                        echo('<input type="radio" id="select' .$i.'" name="selectedTime" value=' .$i.'>
	                            '.$i.'</br>');
	                    }
	                    echo('<input type="hidden" name="time" value="year">');
	                    echo('<input type="hidden" name="option" value="'.$option.'">');
	                    echo('<button type="submit">Submit to View Results</button>');
	                    break;

	                case "month":
	                    echo('Select the month you are interested in:</br>
	                            <input type="month" name="selectedTime" min="'. $firstMonth .'" max="'. $lastMonth.'">
	                            <input type="hidden" name="time" value="month">');
	                    echo('<input type="hidden" name="option" value="'.$option.'">');
	                    echo('<button type="submit">Submit to View Results</button>');
	                    break;

	                case "week":
	                    echo('Select the week you are interested in:</br>
	                            <input type="week" name="selectedTime" min="' . $firstWeek .'" max="' . $lastWeek .'">
	                            <input type="hidden" name="time" value="week">');
	                    echo('<input type="hidden" name="option" value="'.$option.'">');
	                    echo('<button type="submit">Submit to View Results</button>');
	                    break;

	                case "day":
	                    echo('Select the day you are interested in:</br>
	                            <input type="date" name="selectedTime" min="' . $firstDay . '"max="' . $lastDay . '">
	                            <input type="hidden" name="time" value="day">');
	                    echo('<input type="hidden" name="option" value="'.$option.'">');
	                    echo('<button type="submit">Submit to View Results</button>');
	                    break;

	                case "hour":
	                    echo('Select the day and the hour that you are interested in:</br>
	                            <input type="datetime-local" name="selectedTime" min="' . $firstHour . '" max="' . $lastHour . '" step="3600">
	                            <input type="hidden" name="time" value="hour">');
	                    echo('<input type="hidden" name="option" value="'.$option.'">');
	                    echo('<button type="submit">Submit to View Results!</button>');
	                    break;

	                default:
	               }
	                echo('</form>');
            }
		?>
    		