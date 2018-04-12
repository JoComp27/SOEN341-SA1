<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include("sqL_connector.php");

if (isset($_SESSION['auth'])) {
    include "home.php";
} else {
    include "sign_in_normal.php";
}
?>