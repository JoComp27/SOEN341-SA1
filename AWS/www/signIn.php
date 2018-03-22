<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include("sql_connector.php");

if (isset($_SESSION['auth'])) {
    include "signIn_2.php";
} else {
    include "signIn_1.php";
}
?>