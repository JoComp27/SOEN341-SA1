<?php
include_once('sql_connector.php');

$id = $_POST['value'];
$result = $db->query("select * from answers where answers_id='$id'");
$row = $result->fetch_assoc();
$valueBeforeUpdate = $row['answers_downvotes'] + 1;
$db->query("update answers set answers_downvotes='$valueBeforeUpdate' where answers_id='$id'");


?>