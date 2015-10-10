<?php

    require_once("databaseUtilities.php");

    $databaseUtil = new DatabaseUtility();


    $postdata = file_get_contents("php://input");

	$request = json_decode($postdata);

	@$lastName = $request->lastName;
	@$firstName = $request->firstName;
	@$streetAddress = $request->address->street;
	@$aptNo = $request->address->apt;
	@$city = $request->address->city;
	@$state = $request->address->state;
	@$zip = $request->address->zip;
	@$email = $request->email;
	@$homePhone = $request->homePhone;
	@$cellPhone = $request->cellPhone;
	@$anonymous = $request->anonymous;
    
    $resultSet = $databaseUtil->ExecuteStoredProcedure("addGiver", 
    	new StoredProcedureParameter("s", $lastName), 
    	new StoredProcedureParameter("s", $firstName), 
    	new StoredProcedureParameter("s", $email), 
    	new StoredProcedureParameter("s", $homePhone), 
    	new StoredProcedureParameter("s", $cellPhone), 
    	new StoredProcedureParameter("s", $streetAddress), 
    	new StoredProcedureParameter("s", $aptNo), 
    	new StoredProcedureParameter("s", $city), 
    	new StoredProcedureParameter("s", $state), 
    	new StoredProcedureParameter("s", $zip), 
    	new StoredProcedureParameter("i", $anonymous)); // boolearn converts to int in SQL 

    if ($databaseUtil->GetExceptionOccured()) {
    	http_response_code(500);
    	echo $databaseUtil->GetExceptionMessage();
    }

    http_response_code(201);
    echo json_encode(array("data" => $resultSet));
?>