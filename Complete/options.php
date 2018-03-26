
<html>
    <head lang="en-US">
       <meta charset="UTF-8">
       <title>Topic of Interest</title>
       <link href="./options.css" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cousine:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:400,700,900|Euphoria+Script" rel="stylesheet">
       <meta name="viewport" content="wideth=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="custom-radios">
 		<p class = "select">Please select what topic you are interested in </p>
            <form action="timeframe.php" method="get">
            
                <input type="radio" id="topic1" name="topics" value="number"> 
                <label for="topic1">Number of Students in a Timeframe</label><br>

                <input type="radio" id="topic2" name="topics" value="average">
                <label for="topic2">Average Number of Students in a Timeframe</label><br>

                <input type="radio" id="topic3" name="topics" value="graph">
                <label for="topic3">Graph Data Points in a Timeframe</label><br>

                <input type="radio" id="topic4" name="topics" value="highlow">
                <label for="topic4">Highest and Lowest Peaks in a Timeframe</label><br>

                <input type="radio" id="topic5" name="topics" value="stats*">
                <label for="topic5">Extra Stats -- Work on this!</label><br>
                <button type="submit" class="button">Continue to Select a Timeframe</button>
            </form>
        </div>

        

    </body>
</html>