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