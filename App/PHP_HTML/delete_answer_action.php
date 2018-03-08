<?php include('sql_connector.php'); ?>

// PURPOSE: runs query that deletes a question

<?php
    $DELETE_QUESTION = 1;
    $questionId = $_POST['questionId'];

    $query = "UPDATE questions SET question_deleted = $DELETE_QUESTION WHERE question_id = '$questionId'";
    mysqli_query($db, $query) or die(mysqli_error($db));
    $redirect = 'Location: answer.php?id=' . $questionId;
    header($redirect);
?>
