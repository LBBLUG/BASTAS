<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$postdata = file_get_contents("php://input");

$recipient = json_decode($postdata);

if (!isset($recipient->id) || empty($recipient->id))
{
	$resultSet = $databaseUtil->ExecuteStoredProcedure("createRecipient",
		new StoredProcedureParameter("s", $recipient->lastName),
		new StoredProcedureParameter("s", $recipient->firstName),
		new StoredProcedureParameter("s", $recipient->gender),
		new StoredProcedureParameter("s", $recipient->cellPhone),
		new StoredProcedureParameter("s", $recipient->homePhone),
		new StoredProcedureParameter("s", $recipient->route)
		);
}
else
{
	$resultSet = $databaseUtil->ExecuteStoredProcedure("updateRecipient",
		new StoredProcedureParameter("i", $recipient->id),
		new StoredProcedureParameter("s", $recipient->lastName),
		new StoredProcedureParameter("s", $recipient->firstName),
		new StoredProcedureParameter("s", $recipient->gender),
		new StoredProcedureParameter("s", $recipient->cellPhone),
		new StoredProcedureParameter("s", $recipient->homePhone),
		new StoredProcedureParameter("s", $recipient->route)
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