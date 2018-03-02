<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>

<?php
include ("../sqL_connector.php");

    if (isset($_SESSION)) {
        include "signIn_2.php";
    } 
	else {
        include "signIn_1.php";
    }
?>