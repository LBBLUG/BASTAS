<?php

/*

    BASTAS Web Management Application - Web Management of Be A Santa to A Senior and Similar generous programs
    Copyright (C) 2015  Lubbock Linux Users Group (Dan Ferguson, Christopher Cowden, Brian McGonagill)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see https://github.com/LBBLUG/BASTAS/blob/master/GNUV3.0PublicLicenseSoftware.txt.

*/

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
    	new StoredProcedureParameter("i", $anonymous)); // boolean converts to int in SQL

    if ($databaseUtil->GetExceptionOccured()) {
    	http_response_code(500);
    	echo $databaseUtil->GetExceptionMessage();
    }

    http_response_code(201);
    echo json_encode(array("data" => $resultSet));

?>