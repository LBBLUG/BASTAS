<?php

// ************************************************************************
// This file is to create stored procedures for the BASTAS application
// ************************************************************************

require("php/src_files/config/config.php");

$conn = new mysqli($ServerAddress, $Username, $Password, $Database);

if ($conn->connect_error) 
{ 
    die("Connection failed: " . $conn->connect_error); 
} else { 
    echo "Connected successfully"; 
    echo "<br /><br />";
}


if (!$mysqli->query("CREATE PROCEDURE <procedurename>(IN <value>) BEGIN INSERT INTO tablename(<fieldname>) VALUES(<value from IN above); END;")) 
{
    echo "Stored procedure creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
} else {
    echo "Stored procedure created sucessfully!");
}


?>