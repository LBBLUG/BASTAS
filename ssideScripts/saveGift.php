<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$postdata = file_get_contents("php://input");

$gift = json_decode($postdata);

var_dump($gift);

$resultSet = $databaseUtil->ExecuteStoredProcedure("updateGift",
	new StoredProcedureParameter("i", $gift->giftId),
	new StoredProcedureParameter("i", $gift->giftNo),
	new StoredProcedureParameter("i", $gift->giftDescription),
	new StoredProcedureParameter("i", $gift->giftSize),
	new StoredProcedureParameter("i", $gift->mainId),
	new StoredProcedureParameter("i", $gift->giverId)
	);

if ($databaseUtil->GetExceptionOccured()) 
{
	http_response_code(500);
	echo $databaseUtil->GetExceptionMessage();
}

http_response_code(200);
echo json_encode(array("data" => $resultSet));
 
?>