<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$resultSet = $databaseUtil->ExecuteStoredProcedure("getRecipAndGifts", null);

echo json_encode(array("data" => $resultSet));
 
?>