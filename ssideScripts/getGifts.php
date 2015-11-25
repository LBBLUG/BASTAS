<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$recordId = htmlspecialchars($_GET["recipientId"]);

echo "Recipient id: " . $recordId;

$resultSet = $databaseUtil->ExecuteStoredProcedure("getGifts",
	new StoredProcedureParameter("i", $recordId));

if ($databaseUtil->GetExceptionOccured()) 
{
	http_response_code(500);
	echo $databaseUtil->GetExceptionMessage();
}

http_response_code(200);
echo json_encode(array("data" => $resultSet));
 
?>