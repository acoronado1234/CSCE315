<?php
    include('CommonMethods.php');
    $COMMON = new Common($debug);
    $debug = false;
    // Create connection
    date_default_timezone_set('America/Chicago');

    function displayTimePeriod($startTime, $endTime)
   {  
        $sql = "SELECT * FROM `ProjectDB` WHERE `timestamp` <= '$endTime' AND `timestamp` >= '$startTime'";
        global $COMMON;
        global $debug;
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
       echo "<table border ='1px'>";
        while($row = $rs->fetch(PDO::FETCH_ASSOC)){
            echo '<tr>';
            foreach($row as $field) {
                echo '<td>' . htmlspecialchars($field) . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

?>

<?php 
     $selectedTime = $_POST['selectedTime'];
    $type = $_POST['time'];
    switch($type)
                {
                    case "year":

                        // $startingTime = $selectedTime . "-01-01 00:00:00";
                        // $endingTime = $selectedTime . "-12-31 23:59:59";
                        break;

                    case "month":
                        $startingTime = $selectedTime . "-01 00:00:00";

                        $month = substr($selectedTime, 5);
                        $year = substr($selectedTime, 0, -3);
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $endingTime = $selectedTime . "-" . $daysInMonth . " 23:59:59";
                        break;

                    case "week":
                        $startDay = date("Y-m-d", strtotime($selectedTime));
                        $startingTime = $startDay . " 00:00:00";

                        $endDay = date('Y-m-d', strtotime($startDay . ' + 6 days'));
                        $endingTime = $endDay . " 23:59:59";
                        break;

                    case "day":
                        $startingTime = $selectedTime . " 00:00:00";
                        $endingTime = $selectedTime . " 23:59:59";
                        break;

                    case "hour":
                        $startDay = substr($selectedTime,0,-6);
                        $startTime = substr($selectedTime,11,-3);
                        
                        $startingTime = $startDay . " " . $startTime . "00:00";
                        $endingTime = $startDay . " " . $startTime ."59:59";

                        break;

                    default:

                }

        $dataPoints = array();
        $sql = "SELECT `timestamp` FROM `ProjectDB` where `timestamp` <= '$endingTime' AND `timestamp` >= '$startingTime'";
            global $COMMON;
            global $debug;
            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            while($row = $rs->fetch(PDO::FETCH_ASSOC)){
                foreach($row as $field){
                    var_dump($field);
                    $data = array("y"=>1, "label"=>$field);
                    array_push($dataPoints,$data);
                }
            }
    //print_r($dataPoints);

?>

<html>
    <head lang="en-US">
       <meta charset="UTF-8">
       <title>Results</title>
        <link href="https://fonts.googleapis.com/css?family=Cousine:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:400,700,900|Euphoria+Script" rel="stylesheet">
       <meta name="viewport" content="wideth=device-width, initial-scale=1.0">
       <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    exportEnabled: true,
    theme: "dark2", 
    title:{
        text: "Count"
    },
    axisX:{
        title: "Timeframe",
        suffix: " "
    },
    axisY:{
        title: "Count",
        suffix: " person",
        minimum: 0,
        maximum: 2,
        interval: 1
    },
    data: [{
        type: "scatter",
        markerType: "square",
        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
</script>
    </head>
    <body>
        
    <?php
    $option = $_POST['option'];

        switch($option){
            case "graph":
                //graphPoints($startingTime, $endingTime);
                echo('<div id="chartContainer" style="height: 370px; width: 100%;"></div>
            }
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>');
                break;

            default:

        }
    echo($startingTime . "<br>");
    echo($endingTime."<br>");
    echo($option);
    displayTimePeriod($startingTime, $endingTime);



    ?>

    </body>
</html>