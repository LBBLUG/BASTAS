<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$resultSet = $databaseUtil->ExecuteStoredProcedure("getRecipAndGifts", null);

if ($databaseUtil->GetExceptionOccured)
{
	header('HTTP/1.1 401 Unauthorized', true, 401);
	echo "Setting 401 error.";
	return;
}

header('HTTP/1.1 200 OK', true, 200);

echo json_encode(array("data" => $resultSet));
 
?>