<html>
<head>
    <script src="ask_question.js"></script>
</head>
<body>
<?php
    include "db_connection.php";
    $conn = OpenCon();
    $title = $_POST["title"];
    $details = $_POST["details"];
    $sql = "INSERT INTO questions (question_title) VALUES (\"$title\")";
    $sql2 = "INSERT INTO questions (question_description) VALUES (\"$details\")";
    $conn->query($sql);
    $conn->query($sql2);
    CloseCon($conn);
?>
</body>
</html>
