<?php include('sql_connector.php'); ?>

<?php
if (isset ($_POST['state'])) {
    $state = $_POST['state'];
    $ans_id = $_GET['id'];
    $ques_id = $_GET['question_id'];

    // get current state
    $select_query = "select * from answers where answers_id = '$ans_id'";
    $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
    $answer = mysqli_fetch_assoc($sql);
    $current_state = $answer['answer_state'];

    if ($current_state == 1 && ($state == 0 || $state == 2)) { // state should only be able to be set to accepted or refused and only if it has no state
        $query = "UPDATE answers SET answer_state = $state WHERE answers_id = '$ans_id'";
        mysqli_query($db, $query) or die(mysqli_error($db));
    }

    $redirect = 'Location: answer.php?id' . $ques_id;
    header($redirect);
}
?>
