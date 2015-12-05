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
// This script will create the Recipient tables if they don't already exist.
// ************************************************************************


// ************************************************************************
// first we connect to the server and database by pulling the connection settings from
// the config.php file.
// ************************************************************************

$ini_array = parse_ini_file("php/src_files/config/config.php");

$ServerAddress = $ini_array['ServerName'];
$Username = $ini_array['Username'];
$Password = $ini_array['Password'];
$Database = $ini_array['Database'];

$make = new mysqli($ServerAddress, $Username, $Password, $Database);

if ($make->connect_error) 
{ 
    $result['Connection'] = "Connection failed: " . $make -> connect_error;
    echo json_encode($result);
    die("Connection failed: " . $make->connect_error);
} else {
    $result['Connection'] = "Connect to database successfully for Table Creation.";
}

// ************************************************************************
// Now we will create the tables. 
// ************************************************************************

// *****************************************************************
// Create the Givers Table
// ***************************************************************

$createTableNotes = "CREATE TABLE IF NOT EXISTS Notes (
    notes_id int auto_increment primary key,
    notes varchar(500) charset utf8,
    main_id int
    ) engine=InnoDB default charset latin1;";
    
    if ($make->query($createTableNotes) === TRUE) {
        $result['Notes'] = "Notes table created successfully!<br />";
    } else {
        $result['Notes'] = "Error creating Notes table.";
    }
        

// *****************************************************************
// Create the Recipients Table
// *****************************************************************

    $createTableRecipients = "CREATE TABLE IF NOT EXISTS Recipients (
        main_id int auto_increment primary key,
        lastname varchar(30) charset utf8,
        firstname varchar(30) charset utf8,
        gender varchar(1) charset utf8,
        home_phone varchar(13) charset utf8,
        cell_phone varchar(13) charset utf8,
        address_id int,
        route_no varchar(10) charset utf8
        ) engine=InnoDB default charset latin1;";
        
        
    if ($make->query($createTableRecipients) === TRUE) {
        $result['Recipients'] = "Recipients table created successfully!<br />";
    } else {
        $result['Recipietns'] = "Error creating Recipients table: " . $make->error;
    }
        
// *****************************************************************
// Create the Gifts Table
// *****************************************************************

    $createTableGifts = "CREATE TABLE IF NOT EXISTS Gifts (
    gift_id int auto_increment primary key,
    gift_no int,
    description varchar(500) charset utf8,
    size varchar(20) charset utf8,
    gift_pulled bit NOT NULL,
    gift_received bit NOT NULL, 
    gift_delivered bit NOT NULL,
    main_id int, 
    giver_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableGifts) === TRUE) {
        $result['Gifts'] = "Gifts table created successfully!<br />";
    } else {
        $result['Gifts'] = "Error creating Gifts table: " . $make->error;
    }
        

// *****************************************************************
// Create the Recipient Address Table
// *****************************************************************
    
    $createTableRecip_Address = "CREATE TABLE IF NOT EXISTS Recip_Address (
    recip_address_id int auto_increment primary key,
    street_address varchar(50) charset utf8,
    apt_no varchar(10) charset utf8,
    neighborhood varchar(50) charset utf8,
    city varchar(50) charset utf8,
    state varchar(2) charset utf8,
    zip_code varchar(10) charset utf8,
    main_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableRecip_Address) === TRUE) {
        $result['Recip_address'] = "Recipient Address table created successfully!<br />";
    } else {
        $result['Recip_address'] = "Error creating Recipient Address table: " . $make->error;
    }


// *****************************************************************
// Create the Delivery Information Table
// *****************************************************************
    
    $createTableDelivery_Info = "CREATE TABLE IF NOT EXISTS Delivery_Info (
    delivery_id int auto_increment primary key,
    person_name varchar(60) charset utf8,
    person_phone varchar(10) charset utf8,
    gift_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableDelivery_Info) === TRUE) {
        $result['Delivery_info'] = "Delivery Information table created successfully!<br />";
    } else {
        $result['Delivery_info'] = "Error creating Delivery Information table: " . $make->error;
    }


// *****************************************************************
// Create the Givers Table
// *****************************************************************
    
    $createTableGiver = "CREATE TABLE IF NOT EXISTS Giver (
    giver_id int auto_increment primary key,
    lastname varchar(30) charset utf8,
    firstname varchar(30) charset utf8,
    email varchar(150) charset utf8,
    phone_home varchar(13) charset utf8,
    phone_cell varchar(13) charset utf8,
    address_street varchar(50) charset utf8,
    apt_no varchar(10) charset utf8,
    city varchar(50) charset utf8,
    state varchar(2) charset utf8,
    zip_code varchar(10) charset utf8,
    wishes_anon boolean
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableGiver) === TRUE) {
        $result['Givers'] = "Giver table created successfully!<br />";
    } else {
        $result['Givers'] = "Error creating Giver table: " . $make->error;
    }


// *****************************************************************
// Create the Users Table
// *****************************************************************
    
    $createTableUsers = "CREATE TABLE IF NOT EXISTS Users (
    user_id int auto_increment primary key,
    last_name varchar(30) charset utf8,
    first_name varchar(30) charset utf8,
    company varchar(100) charset utf8,
    uname varchar(100) charset utf8,
    passw char(128),
    email varchar(150) charset utf8,
    group_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableUsers) === TRUE) {
        $result['Users'] = "Users table created successfully!<br />";
    } else {
        $result['Users'] = "Error creating Users table: " . $make->error;
    }
        
        
// *****************************************************************
// Create the Permission Master Table
// *****************************************************************
    
    $createTablePermission_Mstr = "CREATE TABLE IF NOT EXISTS Permission_Mstr (
    perm_mstr_id int auto_increment primary key,
    user_id int,
    perm_type_id int,
    perm_group_id int, 
    user_group_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTablePermission_Mstr) === TRUE) {
        $result['Permissions'] = "Permission Master table created successfully!<br />";
    } else {
        $result['Permissions'] = "Error creating Permission Master table: " . $make->error;
    }
        
        
// *****************************************************************
// Create the Permission Groups Table
// *****************************************************************

    $createTablePermission_Group = "CREATE TABLE IF NOT EXISTS Permission_Group (
    perm_group_id int auto_increment primary key,
    description varchar(30) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTablePermission_Group) === TRUE) {
        $result['PermissionGroup'] = "Permission Group table created successfully!<br />";
    } else {
        $result['PermissionGroup'] = "Error creating Permission Group table: " . $make->error;
    }
        

// *****************************************************************
// Create the Permission Type Table
// *****************************************************************

    $createTablePermission_Type = "CREATE TABLE IF NOT EXISTS Permission_Type (
    perm_type_id int auto_increment primary key,
    type varchar(20) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTablePermission_Type) === TRUE) {
        $result['PermissionType'] = "Permission Type table created successfully!<br />";
    } else {
        $result['PermissionType'] = "Error creating Permission Type table: " . $make->error;
    }
        
        
// *****************************************************************
// Create the User Groups Table
// *****************************************************************
    
    $createTableUser_Group = "CREATE TABLE IF NOT EXISTS User_Group (
    group_id int auto_increment primary key,
    group_name varchar(25) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableUser_Group) === TRUE) {
        $result['UserGroup'] = "User Group table created successfully!<br />";
    } else {
        $result['UserGroup'] = "Error creating User Group table: " . $make->error;
    }

// *****************************************************************
// Create the Home Page Settings Table
// *****************************************************************
    
    $createTableHomePage_Settings = "CREATE TABLE IF NOT EXISTS HomePage (
    homePage_id int auto_increment primary key,
    descriptionOne varchar(1000) charset utf8,
    descriptionTwo varchar(1000) charset utf8,
    backgroundPhoto varchar(255) charset utf8,
    giver_instructions varchar(1000) charset utf8,
    information_pane varchar(1000) charset utf8,
    extra_information varchar(1000) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableHomePage_Settings) === TRUE) {
        $result['HomePage'] = "Home page settings table created successfully!<br />";
    } else {
        $result['HomePage'] = "Error creating Home Settings: " . $make->error;
    }

// *****************************************************************
// Create an activity Log Table
// *****************************************************************

    $createActivityLogTable = "CREATE TABLE IF NOT EXISTS ActivityLog (
    log_id int auto_increment primary key,
    user_id int,
    main_id int,
    gift_id int,
    giver_id int,
    delivery_id int,
    dateOfActivity datetime NOT NULL DEFAULT Now(),
    log_notes varchar(500),
    ip_address varchar(20)
    ) engine=InnoDB default charset latin1;";

    if ($make->query($createActivityLogTable) === TRUE) {
        $result['ActivityLog'] = "Activity Log table created successfully!<br />";
    } else {
        $result['ActivityLog'] = "Error creating Activity Log table: " . $make->error;
    }


echo json_encode($result);
    $make->close();

?>