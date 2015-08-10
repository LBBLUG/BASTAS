<?php


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
    die("Connection failed: " . $make->connect_error);
} else { 
    echo "Connected successfully"; 
    echo "<br /><br />";
}

// ************************************************************************
// Now we will Add data to some of the tables
// ************************************************************************

        
    // *****************************************************************
    // Create the default base data in the tables
    // *****************************************************************

        $addData = "INSERT INTO Permission_Type SET type='Add';";
        $addData .= "INSERT INTO Permission_Type SET type='View';";
        $addData .= "INSERT INTO Permission_Type SET type='Edit';";
        $addData .= "INSERT INTO Permission_Type SET type='Delete';";
        $addData .= "INSERT INTO Permission_Type SET type='Print';";

        $addData .= "INSERT INTO Permission_Group SET description='Giver';";
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

?>
