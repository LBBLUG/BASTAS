<?php

require_once("databaseUtilities.php");

$databaseUtil = new DatabaseUtility();

$resultSet = $databaseUtil->ExecuteStoredProcedure("getUsersAndGroups", null);

echo json_encode(array("data" => $resultSet));
 
?>