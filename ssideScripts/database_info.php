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

<?php

$db_server = $_POST['server_name_input']; 
$db_user = $_POST['user_name_input']; 
$db_passwrd = $_POST['user_pass_input']; 

$db_name="bastas";
echo "Connecting to database...";

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
// Create the Configuration File to Store DB creds section 1
// *****************************************************************
        
$headSection1 = "[Server Login]\n";
$serverInfo = "ServerAddress = \"$db_server\"\n";
$userInfo = "Username = \"$db_user\"\n";
$passInfo = "Password = \"$db_passwrd\"\n";
$databaseInfo = "Database = \"$db_name\"\n\n";

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
