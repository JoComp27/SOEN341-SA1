<?php
/**
 * How to use:
 * 1- Refer to the readme XAMPP sql section for how to setup a mysql server
 * 2- In Xampp mysql, create a new database called "website_db"
 * 3- Run the github .sql query on XAMPP mysql to create tables for the newly created "website_db"
 * 4- Use the code below (include) to connect to the newly created database using PHP.
 * You may now perform server-side SQL queries on your local db website_db using additional PHP codes
 */
$user = 'root';
$password = '';
$database = 'website_db';

$db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

?>
