<?php include('sql_connector.php'); ?>

<?php
    $state = $_POST['state'];
    $ans_id = $_GET['id'];
    $ques_id = $_GET['question_id'];
    $query = "UPDATE answers SET answer_state = $state WHERE answers_id = '$ans_id'";
    mysqli_query($db, $query) or die(mysqli_error($db));
    $redirect = 'Location: answer.php?id' . $ques_id;
    header($redirect);
?>
