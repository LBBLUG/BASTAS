<?php

    require_once("databaseUtilities.php");

    $databaseUtil = new DatabaseUtility();

    $postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	@$lastName = $request->lastName;
	@$firstName = $request->firstName;
	@$streetAddress = $request->address.street;
	@$aptNo = $request->address.apt;
	@$city = $request->address.city;
	@$state = $request->address.state;
	@$zip = $request->address.zip;
	@$email = $request->email;
	@$homePhone = $request->homePhone;
	@$cellPhone = $request->cellPhone;
	@$anonymous = $request->anonymous;
    
    $resultSet = $databaseUtil->ExecuteStoredProcedure("addGiver()", $lastName, $firstName, $email, $homePhone, $cellPhone, $streetAddress, $aptNo, $city, $state, $zip, $anonymous);

    echo json_encode(array("data" => $resultSet));
    http_response_code(201);
?>