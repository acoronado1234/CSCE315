
<?php
    include('CommonMethods.php');
    $COMMON = new Common($debug);
    $debug = false;
    // Create connection
?>

<?php    // Check connection
    function query1($test){
        
        $sql = "SELECT DISTINCT $test FROM question";
        global $COMMON;
        global $debug;
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
       //$row = $rs->fetch(PDO::FETCH_ASSOC);

        //$result = $conn->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
          while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
              echo " ". $row[$test];
          } 
        }
        else {
            echo "0 results";
        }      
    }
  

?>

<html>
    <head lang="en-US">
       <meta charset="UTF-8">
       <title>CSCE 315 Project</title>
       <link href="./style.css" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cousine:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:400,700,900|Euphoria+Script" rel="stylesheet">
       <meta name="viewport" content="wideth=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
          $row = query1('type');
          $result = mysql_fetch_row($row);
          var_dump($row);
          echo $row['type'];
          echo "hey";
          var_dump($result);
        ?>



    </body>
</html>

<?php

    $connection->close();

?>