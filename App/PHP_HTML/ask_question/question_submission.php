<html>
<head>
    <script src="ask_question.js"></script>
</head>
<body>
<?php
    include "db_connection.php";
    $title = $_POST["title"];
    $details = $_POST["details"];
    $sql = "INSERT INTO questions (question_title, question_description, question_date) VALUES (\"$title\", \"$details\", NOW())";
    $db->query($sql);
    CloseCon($db);
?>
</body>
</html>
