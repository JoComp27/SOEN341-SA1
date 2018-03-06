<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="ask_question.js"></script>
    <?php include "header.php" ?>
</head>
<body>
<?php

if (isset($_SESSION['auth'])) {
    $title = $_POST["title"];
    $details = $_POST["details"];
    $t = $_SESSION['user_id'];
    $question_by_user = $_SESSION['user_name'];
    $sql = "INSERT INTO questions (question_by, question_title, question_description, question_date, question_by_user) VALUES ($t, \"$title\", \"$details\", NOW(), '$question_by_user')";
    $db->query($sql);

    $sql = "select question_id from questions where question_by = \"$t\" and question_title = \"$title\"";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['question_id'];
    $url = "Location: answer.php?id=$id";
    header($url);
} else {
    echo "<div class='alert alert-danger'><strong>Error!</strong> Please Log in/Sign up to post a question.</div>";
}

?>
</body>
</html>