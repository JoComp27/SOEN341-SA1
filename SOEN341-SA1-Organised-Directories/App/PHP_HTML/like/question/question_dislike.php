<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('../../sql_connector.php');

$id = $_POST['value'];
$userId = $_SESSION['user_id'];
$result = $db->query("select * from questions  where question_id='$id'");
$row = $result->fetch_assoc();
$query = "SELECT * from question_userlikes where user_id='$userId' AND question_id='$id'";
$result = mysqli_query($db, $query);
$isLiked = mysqli_num_rows($result);
$query = "SELECT * from question_userdislikes where user_id='$userId' AND question_id='$id'";
$result = mysqli_query($db, $query);
$isDisliked = mysqli_num_rows($result);
if ($isLiked == 0 && $isDisliked == 0) {
    $valueAfterUpdate = $row['question_downvotes'] + 1;
    $db->query("update questions set question_downvotes='$valueAfterUpdate' where question_id='$id'");
    $db->query("INSERT INTO question_userdislikes (question_id, user_id) VALUES ('$id','$userId')");
} else if ($isDisliked == 0) {
    $valueAfterUpdate = $row['question_downvotes'] + 1;
    $valueAfterUpdatelik = $row['question_upvotes'] - 1;
    $db->query("update questions set question_downvotes='$valueAfterUpdate' where question_id='$id'");
    $db->query("update questions set question_upvotes='$valueAfterUpdatelik' where question_id='$id'");
    $db->query("INSERT INTO question_userdislikes (question_id, user_id) VALUES ('$id','$userId')");
    $db->query("DELETE FROM question_userlikes WHERE question_id='$id' AND user_id='$userId'");
} else {
    $valueAfterUpdate = $row['question_downvotes'] - 1;
    $db->query("update questions set question_downvotes='$valueAfterUpdate' where question_id='$id'");
    $db->query("DELETE FROM question_userdislikes WHERE question_id='$id' AND user_id='$userId'");
}
?>