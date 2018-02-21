<?php
$user   = 'root';
$password   = '';
$database   = 'website_db';

$db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

$sql = "SELECT user_id, active FROM loggedin";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc())
        $r = $row;
    if ($r["active"] == 1) {
        include "signIn_2.php";
    } else {
        include "signIn_1.php";
    }
}
else {
    header('Location: signIn_1.php');
    exit;
}
?>