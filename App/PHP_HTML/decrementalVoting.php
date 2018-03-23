<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('sql_connector.php');

$id = $_POST['value'];
$userId = $_SESSION['user_id'];
$result = $db->query("select * from answers where answers_id='$id'");
$row = $result->fetch_assoc();
$query = "SELECT * from answers_userlikes where user_id='$userId' AND answer_id='$id'";
$result = mysqli_query($db, $query);
$isLiked = mysqli_num_rows($result);
$query = "SELECT * from answers_userdislikes where user_id='$userId' AND answer_id='$id'";
$result = mysqli_query($db, $query);
$isDisliked = mysqli_num_rows($result);
if ($isDisliked == 0 && $isLiked == 0) {
    $valueAfterUpdate = $row['answers_downvotes'] + 1;
    $db->query("update answers set answers_downvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("INSERT INTO answers_userdislikes (answer_id, user_id) VALUES ('$id','$userId')");
} else if ($isDisliked == 0) {
    $valueAfterUpdate = $row['answers_upvotes'] - 1;
    $valueAfterUpdateDis = $row['answers_downvotes'] + 1;
    $db->query("update answers set answers_downvotes='$valueAfterUpdateDis' where answers_id='$id'");
    $db->query("update answers set answers_upvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("INSERT INTO answers_userdislikes (answer_id, user_id) VALUES ('$id','$userId')");
    $db->query("DELETE FROM answers_userlikes WHERE answer_id='$id' AND user_id='$userId'");
} else {
    $valueAfterUpdate = $row['answers_downvotes'] - 1;
    $db->query("update answers set answers_downvotes='$valueAfterUpdate' where answers_id='$id'");
    $db->query("DELETE FROM answers_userdislikes WHERE answer_id='$id' AND user_id='$userId'");
}
?>