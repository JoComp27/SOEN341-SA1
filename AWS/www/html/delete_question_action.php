<?php include('sql_connector.php'); ?>

// PURPOSE: runs query that deletes a question

<?php
    $DELETED = 1;
    $questionId = $_POST['questionId'];

    $query = "UPDATE questions SET question_deleted = $DELETED WHERE question_id = '$questionId'";
    mysqli_query($db, $query) or die(mysqli_error($db));
    $redirect = 'Location: home.php'; // go back to home page once answer deleted
    header($redirect);
?>
