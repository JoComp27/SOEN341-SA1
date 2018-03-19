<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('sql_connector.php');

$id = $_POST['value'];
$userId = $_SESSION['user_id'];
$result = $db->query("select * from answers where answers_id='$id'");
$row = $result->fetch_assoc();
$result = $db->query("SELECT count(1) from answers_userdislikes where user_id='$user_id'");
$isPresent = mysqli_num_fields($result);
if ($isPresent == 0) {
    $valueAfterUpdate = $row['answers_upvotes'] + 1;
    $db->query("update answers set answers_downvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("INSERT INTO answers_userdislikes VALUES ('$id','$userId')");
} else {
    $valueAfterUpdate = $row['answers_upvotes'] - 1;
    $db->query("update answers set answers_downvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("DELETE FROM answers_userdislikes VALUES ('$id','$userId')");
}
?>