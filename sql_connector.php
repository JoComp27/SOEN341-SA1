<?php
/**
 * How to use:
 * 1- Refer to the readme XAMPP sql section for how to setup a mysql server
 * 2- In Xampp mysql, create a new database called "website_db"
 * 3- Run the github .sql query on XAMPP mysql to create tables of "website_db"
 * 4- Include this code to connect to the newly created database using PHP. You can know add, remove, etc. data from PHP to mysql
 * User: Ming Tao Yu
 * Date: 1/28/2018
 * Time: 3:29 PM
 * Xampp mysel server
 */

$user   = 'root';
$password   = '';
$database   = 'website_db';

$db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

?>