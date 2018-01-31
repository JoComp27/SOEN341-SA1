<?php
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = '1308';
$database   = 'okapi_db';
 
if(!mysql_connect($server, $username,  $password))
{
    exit('Error: could not establish database connection');
}
if(!mysql_select_db($database)
{
    exit('Error: could not select the database');
}
?>