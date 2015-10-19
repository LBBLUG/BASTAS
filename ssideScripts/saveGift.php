<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$postdata = file_get_contents("php://input");

$gift = json_decode($postdata);

$resultSet = $databaseUtil->ExecuteStoredProcedure("updateGift",
	new StoredProcedureParameter("i", $gift.gift_id),
	new StoredProcedureParameter("i", $gift.gift_no),
	new StoredProcedureParameter("i", $gift.description),
	new StoredProcedureParameter("i", $gift.size),
	new StoredProcedureParameter("i", $gift.main_id),
	new StoredProcedureParameter("i", $gift.giver_id)
	);

if ($databaseUtil->GetExceptionOccured()) 
{
	http_response_code(500);
	echo $databaseUtil->GetExceptionMessage();
}

http_response_code(200);
echo json_encode(array("data" => $resultSet));
 
?>