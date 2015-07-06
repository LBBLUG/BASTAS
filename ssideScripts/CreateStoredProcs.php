<?php

// ************************************************************************
// This file is to create stored procedures for the BASTAS application
// ************************************************************************

$ini_array = parse_ini_file("php/src_files/config/config.ini.php");

$ServerAddress = $ini_array['ServerName'];
$Username = $ini_array['Username'];
$Password = $ini_array['Password'];
$Database = $ini_array['Database'];

$conn = new mysqli($ServerAddress, $Username, $Password, $Database);

if ($conn->connect_error) 
{ 
    die("Connection failed: " . $conn->connect_error); 
} else { 
    echo "Connected successfully"; 
    echo "<br /><br />";
}

$createrecipAndAddress = "CREATE PROCEDURE pop_recipAndAddress(IN lastName varchar(30), IN firstName varchar(30), IN sex varchar(1), IN h_phone varchar(13), IN c_phone varchar(13), IN routeNo varchar(10), IN street varchar(50), IN apt varchar(10),  IN neigh varchar(50), IN city_name varchar(50), IN state_name varchar(2), IN zip varchar(10)) BEGIN INSERT INTO Recipients (lastname, firstname, gender, home_phone, cell_phone, route_no) VALUES (lastName, firstName, sex, h_phone, c_phone, routeNo); INSERT INTO Recip_Address (street_address, apt_no, neighborhood, city, state, zip_code, main_id) VALUES (street, apt, neigh, city_name, state_name, zip, Last_Insert_ID()); END;";

if (!$conn->query($createrecipAndAddress))
{
    echo "Stored procedure creation of pop_recipAndAddress failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure created pop_recipAndAddress sucessfully!";
}

?>