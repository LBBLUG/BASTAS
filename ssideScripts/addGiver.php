<?php

    require_once("databaseUtilities.php");

    $databaseUtil = new DatabaseUtility();

    $lastName = $_POST['lastName']; 
    $firstName = $_POST['firstName'];
    $streetAddress = $_POST['address.street'];
    $aptNo = $_POST['address.apt'];
    $city = $_POST['address.city'];
    $state = $_POST['address.state'];
    $zip = $_POST['address.zip'];
    $email = $_POST['email'];
    $homePhone = $_POST['homePhone'];
    $cellPhone = $_POST['cellPhone'];
    $anonymous = $_POST['anonymous'];

    $resultSet = $databaseUtil->ExecuteStoredProcedure("addGiver()", $lastName, $firstName, $email, $homePhone, $cellPhone, $streetAddress, $aptNo, $city, $state, $zip, $anonymous);

    echo json_encode(array("data" => $resultSet));
    http_response_code(201);
?>