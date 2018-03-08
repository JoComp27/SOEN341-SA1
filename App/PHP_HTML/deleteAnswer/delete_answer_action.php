<?php include('../sql_connector.php'); ?>

// PURPOSE: runs query that deletes an answer

<?php
    $DELETED = 1;
    $answerId = $_POST['answerId'];

    $query = "UPDATE answers SET answer_deleted = $DELETED WHERE answers_id = '$answerId'";
    mysqli_query($db, $query) or die(mysqli_error($db));
    $redirect = 'Location: ../answer.php?id=' . $ques_id; // go back to question page once answer deleted
    header($redirect);
?>
