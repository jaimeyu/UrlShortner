<?php
//error catch
$epicfail = false; //if everything goes well, this stays false
$failreason = '';

//database info
$dbserver = "";
$dbuser = "";
$dbpass = "";
$dbname= "";

// old way - sql injection vulnerable
$dbconnection = mysql_connect($dbserver, $dbuser, $dbpass );
if ( $dbconnection == true ) {

    mysql_select_db($dbname, $dbconnection );
    
}
else {

    die("Error connecting to database: " . mysql_error() ); //
    $epicfail = true;
    $failreason = "Error connecting to database: " . mysql_error();
    //insert into fail table
}

//protect from sql injection
//http://mattbango.com/notebook/web-development/prepared-statements-in-php-and-mysqli/
/*
$mysqli = new mysql($dbserver, $dbuser, $dbpassword, $dbname);

   if(mysqli_connect_errno()) {
      echo "Connection Failed: " . mysqli_connect_errno();
      exit();
   }
*/
?>