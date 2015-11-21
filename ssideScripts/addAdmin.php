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

    // this script will run the stored procedure to
    // create an admin user

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

$admin_user_name = $_POST['admin_user_name'];
$admin_last_input = $_POST['admin_last_input'];
$admin_first_input = $_POST['admin_first_input'];
$admin_email_input = $_POST['admin_email_input'];
$admin_company_input = $_POST['admin_company_input'];
$admin_password_input = $_POST['admin_password_input'];

/*$admin_user_name = "'TBuagh'";
$admin_last_input = "'Baugh'";
$admin_first_input = "'Terry'";
$admin_email_input = "'tbaugh@me.com'";
$admin_company_input = "'Home Instead Senior Care'";
$admin_password_input = "'password'";*/

if (!$conn->query("CALL createAdminUser('". $admin_last_input ."', '". $admin_first_input ."', '". $admin_company_input ."', '". $admin_user_name ."', '". $admin_password_input ."', '". $admin_email_input. "');")) {
    echo "CALL createAdminUser failed: (" . $conn->errno . ") " . $conn->error;
} else {
    echo "Admin Created Successfully!";
}

?>