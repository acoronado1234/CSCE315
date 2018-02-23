<?php

include("CommonMethods.php");
$comm = new Common(FALSE);
try {
	$comm->executeQuery("INSERT INTO Visitor() VALUES()", $this);
	http_response_code(200);
} catch (PDOExceptionn $e) {
	http_response_code(500);
}

?>