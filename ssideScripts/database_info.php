<?php 

$db_server = $_POST['server_name_input']; 
$db_user = $_POST['user_name_input']; 
$db_passwrd = $_POST['user_pass_input']; 

$db_name="bastas";

$conn = new mysqli($db_server, $db_user, $db_passwrd);

// *****************************************************************
// Check connection ability
// *****************************************************************

    if ($conn->connect_error) 
    { 
        die("Connection failed: " . $conn->connect_error); 
    } else { 
        echo "Connected successfully"; 
        echo "<br /><br />";
    
// *****************************************************************    
// If the connection ability was good, create the Database
// *****************************************************************
        
    echo "Stand by ..<br />"; 
    echo "Creating the database, tables, and prefilling important data.<br />"; 
    echo "<br />";
    
    $CreateDB="CREATE DATABASE IF NOT EXISTS bastas";
    
    if ($conn->query($CreateDB) === TRUE) {
        echo "Database Created Successfully!";
    } else {
        echo "Error Creating Database: " . $conn->error;
        echo "<br />";
    }
    
    echo "<br /><br />";
    $conn->close();

// *****************************************************************
// Create the Notes table after creating the database
// *****************************************************************
        
    echo "Creating Tables...<br />";
    echo "<br />";
    
    $make = new mysqli($db_server, $db_user, $db_passwrd, $db_name);
    
    $createTableNotes = "CREATE TABLE IF NOT EXISTS Notes (
    notes_id int auto_increment primary key,
    notes varchar(500) charset utf8,
    main_id int
    ) engine=InnoDB default charset latin1;";
    
    if ($make->query($createTableNotes) === TRUE) {
        echo "Notes table created successfully!<br />";
    } else {
        echo "Error creating Notes table: " . $make->error;
        echo "<br />";
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
        echo "Recipients table created successfully!<br />";
    } else {
        echo "Error creating Recipients table: " . $make->error;
        echo "<br />";
    }
        
// *****************************************************************
// Create the Gifts Table
// *****************************************************************

    $createTableGifts = "CREATE TABLE IF NOT EXISTS Gifts (
    gift_id int auto_increment primary key,
    gift_no int,
    description varchar(500) charset utf8,
    size varchar(20) charset utf8,
    main_id int,
    status_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableGifts) === TRUE) {
        echo "Gifts table created successfully!<br />";
    } else {
        echo "Error creating Gifts table: " . $make->error;
        echo "<br />";
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
        echo "Recipient Address table created successfully!<br />";
    } else {
        echo "Error creating Recipient Address table: " . $make->error;
        echo "<br />";
    }
        

// *****************************************************************
// Create the Gift Status Table
// *****************************************************************
    
    $createTableGift_Status = "CREATE TABLE IF NOT EXISTS Gift_Status (
    status_id int auto_increment primary key,
    status varchar(50) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableGift_Status) === TRUE) {
        echo "Gift Status table created successfully!<br />";
    } else {
        echo "Error creating Gift Status table: " . $make->error;
        echo "<br />";
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
    wishes_anon boolean,
    gift_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableGiver) === TRUE) {
        echo "Giver table created successfully!<br />";
    } else {
        echo "Error creating Giver table: " . $make->error;
        echo "<br />";
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
        echo "Delivery Information table created successfully!<br />";
    } else {
        echo "Error creating Delivery Information table: " . $make->error;
        echo "<br />";
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
    email varchar(150) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableUsers) === TRUE) {
        echo "Users table created successfully!<br />";
    } else {
        echo "Error creating Users table: " . $make->error;
        echo "<br />";
    }
        
        
// *****************************************************************
// Create the Permission Master Table
// *****************************************************************
    
    $createTablePermission_Mstr = "CREATE TABLE IF NOT EXISTS Permission_Mstr (
    perm_mstr_id int auto_increment primary key,
    user_id int,
    perm_type_id int,
    perm_group_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTablePermission_Mstr) === TRUE) {
        echo "Permission Master table created successfully!<br />";
    } else {
        echo "Error creating Permission Master table: " . $make->error;
        echo "<br />";
    }
        
        
// *****************************************************************
// Create the Permission Groups Table
// *****************************************************************

    $createTablePermission_Group = "CREATE TABLE IF NOT EXISTS Permission_Group (
    perm_group_id int auto_increment primary key,
    description varchar(30) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTablePermission_Group) === TRUE) {
        echo "Permission Group table created successfully!<br />";
    } else {
        echo "Error creating Permission Group table: " . $make->error;
        echo "<br />";
    }
        

// *****************************************************************
// Create the Permission Type Table
// *****************************************************************

    $createTablePermission_Type = "CREATE TABLE IF NOT EXISTS Permission_Type (
    perm_type_id int auto_increment primary key,
    type varchar(20) charset utf8
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTablePermission_Type) === TRUE) {
        echo "Permission Type table created successfully!<br />";
    } else {
        echo "Error creating Permission Type table: " . $make->error;
        echo "<br />";
    }
        
        
// *****************************************************************
// Create the User Groups Table
// *****************************************************************
    
    $createTableUser_Group = "CREATE TABLE IF NOT EXISTS User_Group (
    group_id int auto_increment primary key,
    group_name varchar(25) charset utf8,
    user_id int
    ) engine=InnoDB default charset latin1;";
        
    if ($make->query($createTableUser_Group) === TRUE) {
        echo "User Group table created successfully!<br />";
    } else {
        echo "Error creating User Group table: " . $make->error;
        echo "<br />";
    }
        
        
// *****************************************************************
// Create the default base data in the tables
// *****************************************************************

    $addData = "INSERT INTO BASTAS.Permission_Type SET type='Add';";
    $addData .= "INSERT INTO Permission_Type SET type='View';";
    $addData .= "INSERT INTO Permission_Type SET type='Edit';";
    $addData .= "INSERT INTO Permission_Type SET type='Delete';";
    $addData .= "INSERT INTO Permission_Type SET type='Print';";

    $addData .= "INSERT INTO Permission_Group SET description='Giver';"/
    $addData .= "INSERT INTO Permission_Group SET description='Users';";
    $addData .= "INSERT INTO Permission_Group SET description='Groups';";
    $addData .= "INSERT INTO Permission_Group SET description='Gifts';";
    $addData .= "INSERT INTO Permission_Group SET description='Recipients';";
    $addData .= "INSERT INTO Permission_Group SET description='Recipient Addresses';";
    $addData .= "INSERT INTO Permission_Group SET description='Gift Status';";
    $addData .= "INSERT INTO Permission_Group SET description='Delivery Info';";
    $addData .= "INSERT INTO Permission_Group SET description='Notes';";
    
    if ($make->multi_query($addData) === TRUE) {
        echo "Default Records have been added successfully!<br /><br />";
    } else {
        echo "Error adding default records: " . $make->error;
    }


    echo "<br /><br />";
    $make->close();
        
// *****************************************************************        
// Create the Configuration File to Store DB creds section 1
// *****************************************************************
        
$headSection1 = "[Server Login]\n";
$serverInfo = "ServerAddress = $db_server\n";
$userInfo = "Username = $db_user\n";
$passInfo = "Password = $db_passwrd\n";
$databaseInfo = "Database = $db_name\n\n";

$myfile = fopen("php/src_files/config/config.php", "w") or die("Unable to open file! Please ensure the folder php/src_files/config exists, and is writeable by the application.");

fwrite($myfile, $headSection1);
fwrite($myfile, $serverInfo);
fwrite($myfile, $userInfo);
fwrite($myfile, $passInfo);
fwrite($myfile, $databaseInfo);

echo "Configuration file created successfully!";

fclose($myfile);


    }

?>