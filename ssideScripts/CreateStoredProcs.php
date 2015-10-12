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

$createrecipAndAddress = "CREATE PROCEDURE pop_recipAndAddress(IN lastName varchar(30), IN firstName varchar(30), IN sex varchar(1), IN h_phone varchar(13), IN c_phone varchar(13), IN routeNo varchar(10), IN street varchar(50), IN apt varchar(10),  IN neigh varchar(50), IN city_name varchar(50), IN state_name varchar(2), IN zip varchar(10)) BEGIN INSERT INTO Recipients (lastname, firstname, gender, home_phone, cell_phone, route_no) VALUES (lastName, firstName, sex, h_phone, c_phone, routeNo); INSERT INTO Recip_Address (street_address, apt_no, neighborhood, city, state, zip_code, main_id) VALUES (street, apt, neigh, city_name, state_name, zip, Last_Insert_ID()); END;";

if (!$conn->query($createrecipAndAddress))
{
    echo "Stored procedure creation of pop_recipAndAddress failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure created pop_recipAndAddress sucessfully!";
}

// create an admin user initial
$createAdminUser = "CREATE PROCEDURE createAdminUser(IN lastName varchar(30), IN firstName varchar(30), IN Company varchar(100), IN uName varchar(100), IN passW char(128), IN eMail varchar(150)) BEGIN INSERT INTO Users (last_name, first_name, company, uname, passw, email, group_id) VALUES (lastName, firstName, Company, uName, passW, eMail, (SELECT group_id FROM User_Group WHERE group_name = 'Admin')); END;";

if (!$conn->query($createAdminUser))
{
    echo "Stored Procedure createion of createAdminUser failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Precdure createAdminUser created successfully!";
}


// create Admin Group Permissions
$createAdminGroupPermissions = "CREATE PROCEDURE pop_createAdminGroupPermissions() BEGIN DECLARE rowNumPermType INT DEFAULT 0; DECLARE counterPermType INT DEFAULT 0; DECLARE rowNumPermGroup INT DEFAULT 0; DECLARE counterPermGroup INT DEFAULT 0; SELECT COUNT(*) FROM bastas.Permission_Type INTO rowNumPermType; SELECT COUNT(*) FROM bastas.Permission_Group INTO rowNumPermGroup; SET counterPermType=0; SET counterPermGroup=0; WHILE counterPermType<rowNumPermType DO WHILE counterPermGroup<rowNumPermGroup DO INSERT INTO bastas.Permission_Mstr (perm_type_id, perm_group_id, user_group_id) VALUES (counterPermType + 1, counterPermGroup + 1, (SELECT group_id FROM bastas.User_Group WHERE group_name = 'Admin')); SET counterPermGroup = counterPermGroup + 1; END WHILE; SET counterPermType = counterPermType + 1; SET counterPermGroup = 0; END WHILE; END;";

if (!$conn->query($createAdminGroupPermissions))
{
    echo "Stored procedure creation of createAdminGroupPermissions failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure creation of createAdminGroupPermissions Successful!";
}


// create procedure to simply add a new user without any permissions set
$addUser = "CREATE PROCEDURE createUser(IN lastName varchar(30), IN firstName varchar(30), IN Company varchar(100), IN uName varchar(100), IN passW char(128), IN eMail varchar(150)) BEGIN INSERT INTO Users (last_name, first_name, company, uname, passw, email) VALUES (lastName, firstName, Company, uName, passW, eMail); END;";

if (!$conn->query($addUser))
{
    echo "Stored procedure creation of createUser failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure creation of createUser Successful!";
}


// create procedure to add permissions to a user
$addPermission = "CREATE PROCEDURE addUserPermission (IN userID int, IN permTypeID int, IN permGroupID int, IN userGroupID int) BEGIN INSERT INTO Permission_Mstr (user_id, perm_type_id, perm_group_id, user_group_id) VALUES (userID, permTypeID, permGroupID, userGroupID); END;";

if (!$conn->query($addPermission))
{
    echo "Stored procedure creation of addPermission failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Procedure creation of addPermission successful!";
}


// create procedure to add user group
$addUserGroup = "CREATE PROCEDURE createUserGroup(IN groupName varchar(25)) BEGIN INSERT INTO User_Group (group_name) VALUES (groupName); END;";

if (!$conn->query($addUserGroup))
{
    echo "Stored procedure creation of createUserGroup failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored procedure createUserGroup created successfully!";
}

// create procedure to add a user to a group
$addUserToGroup = "CREATE PROCEDURE addUserToGroup(IN userId int, IN groupId int) BEGIN UPDATE Users SET group_id=groupId WHERE user_id=userId; END;";

if (!$conn->query($addUserToGroup))
{
    echo "Stored Procedure creation of addUserToGroup failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Preocdure addUserToGroup created successfully!";
}

// create procedure to change a user's group
$changeUserGroup = "CREATE PROCEDURE changeUsersGroup(IN userId int, IN groupId int) BEGIN UPDATE Users SET group_id = groupId WHERE user_id = userId; END;";

if (!$conn->query($changeUserGroup))
{
    echo "Stored Procedure creation of changeUserGroup failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Preocdure changeUserGroup created successfully!";
}

// create procedure to add permissions to User Group
$addGroupPerm = "CREATE PROCEDURE addGroupPerm(IN userID int, IN permTypeID int, IN permGroupID int, IN userGroupID int) BEGIN INSERT INTO Permission_Mstr (user_id, perm_type_id, perm_group_id, user_group_id) VALUES (userID, permTypeID, permGroupID, userGroupID); END;";

if (!$conn->query($addGroupPerm))
{
    echo "Stored procedure creation of addGroupPerm failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Procedure creation of addGroupPerm successful!";
}


// create procedure to add a Giver
$addGiver = "CREATE PROCEDURE addGiver(IN lastName varchar(30), IN firstName varchar(30), IN eMail varchar(150), IN homePhone varchar(13), IN cellPhone varchar(13), IN addressStreet varchar(50), IN aptNo varchar(10), IN City varchar(50), IN State varchar(2), IN Postal varchar(10), IN wishesAnon bool) BEGIN INSERT INTO Giver (lastname, firstname, email, phone_home, phone_cell, address_street, apt_no, city, state, zip_code, wishes_anon) VALUES (lastName, firstName, eMail, homePhone, cellPhone, addressStreet, aptNo, City, State, Postal, wishesAnon); END;";

if (!$conn->query($addGiver))
{
    echo "Stored Procedure creation of addGiver failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Procedure creation of addGiver successful!";
}


// create procedure to add a Gift to a Giver
$addGiftToGiver = "CREATE PROCEDURE addGiftToGiver (IN giftID int, IN giverID int) BEGIN INSERT INTO Gifts (giver_id) VALUES (giverID) WHERE gift_id = giftID; END;";

if (!$conn->query($addGiftToGiver))
{
    echo "Stored Procedure creation of addGiftToGiver failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Preocdure addGiftToGiver created successfully!";
}

// create procedure to add Gift Status
$addGiftStatus = "CREATE PROCEDURE addGiftStatus (IN Gift_ID int, IN Status varchar(50), Active bool) BEGIN INSERT INTO Gift_Status (gift_id, status, active) VALUES (Gift_ID, Status, Active); END;";

if (!$conn->query($addGiftStatus))
{
    echo "Stored Procedure creation of addGiftStatus failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Preocdure addGiftStatus created successfully!";
}

// create procedure to adjust Gift Statuses for Gifts
$adjustGiftStatus = "CREATE PROCEDURE adjustGiftStatus (IN Gift_ID int, IN Status varchar(50), Active bool) BEGIN UPDATE Gift_Status SET status=Status, active=0 WHERE gift_id=Gift_ID; INSERT INTO Gift_Status (gift_id, status, active) VALUES (Gift_ID, Status, Active); END;";

if (!$conn->query($adjustGiftStatus))
{
    echo "Stored Procedure creation of adjustGiftStatus failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Preocdure adjustGiftStatus created successfully!";
}

// create procedure to change gift status for a gift
$changeGiftStatus = "CREATE PROCEDURE changeGiftStatus(IN giftId int, IN statusId int) BEGIN UPDATE Gifts SET status_id=statusId
WHERE gift_id=giftId; END;";

if (!$conn->query($changeGiftStatus))
{
    echo "Stored Procedure creation of changeGiftStatus failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Procedure changeGiftStatus created successfully!";
}

// create procedure to add Delivery Information - used when a gift is sent out for delivery
$addDeliveryInfo = "CREATE PROCEDURE addDeliveryInfo(IN deliveryId int, IN delivererName varchar(60), IN delivererPhone varchar(10), IN giftId int) BEGIN INSERT INTO Delivery_Info (delivery_id, person_name, person_phone, gift_id) VALUES (deliveryId, delivererName, delivererPhone, giftId); END;";

if (!$conn->query($addDeliveryInfo))
{
    echo "Stored Procedure creation of addDeliveryInfo failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Stored Procedure addDeliveryInfo created successfully!";
}

// pull back users and their group from database
$getUsersAndGroups = "CREATE PROCEDURE getUsersAndGroups() BEGIN SELECT User_Group.group_name, Users.last_name, Users.first_name, Users.uname, Users.email FROM Users INNER JOIN User_Group ON User_Group.group_id=Users.group_id; END;";

if (!$conn->query($getUsersAndGroups))
{
    echo "Stored Procedure getUsersAndGroups creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    echo "Stored Procedure getUsersAndGroups created successfully!";
}

// retrieve a list of recipients and gifts
$getRecipAndGifts = "CREATE PROCEDURE `getRecipAndGifts`()
BEGIN 
SELECT 
Recipients.main_id,
Gifts.gift_no, 
Gifts.description, 
Gifts.size, 
Recipients.lastname, 
Recipients.firstname, 
Recipients.home_phone, 
Recipients.cell_phone, 
Recipients.gender, 
Recipients.route_no,
Gifts.giver_id
FROM Recipients 
INNER JOIN Gifts 
ON Recipients.main_id=Gifts.main_id; 
END;";

if (!$conn->query($getRecipAndGifts))
{
    echo "Stored Procedure getRecipAndGifts creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    echo "Stored Procedure getRecipAndGifts created successfully!";
}


// retrieve a recipients and gifts
$getRecipient = "CREATE PROCEDURE `getRecipient`(IN recipientId int)
BEGIN 
SELECT 
r.main_id, -- Recipient Key
r.lastname, 
r.firstname, 
r.home_phone, 
r.cell_phone, 
r.gender, 
r.route_no,
-- Gift info
g.gift_no, 
g.description, 
g.size, 
g.giver_id,
-- Address info
ra.recip_address_id,
ra.street_address, 
ra.apt_no,
ra.neighborhood, 
ra.city, 
ra.state, 
ra.zip_code
FROM Recipients r
INNER JOIN Gifts g
ON r.main_id=g.main_id
INNER JOIN Recip_Address ra
ON r.address_id=ra.recip_address_id
WHERE
r.main_id = recipientId;
END;";

if (!$conn->query($getRecipient))
{
    echo "Stored Procedure getRecipient creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    echo "Stored Procedure getRecipient created successfully!";
}

?>