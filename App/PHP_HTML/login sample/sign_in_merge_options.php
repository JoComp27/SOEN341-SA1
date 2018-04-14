<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include("../sql_connector.php");

if (isset($_SESSION['auth'])) {
    include "sign_in_already_signed.php";
} else {
    include "sign_in_normal.php";
}
?>