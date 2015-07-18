<?php

// ************************************************************************
// This file is to create stored procedures for the BASTAS application
// ************************************************************************

$ini_array = parse_ini_file("php/src_files/config/config.php");

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

$createrecipAndAddress = "CREATE DEFINER=`bmcgonag`@`localhost` PROCEDURE `pop_recipAndAddress`(IN lastName varchar(30), IN firstName varchar(30), IN sex varchar(1), IN h_phone varchar(13), IN c_phone varchar(13), IN routeNo varchar(10), IN street varchar(50), IN apt varchar(10),  IN neigh varchar(50), IN city_name varchar(50), IN state_name varchar(2), IN zip varchar(10),IN giftNo int(11),IN giftDesc varchar(500),IN giftSize varchar(20)) BEGIN DECLARE id INT DEFAULT 0; INSERT INTO Recipients (lastname, firstname, gender, home_phone, cell_phone, route_no) VALUES (lastName, firstName, sex, h_phone, c_phone, routeNo); SET mainId = last_insert_id();INSERT INTO Recip_Address (street_address, apt_no, neighborhood, city, state, zip_code, main_id) VALUES (street, apt, neigh, city_name, state_name, zip, mainId); INSERT INTO Gifts (gift_no, description, size, main_id) VALUES (giftNo, giftDesc, giftSize, mainId);END;";

if (!$conn->query($createrecipAndAddress))
{
    echo "Stored procedure creation of pop_recipAndAddress failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure created pop_recipAndAddress sucessfully!";
}

?>