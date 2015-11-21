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

/*global $:false */ //this simply keeps the $ for jQuery from showing as an error in linter.

$("document").ready(function () {
$("#next_step").hide();
$("#createAdmin").hide();
$("#finishButton").hide();
    
    $("#formDiv").load("install/installDB.html");
    
    
    //*********************************************************
    // First we want to have the sripte recognize the click of
    // our Next button so we can perform actions based on it.
    //*********************************************************
    
    $("#install_step").click(function () {

        //*********************************************************
        // Now we'll set our server variables to post to php.
        //*********************************************************
        
        var serverName = $("#server_name_input").val();
        var userName = $("#user_name_input").val();
        var userPass = $("#user_pass_input").val();

        // console.log("click function reached!");

        
        //*********************************************************
        // We use ajax to post our data to the php file and then
        // append the error or success message into our install
        // page.
        //*********************************************************
        
        $.ajax("ssideScripts/database_info.php", {
            data: {
                server_name_input: serverName,
                user_name_input: userName,
                user_pass_input: userPass
            },
            type: "POST",
            beforeSend: function () {
                console.log("About to Post using ajax.");
            },
            error: function () {
                console.log("An error occurred on ajax post.");
                $("#Results").append($("An error occurred creating the database."));
            },
            success: function () {
                console.log("Post action successful.");
                console.log("Calling to create Tables.");
                $("#Results").append($("<div>Database created successfully. <br /></div>"));
                $("#server_name_input").val("");
                $("#user_name_input").val("");
                $("#user_pass_input").val("");
                callCreateTable();
            }
        });
    });
    
    
    //*********************************************************
    // listen for the click of the Next button.
    //*********************************************************
    $("#next_step").click(function() {
        $("#formDiv").load("install/createAdmin.html");
        $("#next_step").hide();
        $("#createAdmin").show();
    });
    
    //*********************************************************
    // listens for the click of the Create button for creating
    // an administrative user.
    //*********************************************************
    
    $("#createAdmin").click(function() {
        
        var adminUsername = $("#admin_user_name").val();
        var lastName = $("#admin_last_input").val();
        var firstName = $("#admin_first_input").val();
        var emailAdd = $("#admin_email_input").val();
        var company = $("#admin_company_input").val();
        var passCode = $("#admin_password_input").val();
        
        console.log("Inside createAdmin click function.");
        $.ajax("ssideScripts/addAdmin.php", {
         data: {
                admin_user_name: adminUsername,
                admin_last_input: lastName,
                admin_first_input: firstName,
                admin_email_input: emailAdd,
                admin_company_input: company,
                admin_password_input: passCode
            },
            type: "POST",
            beforeSend: function () {
                console.log("About to Post Admin create using ajax.");
            },
            error: function() {
              console.log("An error occurred while creating Admin user.");  
            },
            success: function() {
                console.log("Post action successful for create Admin.");
                console.log("Taking user to home page.");
                $("#Results").append($("<div>Admin User created successfully. <br /></div>"));
                $("#admin_user_name").val("");
                $("#admin_last_input").val("");
                $("#admin_first_input").val("");
                $("#admin_email_input").val("");
                $("#admin_company_input").val("");
                $("#admin_password_input").val("");
                $("#createAdmin").hide();
                $("#finishButton").show();
            }
        });
    });

});


//*********************************************************
// Functions called in order after initial post. Each
// function should be called on success call back.
//*********************************************************

var callCreateTable = function () {
    $.ajax("ssideScripts/CreateTables.php", {

        beforeSend: function () {
            console.log("About to create Tables using ajax.");
        },
        error: function () {
            console.log("An error occurred while creating tables with ajax.");
        },
        success: function () {
            console.log("Table Creation action successful.");
            console.log("Calling to create Stored Procs.");
            $("#Results").append($("<div>Tables created successfully. <br /></div>"));
            callCreateStoredProcs();

        }
    });
};

var callCreateStoredProcs = function () {
    $.ajax("ssideScripts/CreateStoredProcs.php", {

        beforeSend: function () {
            console.log("About to create stored procs using ajax.");
        },
        error: function () {
            console.log("An error occurred while creating stored procs with ajax.");
        },
        success: function () {
            console.log("Stored proc action successful.");
            console.log("Calling to insert default data.");
            $("#Results").append($("<div>Stored Procedures created successfully. <br /></div>"));
            callAddBaseData();

        }
    });
};

var callAddBaseData = function () {
    $.ajax("ssideScripts/AddBaseData.php", {

        beforeSend: function () {
            console.log("About to insert base data using ajax.");
        },
        error: function () {
            console.log("An error occurred while inserting base data with ajax.");
        },
        success: function () {
            console.log("Base data insert action successful.");
            $("#Results").append($("<div>Default data inserted successfully. <br /><br />Click Next below to continue.<br /></div>"));
            $("#install_step").hide();
            $("#next_step").show();
        }
    });
};
