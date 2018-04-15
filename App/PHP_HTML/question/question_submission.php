<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <!--    <script src="question_ask_button.js"></script>-->
    <?php include "header.php" ?>
</head>
<body>
<?php

if (isset($_SESSION['auth'])) {
    $title = $_POST["title"];
    $details = mysqli_real_escape_string($db, $_POST["details"]);
    $user_id = $_SESSION['user_id'];
    $tags = $_POST["tags"];
    $question_by_user = $_SESSION['user_name'];

    $sql = "INSERT INTO questions (question_by, question_title, question_description, question_date, question_by_user) VALUES ($user_id, \"$title\", \"$details\", NOW(), '$question_by_user')";
    $db->query($sql);

    // increase users question count
    $sql = "UPDATE users SET user_questions_count = user_questions_count + 1 WHERE user_id = '" . $user_id . "'";
    $db->query($sql);

    $sql = "SELECT max(question_id) FROM questions WHERE question_by='$user_id' AND question_title = '$title'";
    $result = mysqli_query($db, $sql);
    $id = mysqli_fetch_row($result);
    $intQId = intval($id[0]);

    $tagArray = explode(",", $tags);

    foreach ($tagArray as $tag) {
        // Iterates through every tags, inserts it in the tags table and
        // makes the Q to T association in the question_tags table
        $sql = " INSERT INTO tags (tag_name) VALUES (\"$tag\") ";
        $db->query($sql);

        $sql = " SELECT tag_id FROM tags WHERE tag_name = \"$tag\"";
        $result = $db->query($sql);
        $Tid = $result->fetch_row();
        $Tid_int = intval($Tid[0]);

        $sql = "INSERT INTO question_tags (question_id, tag_id) VAlUES($intQId, $Tid_int)";
        $db->query($sql);
    }

    $url = "answer.php?id=$intQId";
    ?>
    <script type="text/javascript">
        window.location.href = "<?php echo $url?>"
    </script>
    <?php
    exit;
} else {
    echo "<div class='alert alert-danger'><strong>Error!</strong> Please Log in/Sign up to post a question.</div>";
}

?>
</body>
</html>
