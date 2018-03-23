<?php
if (!isset($_SESSION)) {
    session_start();
}
?>


<?php include('sql_connector.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <?php include "header.php" ?>

    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="fillQuestionForm.js"></script>
    <script>check();</script>
    <script>
        function QuestionIncrementLike(questionId) {
            <?php $qus_id = $_GET['id'];?>
            var x = "answer.php?id=<?php echo $qus_id ?>";
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "questionIncrementalVoting.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("value=" + questionId);
            window.location.href = x;
        }

        function QuestionIncrementDislike(questionId) {
            <?php $qus_id = $_GET['id'];?>
            var x = "answer.php?id=<?php echo $qus_id ?>";
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "questionDecrementalVoting.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("value=" + questionId);
            window.location.href = x;
        }

        function AnswerIncrementLike(answerId) {
            <?php $qus_id = $_GET['id'];?>
            var x = "answer.php?id=<?php echo $qus_id ?>";
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "incrementalVoting.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("value=" + answerId);
            window.location.href = x;
        }

        function AnswerIncrementDislike(answerId) {
            <?php $qus_id = $_GET['id'];?>
            var x = "answer.php?id=<?php echo $qus_id ?>";
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "decrementalVoting.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("value=" + answerId);
            window.location.href = x;
        }
    </script>

</head>

<body>
</body>
</html>

<?php
$qus_id = $_GET['id'];

$select_query = "select * from questions where question_id = '$qus_id'";
$question_data = mysqli_query($db, $select_query) or die(mysqli_error($db));
$data = mysqli_fetch_assoc($question_data);

$query = "Update questions set question_view_count = question_view_count + 1 where question_id = '$qus_id'";
mysqli_query($db, $query) or die(mysqli_error($db));

$query = "SELECT tag_name FROM tags T INNER JOIN question_tags QT ON T.tag_id = QT.tag_id WHERE QT.question_id = '$qus_id'";
$tag_data = mysqli_query($db, $query);
?>

<?php
if (isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    $answer = $_REQUEST['answer'];
    $reply_by = $_SESSION['user_id'];
    $answers_by_user = $_SESSION['user_name'];

    $sql = "insert into answers (reply_questions,answers_content,answers_date, reply_by, answers_by_user) values('$qus_id','$answer',NOW(), '$reply_by', '$answers_by_user')";

    ?>

    <?php if (mysqli_query($db, $sql)) { ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your answer has been posted successfully.
        </div>
        <?php
        $title_question = $data['question_title'];
        $url = "<a href=\'answer.php?id=$qus_id\'><h4>answer.php?id=$qus_id</h4></a>";
        $sql = "insert into notification (notification_title, notification_date, notification_content) values('$answers_by_user replied to your question',NOW(), 'You received a new reply from $answers_by_user for question: $title_question $url')";
        $notice_result = mysqli_query($db, $sql);
        $latest_local_notification_id = mysqli_fetch_assoc(mysqli_query($db, "SELECT LAST_INSERT_ID() as 'result'"))['result'];
        $question_user_id = $data['question_by'];
        $sql = "insert into notification_user (notification_id, user_id) values ('$latest_local_notification_id', '$question_user_id')";
        mysqli_query($db, $sql);

        ?>
    <?php } else { ?>
        <div class="alert alert-danger">
            <strong>Sorry!</strong> Something went wrong.
        </div>
    <?php } ?>

<?php } ?>

<!DOCTYPE html>
<html>
<head>
    <title>Q&A - Answers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h2><?php echo "<span id='question-title'>" . $data['question_title'] . "</span>"; ?></h2>
<ul class="list-group">
    <li class="list-group-item"><b> <?php echo
                "<span id='question-description'>" . $data['question_description'] . "</span>";
            echo '<br> Associated Tags: ';
            while ($tag = mysqli_fetch_row($tag_data)) {
                echo ' <a href = "tag.php?tag=' . $tag[0] . ' " target = "blank">' . $tag[0] . '</a> ';
            }
            echo '<br> by user: '; ?>
            <a href="profile.php"><?php echo $data['question_by_user']; ?></a>


            <button type="vote_button" id="incrementalquestionbutton" name="button3"
                    onclick="QuestionIncrementLike(<?php echo $qus_id; ?>)">
                <a class="social-question-like">
                    <span class="question-like"><i class="glyphicon glyphicon-arrow-up"></i></span>
                    <span class="count"> <?php echo $data['question_upvotes']; ?> </span>
                </a>&nbsp;
            </button>

            <button type="vote_button" id="decrementalquestionbutton" name="button4"
                    onclick="QuestionIncrementDislike(<?php echo $qus_id; ?>)">
                <a class="social-question-dislike">
                    <span class="question-dislike"> <?php echo $data['question_downvotes']; ?>
                        <span class="like"><i class="glyphicon glyphicon-arrow-down"></i></span>
                     </span>
                </a>
            </button>
        </b></li>
    <li>
        <?php
        $question_by_id = $data['question_by'];
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question_by_id) { // only the user that created the question can delete it
            include(__DIR__ . '\deleteQuestion\delete_question_view.php');

            echo "<input id='modify-question' class='question-form-button' type='button' value='Modify' onclick='fillForm()'><br><br>";
            $question_action = "modify_question_action.php?questionId=$qus_id";
            include('question_form_view.php');
        }; ?>
    </li>
</ul>
<ul class="list-group">
    <?php

    $select_query = "select * from answers "
        . "where answer_deleted = 0 AND reply_questions ='$qus_id'" // answer must be apart of question and not deleted
        . " order by answers_id DESC";
    $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
    $a = 1;

    while ($get_answers = mysqli_fetch_assoc($sql)) {

        $answer_by_id = $get_answers['reply_by']; // useful variables while looping through each answer
        $answer_id = $get_answers['answers_id'];
        ?>
        <li id="<?php echo "answer-$a" ?>" class="list-group-item">
            <b>Ans <?php echo $a; ?>:</b>
            <span id="<?php echo "answer-description-$a" ?>"><?php echo $get_answers['answers_content']; ?></span>
            <?php echo '<br> by user: '; ?>

            <a href="profile.php"> <?php echo $get_answers['answers_by_user']; ?></a>


            <?php include('answer_state.php'); ?>

            <button type="vote_button" id="incrementalbutton" name="button1"
                    onclick="AnswerIncrementLike(<?php echo $get_answers['answers_id']; ?>)">
                <a class="social-like">
                    <span class="like"><i class="glyphicon glyphicon-thumbs-up"></i></span>
                    <span class="count"> <?php echo $get_answers['answers_upvotes']; ?> </span>
                </a>&nbsp;
            </button>

            <button type="vote_button" id="decrementalbutton" name="button2"
                    onclick="AnswerIncrementDislike(<?php echo $get_answers['answers_id']; ?>)">
                <a class="social-dislike">
                    <span class="dislike"> <?php echo $get_answers['answers_downvotes']; ?> </span>
                    <span class="like"><i class="glyphicon glyphicon-thumbs-down"></i></span>
                </a></button>
        </li>
        <li>
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $answer_by_id) { // only the user that created the answer can delete it
                include(__DIR__ . '\deleteAnswer\delete_answer_view.php');
                include(__DIR__ . '\modifyAnswer\modify_answer_view.php');
            }; ?>
        </li>
        <br/>

        <?php $a++;
    } ?>
</ul>
<?php if (isset($_SESSION['auth'])) {
    echo ' <form method="post" action="answer.php?id=' . $qus_id . '">
    <div class="form-group">
        <label for="comment">Comment:</label>
        <textarea name="answer" required="" class="form-control" rows="5" id="comment"></textarea>
    </div>
    <button type="Submit" name="submit" class="btn btn-primary">Submit</button>
</form>';
}
?>
</body>
</html>
