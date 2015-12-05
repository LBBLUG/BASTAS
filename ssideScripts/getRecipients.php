<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$resultSet = $databaseUtil->ExecuteStoredProcedure("getRecipAndGifts");

if ($databaseUtil->GetExceptionOccured()) 
{
	http_response_code(500);
	echo $databaseUtil->GetExceptionMessage();
}

http_response_code(200);
echo json_encode(array("data" => $resultSet));
 
?>