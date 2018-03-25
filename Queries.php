<!-- /****************************************************
** File: 
** Project: Project 1 
** Author: Amanda Bsaibes, Emmalee Keatley, and Alexander Coronado
** Date: 3/25/2018
** Section: 502
** E-mail 1: amanda.bsaibes@tamu.edu
** E-mail 2: emmaleepk@tamu.edu
** E-mail 3: kwong333@tamu.edu
**
** This file contains the queries for the database.
** There are multiple functions that access the database
** and return information based on what the HTML form
** asks for. 
**
****************************************************/-->

<?PHP
date_default_timezone_set('America/Chicago');
include('CommonMethods.php');
$COMMON = new Common($debug);
$debug = false;	
	

//----------------------------------------------------------------
// Name: AveragePerDay
// PreCondition: HTML form passes the function a timestamp for a given day
// PostCondition: Returns the average for the given day 
//---------------------------------------------------------------- 
function AveragePerDay($timestamp)
{	
	$sumPerHour =0;
	$numOfHours = 0;

	for($i=0; $i < 24; $i++)
		{
			$hourStart =  date("Y-m-d H:i:s", strtotime(sprintf('+%u hours', $i), strtotime($timestamp)));
			$totalPerHour = TotalPerHour($hourStart);
			if ($totalPerHour != 0)
			{
				$sumPerHour = $sumPerHour + $totalPerHour;
				$numOfHours++;
			}
			
		}
	$averagePerDay = $sumPerHour/$numOfHours;	
}
	
//----------------------------------------------------------------
// Name: AveragePerWeek
// PreCondition: HTML form passes the function a timestamp for a given week
// PostCondition: Returns the average for the given week 
//---------------------------------------------------------------- 
function AveragePerWeek($timestamp)
{
	for($i=0; $i < 7; $i++)
	{
		$day = date("Y-m-d H:i:s", strtotime(sprintf('+%u days', $i), strtotime($timestamp)));
		$sumPerDay = TotalPerDay($day);
	}
	$averagePerWeek = $sumPerDay/7;
	return $averagePerWeek;
}

//----------------------------------------------------------------
// Name: AveragePerMonth
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns the average for the given month
//---------------------------------------------------------------- 
function AveragePerMonth($timestamp)
{
	$month = date('m',strtotime($timestamp));
	$year = date('Y',strtotime($timestamp));
	$d = cal_days_in_month(CAL_GREGORIAN, $month, $year); 

	for($i=0; $i < $d; $i++)
	{
		$day = date("Y-m-d H:i:s", strtotime(sprintf('+%u days', $i), strtotime($timestamp)));
		$sumPerDay = TotalPerDay($day);	
	}
	$averagePerMonth = $sumPerDay/$d;
}

//----------------------------------------------------------------
// Name: SlowestHourPerDay
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns the hour and the local min with the least 
// amount of people for given day
//---------------------------------------------------------------- 
function SlowestHourPerDay($timestamp)
{
	$day = date('m/d/Y',strtotime($timestamp));
	$minHour = date('g A',strtotime($timestamp)); 
	
	for($i=0; $i < 24; $i++)
	{
		$min = 5000;
		$hourStart =  date("Y-m-d H:i:s", strtotime(sprintf('+%u hours', $i), strtotime($timestamp)));
		$totalPerHour = TotalPerHour($hourStart);
		if($totalPerHour !=0 && $totalPerHour < $min)
		{
			$min = $totalPerHour;
			$minHour = date('g A',strtotime($hourStart));
		}
	}
	$result = sprintf("Slowest hour on %s was at %s with %u people.", $day, $minHour, $min);
	return $result;
}

//----------------------------------------------------------------
// Name: SlowestHourPerWeek
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns the day of week and the local min with the 
// least amount of people for given week
//---------------------------------------------------------------- 
function SlowestDayPerWeek($timestamp)
{
	$weekStart = date('m/d/Y',strtotime($timestamp));
	$weekEnd = date("m/d/Y", strtotime('+7 days', strtotime($timestamp)));
	$minDay = date('m/d/Y',strtotime($timestamp));
	
	for($i=0; $i <7; $i++)
	{
		$min = 5000;
		$dayOfWeek = date("Y-m-d H:i:s", strtotime(sprintf('+%u days', $i), strtotime($timestamp)));
		$totalPerDay = TotalPerDay($dayOfWeek);
		if ($totalPerDay < $min) 
		{
			$min = $totalPerDay;
			$minDay = date('m/d/Y',strtotime($timestamp));
		}
	}
	$result = sprintf("Slowest day for the week of %s to %s was %s with %u people.", $weekStart, $weekEnd, $minDay, $min);
	return $result;
}

//----------------------------------------------------------------
// Name: BusiestHourPerDay
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns the hour of day and the local max with the 
// most amount of people for given day
//---------------------------------------------------------------- 
function BusiestHourPerDay($timestamp)
{
	$day = date('m/d/Y',strtotime($timestamp));
	$maxHour = date('g A',strtotime($timestamp)); 
	
	for($i=0; $i < 24; $i++)
	{
		$max = 0;
		$hourStart =  date("Y-m-d H:i:s", strtotime(sprintf('+%u hours', $i), strtotime($timestamp)));
		$totalPerHour = TotalPerHour($hourStart);
		if ($sumPerHour > $max)
		{
			$max = $sumPerHour;
			$maxHour = date('g A',strtotime($hourStart));
		}
	}
	$result = sprintf("Busiest hour on %s was at %s with %u people.", $day, $maxHour, $max);
	return $result;
}

//----------------------------------------------------------------
// Name: BusiestDayPerWeek
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns the day of week and the local max with the 
// most amount of people for given week
//---------------------------------------------------------------- 
function BusiestHourPerWeek($timestamp)
{
	$weekStart = date('m/d/Y',strtotime($timestamp));
	$weekEnd = date("m/d/Y", strtotime('+7 days', strtotime($timestamp)));
	$maxDay = date('m/d/Y',strtotime($timestamp));
	
	for($i=0; $i < 7; $i++)
	{
		$max = 0;
		$day = date("Y-m-d H:i:s", strtotime(sprintf('+%u days', $i), strtotime($timestamp)));
		$totalPerDay = TotalPerDay($totalPerDay);		
		if ($sumPerDay > $max){
			$max = $sumPerDay;
			$maxDay = date('l',strtotime($timestamp));
		}
	}
	
	$result = sprintf("Busiest day for the week of %s to %s was %s with %u people.", $weekStart, $weekEnd, $maxDay, $max);
	return $result;	
}

//----------------------------------------------------------------
// Name: TotalPerHour
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns total number of rows for the hour given 
//---------------------------------------------------------------- 
function TotalPerHour($timestamp)
{
	$totalPerHour = 0;
	$hourStart =  $timestamp;
	$hourFinish = date("Y-m-d H:i:s", strtotime('+59 minutes +59 seconds', strtotime($timestamp)));
	
	global $COMMON;
	$query = "SELECT COUNT(`id`) as 'count' FROM `ProjectDB` WHERE `timestamp` BETWEEN '$hourStart' AND '$hourFinish'";
	$return = $COMMON->executeQuery($query, $this);
	$countRows = $return->fetch(PDO::FETCH_ASSOC);
	$total = $countRows['count'];
	
	$result = sprintf('Total for the hour of %s is %u.', $hourStart, $total);
	return $total;
}

//----------------------------------------------------------------
// Name: TotalPerDay
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns total number of rows for the day given 
//---------------------------------------------------------------- 
function TotalPerDay($timestamp)
{
	$total = 0;
	$dayOfYear = date('Y-m-d',strtotime($timestamp));
	$day = date('m/d/Y',strtotime($timestamp));
	
	global $COMMON;
	$query = "SELECT COUNT(`id`) as 'count' FROM `ProjectDB` WHERE `timestamp` LIKE '{$dayOfYear}%'";
	$return = $COMMON->executeQuery($query, $this);
	$countRows = $return->fetch(PDO::FETCH_ASSOC);
	$total = $countRows['count'];
	
	$result = sprintf('Total for %s is %u', $day, $total);
	return $total;
}

//----------------------------------------------------------------
// Name: TotalPerWeek
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns total number of rows for the week given 
//----------------------------------------------------------------
function TotalPerWeek($timestamp)
{
	$total = 0;
	$weekStart = $timestamp;
	$weekEnd = date("Y-m-d H:i:s", strtotime('+7 days +59 minutes +59 seconds', strtotime($timestamp)));
	
	global $COMMON;
	$query = "SELECT COUNT(`id`) as 'count' FROM `ProjectDB` WHERE `timestamp` BETWEEN '$weekStart' AND '$weekEnd'";
	$return = $COMMON->executeQuery($query, $this);
	$countRows = $return->fetch(PDO::FETCH_ASSOC);
	$total = $countRows['count'];
	
	return  $total;	
}

//----------------------------------------------------------------
// Name: TotalPerMonth
// PreCondition: HTML form passes the function a timestamp
// PostCondition: Returns total number of rows for the month given 
//----------------------------------------------------------------
function TotalPerMonth($timestamp)
{
	$total = 0;
	$monthOfYear = date('Y-m-d',strtotime($timestamp));
	$month = date('F \of Y',strtotime($timestamp));
	
	global $COMMON;
	$query = "SELECT COUNT(`id`) as 'count' FROM `ProjectDB` WHERE `timestamp` LIKE '{$monthOfYear}%'";
	$return = $COMMON->executeQuery($query, $this);
	$countRows = $return->fetch(PDO::FETCH_ASSOC);
	$total = $countRows['count'];
	
	$result = sprintf('Total for %s is %u', $month, $total);
	return $total;
}

//----------------------------------------------------------------
// Name: TotalInDatabase
// PreCondition: Database is created and has values
// PostCondition: Returns total number of rows in database 
//----------------------------------------------------------------
function TotalInDatabase()
{
	global $COMMON;
    $query = "SELECT COUNT(`id`) as 'answer' FROM `ProjectDB`";
    $return = $COMMON->executeQuery($query, $this);
    $countRows = $return->fetch(PDO::FETCH_ASSOC);
    return $countRows['answer'];
}

?>



