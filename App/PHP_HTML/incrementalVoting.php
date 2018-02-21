<?php 
include_once('sql_connector.php');

$id = $_POST['value'];
$result =$db->query("select * from answers where answers_id='$id'");
$row = $result->fetch_assoc();
$valueAfterUpdate = $row['answers_upvotes']+1;
$db->query("update answers set answers_upvotes='$valueAfterUpdate' where answers_id='$id'");


?>