<!-- /****************************************************
** File: 
** Project: Project 1 
** Author: Amanda Bsaibes and Emmalee Keatley
** Date: 2/22/2018
** Section: 502
** E-mail 1: amanda.bsaibes@tamu.edu
** E-mail 2: emmaleepk@tamu.edu
**
** This file contains the initial test cases for the 
** database interaction with PHP. We first make sure that
** the database is correctly set up and then test that 
** the PHP interacts as expected with the database. 
**
****************************************************/-->

<?php
    // Connect this file to the database 
    include('CommonMethods.php');
    $COMMON = new Common($debug);
    $debug = false;

    // options to tell when an assertion goes wrong and where
    assert_options(ASSERT_ACTIVE, 1);
    assert_options(ASSERT_WARNING, 0);
    assert_options(ASSERT_QUIET_EVAL, 1);

//----------------------------------------------------------------
// Name: AssertHandler
// PreCondition: Created and called an assertion that failed 
// PostCondition: Returns information about where an assertion that
// failed is located 
//---------------------------------------------------------------- 
    function AssertHandler($file, $line, $code, $desc = null)
    {
        echo "Assertion failed at $file:$line: $code";
        if($desc)
            echo ": desc";
        echo "\n";
    }

    // enables the AssertHandler function to be used
    assert_options(ASSERT_CALLBACK, 'AssertHandler');

//----------------------------------------------------------------
// Name: CountTables
// PreCondition: Created a databases and connected to the database
// PostCondition: Returns the number of tables in the database
//---------------------------------------------------------------- 
    function CountTablesInDB()
    {
        global $COMMON;
        // outputs all the tables in the database
        $testQuery = "SHOW TABLES FROM `emmaleepk`";
        $results = $COMMON->executeQuery($testQuery, $this);
        $countTables = 0;
        // loops through the tables and counts the number of them
        // in the database
        while($row = $results->fetch(PDO::FETCH_ASSOC))
            $countTables++;

        return $countTables;

    }

//----------------------------------------------------------------
// Name: CountNumberofRows
// PreCondition: The table ProjectDB must created 
// PostCondition: Returns the number of rows in ProjectDB
//---------------------------------------------------------------- 
    function CountNumberofRows()
    {
        global $COMMON;
        $testQuery = "SELECT COUNT(`id`) as 'answer' FROM `ProjectDB`";
        $return = $COMMON->executeQuery($testQuery, $this);
        $countRows = $return->fetch(PDO::FETCH_ASSOC);
        return $countRows['answer'];
    }

//----------------------------------------------------------------
// Name: CountBetweenTimeStamps
// PreCondition: Created Project DB and have two timestamps that 
// you want to know information about
// PostCondition: Returns the number of rows that fall between the
// two given timestamps
//---------------------------------------------------------------- 
    function CountBetweenTimeStamps($timeStamp1, $timeStamp2)
    {
        global $COMMON;
        $testQuery = "SELECT COUNT(`id`) as 'count' FROM `ProjectDB` WHERE `timestamp` BETWEEN '$timeStamp1' AND '$timeStamp2'";
        $return = $COMMON->executeQuery($testQuery, $this);
        $countRows = $return->fetch(PDO::FETCH_ASSOC);
        return $countRows['count'];
    }

//----------------------------------------------------------------
// Name: ResetTable
// PreCondition: Created the table ProjectDB
// PostCondition: Project DB is cleared of all its previously
// existing rows
//---------------------------------------------------------------- 
    function ResetTable()
    {
        global $COMMON;
        $testQuery = "DELETE FROM `ProjectDB`";
        $reset = $COMMON->executeQuery($testQuery, $this);
    } 

//----------------------------------------------------------------
// Name: ResetAutoIncrement
// PreCondition: Created table ProjectDB and (preferably) called the 
// ResetTable() function already
// PostCondition: Resets the auto increment back to start at 1
//---------------------------------------------------------------- 
    function ResetAutoIncrement()
    {
        global $COMMON;
        $testQuery = "ALTER TABLE `ProjectDB` AUTO_INCREMENT = 1";
        $autoIncrement = $COMMON->executeQuery($testQuery, $this);
    }

//----------------------------------------------------------------
// Name: InsertData
// PreCondition: Created table ProjectDB and a timestamp that you
// want to insert
// PostCondition: Inserts a row into ProjectDB with the given
// timestamp
//---------------------------------------------------------------- 
    function InsertData($timeStamp)
    {
        global $COMMON;
        $testQuery = "INSERT INTO `ProjectDB` (`id`, `timestamp`) VALUES (NULL, '$timeStamp')";
        $execute = $COMMON->executeQuery($testQuery);
    }

// Name: GetIDofFirst
// PreCondition: Created table ProjectDB and have at least one row 
// inserted
// PostCondition: Returns the id of the first row (used to check that)
// ResetAutoIncrement function worked
//---------------------------------------------------------------- 
    function GetIDofFirst()
    {
        global $COMMON;
        $testQuery = "SELECT * FROM `ProjectDB` LIMIT 1";
        $return = $COMMON->executeQuery($testQuery, $this);
        $countRows = $return->fetch(PDO::FETCH_ASSOC);
        return $countRows['id'];

    }

    // The database only holds one table
    assert('CountTablesInDB() == 1');

    // After this function, the table should not have any rows/info
    ResetTable();
    assert('CountNumberofRows() == 0');

    // AutoIncrement is reset so that the row that is next inserted has
    // the id of 1
    ResetAutoIncrement();
    $timeStamp = "2018-01-31 08:21:22";
    // InsertData will insert 1 active row
    InsertData($timeStamp);
    assert('CountNumberofRows() == 1');
    assert('GetIDofFirst() == 1');

    // Insert 9 other rows so total is now 10
    for($i = 0; $i < 9; $i++)
    {
        $timestamp = "2018-02-0".$i." 08:21:22";
        InsertData($timestamp);
    }  
    assert('CountNumberofRows() == 10');

    // Define two timestamps to check between, total should be 4
    $timestamp1 = "2018-02-03 08:21:22";
    $timestamp2 = "2018-02-06 08:21:22";
    assert('CountBetweenTimeStamps($timestamp1, $timestamp2) == 4');

    //Reset the table and the increment, rows should be 0
    ResetTable();
    ResetAutoIncrement();
    assert('CountNumberofRows() == 0');
?>