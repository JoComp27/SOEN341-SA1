<?php include('sql_connector.php'); ?>

// PURPOSE: runs query that modifies a question

<?php

    $title = $_POST["title"];
    $details = $_POST["details"];
    $questionId = $_GET["questionId"];

    $query = "UPDATE questions
              SET question_title = '$title', question_description  = '$details'
              WHERE question_id = '$questionId'";
    mysqli_query($db, $query) or die(mysqli_error($db));
    $redirect = 'Location: answer.php?id=' . $questionId;
    header($redirect);
?>
