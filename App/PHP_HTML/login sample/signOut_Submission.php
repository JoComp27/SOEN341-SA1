<?php
$user   = 'root';
$password   = '';
$database   = 'website_db';

$db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

$sql = "SELECT user_id, active, logged_out FROM loggedin";
$result = $db->query($sql);
if ($result->num_rows > 0)
    while ($row = $result->fetch_assoc())
        $r = $row;
$name = $r['user_id'];
$sql = "UPDATE loggedin SET active = 0, logged_out = NOW() WHERE user_id = \"$name\"";
$db->query($sql);
header('Location: ../home.php');
exit;
?>