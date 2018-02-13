<!DOCTYPE html>
<html>
<head>
    <script src="ask_question.js"></script>
    <?php include "header.php" ?>
</head>
<body>
<?php
    $title = $_POST["title"];
    $details = $_POST["details"];
    $sql = "INSERT INTO questions (question_title, question_description, question_date) VALUES (\"$title\", \"$details\", NOW())";
    $db->query($sql);
    CloseCon(db);
    echo "<div class='alert alert-success'><strong>Error!</strong> Please Log in/Sign up to post a question.</div>"
?>
</body>
</html>