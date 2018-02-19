<!DOCTYPE html>
<html>
<head>
    <script src="ask_question.js"></script>
    <?php include "header.php" ?>
</head>
<body>
    <?php
        $sql = "SELECT user_id, active FROM loggedin";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
                $r = $row;
            if ($r["active"] == 1) {
                $title = $_POST["title"];
                $details = $_POST["details"];
                $t = $r["user_id"];
                $sql = "INSERT INTO questions (question_by, question_title, question_description, question_date) VALUES ($t, \"$title\", \"$details\", NOW())";
                $db->query($sql);
                echo "<div class='alert alert-success'><strong>Sucess!</strong> Your question was submitted! Return to the questions page <a href=\"home.php\">here</a> to see it.</div>";
            }
            else {
                echo "<div class='alert alert-danger'><strong>Error!</strong> Please Log in/Sign up to post a question.</div>";
            }
        }else {
            echo "<div class='alert alert-danger'><strong>Error!</strong> Please Log in/Sign up to post a question.</div>";
        }
    ?>
</body>
</html>