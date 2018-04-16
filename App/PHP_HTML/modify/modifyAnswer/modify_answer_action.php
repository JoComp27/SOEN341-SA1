<?php include('../../sql_connector.php'); ?>

<!-- PURPOSE: runs query that modifies an answer-->

<?php
$DELETED = 1;
$answerId = $_POST['answerId'];
$qus_id = $_POST['questionId'];
$newAnswerDescription = $_POST['description'];

$query = "UPDATE answers SET answers_content = '$newAnswerDescription' WHERE answers_id = '$answerId'";
mysqli_query($db, $query) or die(mysqli_error($db));
$redirect = 'Location: /SOEN341-SA1/App/PHP_HTML/answer/answer.php?id=' . $qus_id; // go back to question page once answer modified
header($redirect);
?>
