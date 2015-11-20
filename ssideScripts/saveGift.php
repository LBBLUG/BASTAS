<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$postdata = file_get_contents("php://input");

$gift = json_decode($postdata);
if (!isset($gift->giftId) || empty($gift->giftId) || $gift->giftId == 0)
{
	$resultSet = $databaseUtil->ExecuteStoredProcedure("createGift",
		new StoredProcedureParameter("i", $gift->giftNo),
		new StoredProcedureParameter("s", $gift->giftDescription),
		new StoredProcedureParameter("s", $gift->giftSize),
		new StoredProcedureParameter("i", $gift->mainId),
		new StoredProcedureParameter("i", $gift->giverId),
		new StoredProcedureParameter("i", $gift->isPulled),
		new StoredProcedureParameter("i", $gift->isReceived),
		new StoredProcedureParameter("i", $gift->isDelivered)
		);
}
else
{
	$resultSet = $databaseUtil->ExecuteStoredProcedure("updateGift",
		new StoredProcedureParameter("i", $gift->giftId),
		new StoredProcedureParameter("i", $gift->giftNo),
		new StoredProcedureParameter("s", $gift->giftDescription),
		new StoredProcedureParameter("s", $gift->giftSize),
		new StoredProcedureParameter("i", $gift->mainId),
		new StoredProcedureParameter("i", $gift->giverId),
		new StoredProcedureParameter("i", $gift->isPulled),
		new StoredProcedureParameter("i", $gift->isReceived),
		new StoredProcedureParameter("i", $gift->isDelivered)
		);
}
if ($databaseUtil->GetExceptionOccured()) 
{
	http_response_code(500);
	echo $databaseUtil->GetExceptionMessage();
}

http_response_code(200);
echo json_encode(array("data" => $resultSet));
 
?>