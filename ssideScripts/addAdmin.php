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