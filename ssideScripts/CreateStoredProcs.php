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

$createrecipAndAddress = "CREATE DEFINER= '$username'@`$ServerAddress` PROCEDURE `pop_recipAndAddress`(IN lastName varchar(30), IN firstName varchar(30), IN sex varchar(1), IN h_phone varchar(13), IN c_phone varchar(13), IN onlineRecip bool, IN routeNo varchar(10), IN street varchar(50), IN apt varchar(10),  IN neigh varchar(50), IN city_name varchar(50), IN state_name varchar(2), IN zip varchar(10),IN giftNo int(11),IN giftDesc varchar(500),IN giftSize varchar(20)) BEGIN DECLARE mainId INT DEFAULT 0; INSERT INTO Recipients (lastname, firstname, gender, home_phone, cell_phone, online_recip, route_no) VALUES (lastName, firstName, sex, h_phone, c_phone, onlineRecip, routeNo); SET mainId = last_insert_id();INSERT INTO Recip_Address (street_address, apt_no, neighborhood, city, state, zip_code, main_id) VALUES (street, apt, neigh, city_name, state_name, zip, mainId); INSERT INTO Gifts (gift_no, description, size, main_id) VALUES (giftNo, giftDesc, giftSize, mainId);END;";

$createGiftStatus = "CREATE DEFINER = '$username'@`$ServerAddress` PROCEDURE 'ins_giftStatusCode' (IN Status varchar(50)) BEGIN INSERT INTO Gift_Status (status) VALUES (Status);END;";
    
$createGivers = "CREATE DEFINER = '$username'@`$ServerAddress` PROCEDURE 'ins_giverInformation' (IN lastName varchar(30), IN firstName varchar(30), IN Email varchar(150), IN homePhone varchar(13), IN cellPhone varchar(13), IN streetAddress varchar(50), IN aptNo varchar(10), IN cityName varchar(50), IN stateName varchar(2), IN postCode varchar(10), IN wishAnon bool, IN giftId int) BEGIN INSERT INTO Giver (lastname, fistname, email, phone_home, phone_cell, address_street, apt_no, city, state, zip_code, wishes_anon, gift_id) VALUES (lastName, firstName, Email, homePhone, cellPhone, streetAddress, aptNo, cityName, stateName, postCode, wishAnon, giftId); END;";
    
$createNotes = "CREATE DEFINER = '$username'@`$ServerAddress` PROCEDURE 'ins_recipNotes' (IN Note varchar(500), IN mainId int) BEGIN INSERT INTO Notes (notes, main_id) VALUES (Note, mainId); END;";


// ************************************************************************
// Permissions and Group Permissions need to be added here.
// ************************************************************************


mysqli_select_db($conn, "bastas");

if (!$conn->query($createrecipAndAddress))
{
    echo "Stored procedure creation of pop_recipAndAddress failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure created pop_recipAndAddress sucessfully!";
}

?>