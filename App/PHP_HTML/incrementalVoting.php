<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('sql_connector.php');

$id = $_POST['value'];
$userId = $_SESSION['user_id'];
$result = $db->query("select * from answers where answers_id='$id'");
$row = $result->fetch_assoc();
$result = $db->query("SELECT count(1) from answers_userlikes where user_id='$user_id' AND answer_id='$id'");
$isLiked = mysqli_fetch_array($result);
$result = $db->query("SELECT count(1) from answers_userdislikes where user_id='$user_id' AND answer_id='$id'");
$isDisliked = mysqli_fetch_array($result);
if ($isLiked[0] == 0 && $isDisliked[0] == 0) {
    $valueAfterUpdate = $row['answers_upvotes'] + 1;
    $db->query("update answers set answers_upvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("INSERT INTO answers_userlikes (answer_id, user_id) VALUES ('$id','$userId')");
} else if ($isLiked[0] == 0) {
    $valueAfterUpdate = $row['answers_upvotes'] + 1;
    $valueAfterUpdateDis = $row['answers_downvotes'] - 1;
    $db->query("update answers set answers_upvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("update answers set answers_downvotes='$valueAfterUpdateDis' where answers_id='$id'");
    $db->query("INSERT INTO answers_userlikes (answer_id, user_id) VALUES ('$id','$userId')");
    $db->query("DELETE FROM answers_userdislikes WHERE answer_id='$id' AND user_id='$userId'");
} else {
    $valueAfterUpdate = $row['answers_upvotes'] - 1;
    $db->query("update answers set answers_upvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("DELETE FROM answers_userlikes WHERE answer_id='$id' AND user_id='$userId'");
}
?>