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
    $result['Connection'] = "Connection failed: " . $conn->connect_error;
    echo json_encode($result);
    die("Connection failed: " . $conn->connect_error); 
} else { 
    $result['Connection'] = "Connected successfully";
}

$createrecipAndAddress = "CREATE PROCEDURE pop_recipAndAddress(
IN lastName varchar(30),
IN firstName varchar(30),
IN sex varchar(1),
IN h_phone varchar(13),
IN c_phone varchar(13),
IN routeNo varchar(10),
IN street varchar(50),
IN apt varchar(10),
IN neigh varchar(50),
IN city_name varchar(50),
IN state_name varchar(2),
IN zip varchar(10))
BEGIN
INSERT INTO Recipients (lastname, firstname, gender, home_phone, cell_phone, route_no)
VALUES (lastName, firstName, sex, h_phone, c_phone, routeNo);
INSERT INTO Recip_Address (street_address, apt_no, neighborhood, city, state, zip_code, main_id)
VALUES (street, apt, neigh, city_name, state_name, zip, Last_Insert_ID());
END;";

if (!$conn->query($createrecipAndAddress))
{
    $result['CreateRecipAddress'] = "Stored procedure creation of pop_recipAndAddress failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['CreateRecipAddress'] = "Stored procedure created pop_recipAndAddress sucessfully!";
}

// create an admin user initial
$createAdminUser = "CREATE PROCEDURE createAdminUser(
IN lastName varchar(30),
IN firstName varchar(30),
IN Company varchar(100),
IN uName varchar(100),
IN passW char(128),
IN eMail varchar(150))
BEGIN
INSERT INTO Users (last_name, first_name, company, uname, passw, email, group_id) 
VALUES (lastName, firstName, Company, uName, passW, eMail, (SELECT group_id FROM User_Group WHERE group_name = 'Admin'));
END;";

if (!$conn->query($createAdminUser))
{
    $result['CreateAdminUser'] =  "Stored Procedure createion of createAdminUser failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['CreateAdminUser'] = "Stored Precdure createAdminUser created successfully!";
}


// create Admin Group Permissions
$createAdminGroupPermissions = "CREATE PROCEDURE pop_createAdminGroupPermissions()
BEGIN
DECLARE rowNumPermType INT DEFAULT 0;
DECLARE counterPermType INT DEFAULT 0;
DECLARE rowNumPermGroup INT DEFAULT 0;
DECLARE counterPermGroup INT DEFAULT 0;
SELECT COUNT(*)
FROM bastas.Permission_Type
INTO rowNumPermType;
SELECT COUNT(*)
FROM bastas.Permission_Group
INTO rowNumPermGroup;
SET counterPermType=0;
SET counterPermGroup=0;
WHILE counterPermType<rowNumPermType
DO WHILE counterPermGroup<rowNumPermGroup
DO INSERT INTO bastas.Permission_Mstr (perm_type_id, perm_group_id, user_group_id)
VALUES (counterPermType + 1, counterPermGroup + 1, (SELECT group_id FROM bastas.User_Group WHERE group_name = 'Admin'));
SET counterPermGroup = counterPermGroup + 1;
END WHILE;
SET counterPermType = counterPermType + 1;
SET counterPermGroup = 0; END WHILE;
END;";

if (!$conn->query($createAdminGroupPermissions))
{
    $result['CreateAdminGroupPermission'] = "Stored procedure creation of createAdminGroupPermissions failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['CreateAdminGroupPermission'] = "Stored procedure creation of createAdminGroupPermissions Successful!";
}


// create procedure to simply add a new user without any permissions set
$addUser = "CREATE PROCEDURE createUser(
IN lastName varchar(30),
IN firstName varchar(30),
Company varchar(100),
IN uName varchar(100),
IN passW char(128),
IN eMail varchar(150))
BEGIN
INSERT INTO Users (last_name, first_name, company, uname, passw, email)
VALUES (lastName, firstName, Company, uName, passW, eMail);
END;";

if (!$conn->query($addUser))
{
    $result['addUser'] = "Stored procedure creation of createUser failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addUser'] = "Stored procedure creation of createUser Successful!";
}


// create procedure to add permissions to a user
$addPermission = "CREATE PROCEDURE addUserPermission(
IN userID int,
IN permTypeID int,
IN permGroupID int,
IN userGroupID int)
BEGIN
INSERT INTO Permission_Mstr (user_id, perm_type_id, perm_group_id, user_group_id)
VALUES (userID, permTypeID, permGroupID, userGroupID);
END;";

if (!$conn->query($addPermission))
{
    $result['addPermission'] = "Stored procedure creation of addPermission failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addPermission'] = "Stored Procedure creation of addPermission successful!";
}


// create procedure to add user group
$addUserGroup = "CREATE PROCEDURE createUserGroup(
IN groupName varchar(25))
BEGIN
INSERT INTO User_Group (group_name)
VALUES (groupName);
END;";

if (!$conn->query($addUserGroup))
{
    $result['addUserGroup'] = "Stored procedure creation of createUserGroup failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addUserGroup'] = "Stored procedure createUserGroup created successfully!";
}

// create procedure to add a user to a group
$addUserToGroup = "CREATE PROCEDURE addUserToGroup(
IN userId int,
IN groupId int)
BEGIN
UPDATE Users
SET group_id=groupId
WHERE user_id=userId;
END;";

if (!$conn->query($addUserToGroup))
{
    $result['addUserToGroup'] = "Stored Procedure creation of addUserToGroup failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addUserToGroup'] = "Stored Preocdure addUserToGroup created successfully!";
}

// create procedure to change a user's group
$changeUserGroup = "CREATE PROCEDURE changeUsersGroup(
IN userId int,
IN groupId int)
BEGIN
UPDATE Users
SET group_id = groupId
WHERE user_id = userId;
END;";

if (!$conn->query($changeUserGroup))
{
    $result['changeUserGroup'] = "Stored Procedure creation of changeUserGroup failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['changeUserGroup'] = "Stored Procedure changeUserGroup created successfully!";
}

// create procedure to add permissions to User Group
$addGroupPerm = "CREATE PROCEDURE addGroupPerm(
IN userID int,
IN permTypeID int,
IN permGroupID int,
IN userGroupID int)
BEGIN
INSERT INTO Permission_Mstr (user_id, perm_type_id, perm_group_id, user_group_id)
VALUES (userID, permTypeID, permGroupID, userGroupID);
END;";

if (!$conn->query($addGroupPerm))
{
    $result['addGroupPermission'] = "Stored procedure creation of addGroupPerm failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addGroupPermission'] = "Stored Procedure creation of addGroupPerm successful!";
}


// create procedure to add a Giver
$addGiver = "CREATE PROCEDURE addGiver(
IN lastName varchar(30),
IN firstName varchar(30),
IN eMail varchar(150),
IN homePhone varchar(13),
IN cellPhone varchar(13),
IN addressStreet varchar(50),
IN aptNo varchar(10),
IN City varchar(50),
IN State varchar(2),
IN Postal varchar(10),
IN wishesAnon bool)
BEGIN
INSERT INTO Giver (lastname, firstname, email, phone_home, phone_cell, address_street, apt_no, city, state, zip_code, wishes_anon)
VALUES (lastName, firstName, eMail, homePhone, cellPhone, addressStreet, aptNo, City, State, Postal, wishesAnon);
SELECT LAST_INSERT_ID();
END;";

if (!$conn->query($addGiver))
{
    $result['addGiver'] = "Stored Procedure creation of addGiver failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addGiver'] = "Stored Procedure creation of addGiver successful!";
}


// create procedure to add a Gift to a Giver
$addGiftToGiver = "CREATE PROCEDURE addGiftToGiver (IN giftID int, IN giverID int) BEGIN INSERT INTO Gifts (giver_id) VALUES (giverID) WHERE gift_id = giftID; END;";

if (!$conn->query($addGiftToGiver))
{
    $result['addGiftToGiver'] = "Stored Procedure creation of addGiftToGiver failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addGiftToGiver'] = "Stored Procedure addGiftToGiver created successfully!";
}

// create procedure to change Gift Status
$changeGiftStatus = "CREATE PROCEDURE changeGiftStatus(
IN giftID int,
IN gifrPulled bit,
IN giftRecvd bit, 
IN giftDelivered bit)
BEGIN
UPDATE Gifts
SET gift_pulled = giftPulled, gift_received = giftRecvd, gift_delivered = gift_delivered
WHERE gift_id = giftId;
END;";


if (!$conn->query($changeGiftStatus))
{
    $result['changeGiftStatus'] = "Stored Procedure creation of changeGiftStatus failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['changeGiftStatus'] = "Stored Procedure changeGiftStatus created successfully!";
}

// create procedure to add Delivery Information - used when a gift is sent out for delivery
$addDeliveryInfo = "CREATE PROCEDURE addDeliveryInfo(
IN deliveryId int,
IN delivererName varchar(60),
IN delivererPhone varchar(10),
IN giftId int)
BEGIN
INSERT INTO Delivery_Info (delivery_id, person_name, person_phone, gift_id)
VALUES (deliveryId, delivererName, delivererPhone, giftId);
END;";

if (!$conn->query($addDeliveryInfo))
{
    $result['addDeliveryInfo'] = "Stored Procedure creation of addDeliveryInfo failed: (" . $conn->errno . ") " . $conn->error;
} else {
    $result['addDeliveryInfo'] = "Stored Procedure addDeliveryInfo created successfully!";
}

// pull back users and their group from database
$getUsersAndGroups = "CREATE PROCEDURE getUsersAndGroups()
BEGIN
SELECT
User_Group.group_name,
Users.last_name,
Users.first_name,
Users.uname,
Users.email
FROM Users
INNER JOIN
User_Group
ON User_Group.group_id=Users.group_id;
END;";

if (!$conn->query($getUsersAndGroups))
{
    $result['getUsersAndGroups'] = "Stored Procedure getUsersAndGroups creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['getUsersAndGroups'] = "Stored Procedure getUsersAndGroups created successfully!";
}

// retrieve a list of recipients and gifts
$getRecipAndGifts = "CREATE PROCEDURE `getRecipAndGifts`()
BEGIN 
SELECT 
Recipients.main_id,
Gifts.gift_no, 
Gifts.description, 
Gifts.size, 
Gifts.gift_pulled,
Gifts.gift_received,
Gifts.gift_delivered,
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
    $result['getRecipAndGifts'] = "Stored Procedure getRecipAndGifts creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['getRecipAndGifts'] = "Stored Procedure getRecipAndGifts created successfully!";
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
-- Address info
ra.recip_address_id,
ra.street_address, 
ra.apt_no,
ra.neighborhood, 
ra.city, 
ra.state, 
ra.zip_code
FROM Recipients r
INNER JOIN Recip_Address ra
ON r.main_id=ra.main_id
WHERE
r.main_id = recipientId;
END;";

if (!$conn->query($getRecipient))
{
    $result['getRecipient'] = "Stored Procedure getRecipient creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['getRecipient'] = "Stored Procedure getRecipient created successfully!";
}

$updateGift = "CREATE PROCEDURE `updateGift`(
    IN giftId int, 
    IN giftNo int, 
    IN giftDescription varchar(500), 
    IN giftSize varchar(20), 
    IN mainId int, 
    IN giverId int,
    IN giftPulled bit,
    IN giftRecvd bit,
    IN giftDelivered bit)
BEGIN
    UPDATE `Gifts`
    SET
    gift_no = giftNo,
    description = giftDescription,
    size = giftSize,
    gift_pulled = giftPulled,
    gift_received = giftRecvd,
    gift_delivered = giftDelivered,
    main_id = mainId,
    giver_id = giverId
WHERE
    gift_id = giftNo;

SELECT giftNo as Id;
END;";

if (!$conn->query($updateGift))
{
    $result['updateGift'] = "Stored Procedure updateGift creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['updateGift'] = "Stored Procedure updateGift created successfully!";
}


$updateRecipient = "CREATE PROCEDURE `updateRecipient`(
    IN id int,
    IN lastName varchar(30), 
    IN firstName varchar(30), 
    IN sex varchar(1), 
    IN h_phone varchar(13), 
    IN c_phone varchar(13), 
    IN routeNo varchar(10))
BEGIN
    UPDATE `bastas`.`Recipients`
    SET lastname = lastName,
            firstname = firstname,
            gender = sex,
            home_phone = h_phone,
            cell_phone = c_phone,
            route_no = routeNo
    WHERE main_id = id;
    SELECT id AS Id;
END;";

if (!$conn->query($updateRecipient))
{
    $result['updateRecipient'] = "Stored Procedure updateRecipient creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['updateRecipient'] = "Stored Procedure updateRecipient created successfully!";
}

$updateAddress = "CREATE PROCEDURE `updateAddress`(
    IN id int, 
    IN streetAddress varchar(50), 
    IN aptNumber varchar(50), 
    IN neighborhood varchar(50), 
    IN city varchar(50), 
    IN state varchar(2), 
    IN zipCode varchar(10), 
    IN recipientId int)
BEGIN
    UPDATE `Recip_Address`
    SET street_address = streetAddress,
            apt_no = aptNumber,
            neighborhood = neighborhood, 
            city = city, 
            state = state, 
            zip_code = zipCode,
            main_id = recipientId
    WHERE recip_address_id = id;
    SELECT id AS Id;
END;";

if (!$conn->query($updateAddress))
{
    $result['updateAddress'] = "Stored Procedure updateAddress creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['updateAddress'] = "Stored Procedure updateAddress created successfully!";
}

$createRecipient = "CREATE PROCEDURE `createRecipient`(
    IN lastName varchar(30), 
    IN firstName varchar(30), 
    IN sex varchar(1), 
    IN h_phone varchar(13), 
    IN c_phone varchar(13), 
    IN routeNo varchar(10))
BEGIN
    INSERT `bastas`.`Recipients`
    (lastname,
    firstname,
    gender,
    home_phone,
    cell_phone,
    route_no,
    address_id)
    VALUES 
    (lastName,
    firstname,
    sex,
    h_phone,
    c_phone,
    routeNo,
    NULL);
    SELECT LAST_INSERT_ID() AS Id;
END;";

if (!$conn->query($createRecipient))
{
    $result['createRecipient'] = "Stored Procedure createRecipient creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['createRecipient'] = "Stored Procedure createRecipient created successfully!";
}

$deleteGift = "CREATE PROCEDURE `deleteGift`(IN giftId int)
BEGIN
    DELETE FROM `Gifts`
    WHERE gift_id = giftId;
    SELECT giftId AS Id;
END;";

if (!$conn->query($deleteGift))
{
    $result['deleteGift'] = "Stored Procedure deleteGift creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['deleteGift'] = "Stored Procedure deleteGift created successfully!";
}

$createAddress = "CREATE PROCEDURE `createAddress`(
    IN streetAddress varchar(50), 
    IN aptNumber varchar(50), 
    IN neighborhood varchar(50), 
    IN city varchar(50), 
    IN state varchar(2), 
    IN zipCode varchar(10), 
    IN recipientId int)
BEGIN
    INSERT INTO `Recip_Address`
    (
        street_address,
        apt_no,
        neighborhood,
        city,
        state,
        zip_code,
        main_id
    )
    VALUES
    (
        streetAddress,
        aptNumber,
        neighborhood, 
        city, 
        state, 
        zipCode,
        recipientId
    );
    SELECT LAST_INSERT_ID() AS Id;
END;";

if (!$conn->query($createAddress))
{
    $result['createAddress'] = "Stored Procedure createAddress creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['createAddress'] = "Stored Procedure createAddress created successfully!";
}

$createGift = "CREATE PROCEDURE `createGift`(
    IN giftNo int, 
    IN giftDescription varchar(500), 
    IN giftSize varchar(20), 
    IN mainId int, 
    IN giverId int,
    IN giftPulled bit,
    IN giftRecvd bit,
    IN giftDelivered bit)
BEGIN
    INSERT INTO `Gifts`
    (
        gift_no,
        description,
        size,
        main_id,
        giver_id,
        gift_pulled,
        gift_received,
        gift_delivered
    )
    VALUES
    (
        giftNo,
        giftDescription,
        giftSize,
        mainId,
        giverId,
        giftPulled,
        giftRecvd,
        giftDelivered
    );

    SELECT LAST_INSERT_ID() AS Id;
END;";

if (!$conn->query($createGift))
{
    $result['createGift'] = "Stored Procedure createGift creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['createGift'] = "Stored Procedure createGift created successfully!";
}

$getGifts = "CREATE PROCEDURE `getGifts`(IN recipientId int)
BEGIN
    SELECT 
    gift_id,
    gift_no,
    description,
    size,
    main_id,
    giver_id,
    gift_pulled,
    gift_received,
    gift_delivered
    FROM Gifts
    WHERE main_id = recipientId;
END";

if (!$conn->query($getGifts))
{
    $result['getGifts'] = "Stored Procedure getGifts creation failed : (" . $conn->errno . ")" . $conn->error;
} else {
    $result['getGifts'] = "Stored Procedure getGifts created successfully!";
}

?>