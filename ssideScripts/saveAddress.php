<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$postdata = file_get_contents("php://input");

$address = json_decode($postdata);
if (!isset($address->Id) || empty($address->Id))
{
	$resultSet = $databaseUtil->ExecuteStoredProcedure("createAddress",
		new StoredProcedureParameter("s", $address->streetAddress),
		new StoredProcedureParameter("s", $address->aptNumber),
		new StoredProcedureParameter("s", $address->neighborhood),
		new StoredProcedureParameter("s", $address->city),
		new StoredProcedureParameter("s", $address->state),
		new StoredProcedureParameter("s", $address->zipCode),
		new StoredProcedureParameter("i", $address->recipientId)
		);
}
else
{
	$resultSet = $databaseUtil->ExecuteStoredProcedure("updateAddress",
		new StoredProcedureParameter("i", $address->Id),
		new StoredProcedureParameter("s", $address->streetAddress),
		new StoredProcedureParameter("s", $address->aptNumber),
		new StoredProcedureParameter("s", $address->neighborhood),
		new StoredProcedureParameter("s", $address->city),
		new StoredProcedureParameter("s", $address->state),
		new StoredProcedureParameter("s", $address->zipCode),
		new StoredProcedureParameter("i", $address->recipientId)
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