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

function validate_serverName() {

    var missingServerName = "false";
    var missingUsername = "false";
    var missingPassword = "false"
    
    // first we check each field to see if it has data...
    // and if it does, then we save that data to a variable 
    // name to work with later.
    //
    if (document.getElementById("server_name_input") != null) {
        var serverName = document.getElementById("server_name_input").value;
    }
    
    if (document.getElementById("user_name_input") != null) {
        var serverUName = document.getElementById("user_name_input").value;
    }
    
    if (document.getElementById("user_pass_input") != null) {
        var serverPword = document.getElementById("user_pass_input").value;
    }
    
    // next we check each field again to see if it has data
    // in a slightly different way, and if not, we color the
    // field border red, and set a flag to display a warning
    // or error message below the buttons.
    // 
    if (serverName == null || serverName == "") {
        missingServerName = "true";
        console.log("Server Name Entered: " + missingServerName);
        document.getElementById("server_name_input").style.borderColor = "red";
    } else {
        missingServerName = "false";
        console.log("Server Name Entered: " + missingServerName);
        document.getElementById("server_name_input").style.borderColor = "#c1c1c1";
    }
    
    if (serverUName == null || serverUName == "") {
        document.getElementById("user_name_input").style.borderColor = "red"
        missingUsername = "true";
        console.log("Username Entered: " + missingUsername);
    } else {
        missingUsername = "false";
        console.log("Username Entered: " + missingUsername);
        document.getElementById("user_name_input").style.borderColor = "#c1c1c1";
    }
    
    if (serverPword == null || serverPword == "") {
        document.getElementById("user_pass_input").style.borderColor = "red"
        missingPassword = "true";
        console.log("Password Entered: " + missingPassword);
    } else {
        missingPassword = "false";
        console.log("Password Entered: " + missingPassword);
        document.getElementById("user_pass_input").style.borderColor = "#c1c1c1";
    }
    
    
    // now we check to see if our warning or error flag is
    // set, and if so, we insert our warning text into the 
    // webpage to be displayed.
    //
    
    if ((missingServerName == "true") || (missingUsername == "true") || (missingPassword == "true")){
        console.log("Made it into Missing Data.");
        document.getElementById("warnAndErr").innerHTML = "You appear to be missing information in a required field.  Please fill in the information in fields makred in red, then attempt to continue.";
        return false;
    } else {
        document.getElementById("warnAndErr").innerHTML = "";
        return true;
    }
}

// We set the window.onload event to allow us to trigger our
// function above when the 'Next >>' button is clicked on 
// our webpage.
//
//window.onload = function () {
//
//    document.getElementById("next_step").onclick=validate_serverName;
//
//}