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
    <script>check();</script>
    <script>
        function questionIncrementLike(questionId) {
            <?php $qus_id = $_GET['id'];?>
            var link = "answer.php?id=<?php echo $qus_id ?>";
            var http_request = new XMLHttpRequest();
            http_request.open("POST", "question_like.php", true);
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.send("value=" + questionId);
            window.location.href = link;
        }

        function questionIncrementDislike(questionId) {
            <?php $qus_id = $_GET['id'];?>
            var link = "answer.php?id=<?php echo $qus_id ?>";
            var http_request = new XMLHttpRequest();
            http_request.open("POST", "question_unlike.php", true);
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.send("value=" + questionId);
            window.location.href = link;
        }

        function answerIncrementLike(answerId) {
            <?php $qus_id = $_GET['id'];?>
            var link = "answer.php?id=<?php echo $qus_id ?>";
            var http_request = new XMLHttpRequest();
            http_request.open("POST", "answer_like.php", true);
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.send("value=" + answerId);
            window.location.href = link;
        }

        function answerIncrementDislike(answerId) {
            <?php $qus_id = $_GET['id'];?>
            var link = "answer.php?id=<?php echo $qus_id ?>";
            var http_request = new XMLHttpRequest();
            http_request.open("POST", "answer_unlike.php", true);
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.send("value=" + answerId);
            window.location.href = link;
        }
    </script>

</head>
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
    $answer = mysqli_real_escape_string($db, $_REQUEST['answer']);
    $reply_by = $_SESSION['user_id'];
    $answers_by_user = $_SESSION['user_name'];

    $sql = "insert into answers (reply_questions,answers_content,answers_date, reply_by, answers_by_user) values('$qus_id','$answer',NOW(), '$reply_by', '$answers_by_user')";

    ?>

    <?php if (mysqli_query($db, $sql)) { ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your answer has been posted successfully.
        </div>

        <?php
        // increase users answer count
        $sql = "UPDATE users SET user_answers_count = user_answers_count + 1 WHERE user_id = '" . $_SESSION['user_id'] . "'";
        $db->query($sql);

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
<h3><?php echo "<span id='question-title'>" . $data['question_title'] . "</span>"; ?></h3>
<ul class="list-group">
    <li class="list-group-item"><strong>
            <div>
                <?php echo $data['question_description'] ?>
            </div>
            <br>
            <?php
            echo '<br> Associated Tags: ';
            $tag_array[] = [];
            while ($tag = mysqli_fetch_row($tag_data)) {
                echo ' <a href = "tags.php?tags=' . $tag[0] . ' " target = "blank">' . $tag[0] . '</a> ';
                array_push($tag_array, $tag[0]);
            }
            array_shift($tag_array);
            $tagsValue = implode(",", $tag_array);

            echo '<br> by user: '; ?>
            <a href="profile.php?id=<?php
            $select_query = "SELECT * FROM users WHERE user_name='" . $data['question_by_user'] . "'";
            $sql2 = mysqli_query($db, $select_query);
            $get_users = mysqli_fetch_assoc($sql2);
            $id = $get_users['user_id'];
            echo $id;
            ?>"><?php echo $data['question_by_user']; ?></a>

            <?php
            $currentUserId = 0;
            if (isset($_SESSION['user_id'])) {
                $currentUserId = $_SESSION['user_id'];
            }
            ?>

            <button type="vote_button" id="incrementalquestionbutton" name="button3" <?PHP if($currentUserId == 0){ echo ' disabled '; }?>"
                    onclick="questionIncrementLike(<?php echo $qus_id; ?>)">
                <a class="social-question-like">

                    <?php
                    if (mysqli_num_rows(mysqli_query($db, "SELECT * from question_userlikes where user_id='$currentUserId' AND question_id='$qus_id'")) != 0) { ?>
                        <span class="question-like"><i class="glyphicon glyphicon-arrow-up"
                                                       style="color:rgb(0,0,0)"></i></span>
                    <?php } else { ?>
                        <span class="question-like"><i class="glyphicon glyphicon-arrow-up"
                                                       style="color:rgba(0,0,0,0.30)"></i></span>
                    <?php } ?>
                    <span class="count"> <?php echo $data['question_upvotes']; ?> </span>
                </a>&nbsp;
            </button>

            <button type="vote_button" id="decrementalquestionbutton" name="button4" <?PHP if($currentUserId == 0){ echo ' disabled '; }?>"
                    onclick="questionIncrementDislike(<?php echo $qus_id; ?>)">
                <a class="social-question-dislike">
                    <span class="question-dislike"> <?php echo $data['question_downvotes']; ?>
                        <?php if (mysqli_num_rows(mysqli_query($db, "SELECT * from question_userdislikes where user_id='$currentUserId' AND question_id='$qus_id'")) != 0) { ?>
                            <span class="like"><i class="glyphicon glyphicon-arrow-down"
                                                  style="color:rgb(0,0,0)"></i></span>
                        <?php } else { ?>
                            <span class="like"><i class="glyphicon glyphicon-arrow-down"
                                                  style="color:rgba(0,0,0,0.30)"></i></span>
                        <?php }
                        ?>
                     </span>
                </a>
            </button>
        </strong></li>
    <li>
        <?php
        $question_by_id = $data['question_by'];
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question_by_id) { // only the user that created the question can delete it
            include('delete_question_view.php');
            echo "<input id='modify-question' class='question-form-button' type='button' value='Modify' onclick='fillForm()'><br><br>";
            $question_action = "question_modify.php?questionId=$qus_id";
            include('question_form.php');
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
            <strong>Ans <?php echo $a; ?>:</strong>
            <span id="<?php echo "answer-description-$a" ?>"><?php echo $get_answers['answers_content']; ?></span>
            <?php echo '<br> by user: '; ?>

            <a href="profile.php?id=<?php
            $select_query = "SELECT * FROM users WHERE user_name='" . $get_answers['answers_by_user'] . "'";
            $sql2 = mysqli_query($db, $select_query);
            $get_users = mysqli_fetch_assoc($sql2);
            $id = $get_users['user_id'];
            echo $id;
            ?>"> <?php echo $get_answers['answers_by_user']; ?></a>

            <?php include('answer_state_view.php'); ?>

            <?php
            $currentUserId = 0;
            if (isset($_SESSION['user_id'])) {
                $currentUserId = $_SESSION['user_id'];
            } ?>

            <button type="vote_button" id="incrementalbutton" name="button1" <?PHP if($currentUserId == 0){ echo ' disabled '; }?>"
                    onclick="answerIncrementLike(<?php echo $get_answers['answers_id']; ?>)">
                <a class="social-like">
                    <?php
                    if (mysqli_num_rows(mysqli_query($db, "SELECT * from answers_userlikes where user_id='$currentUserId' AND answer_id='$answer_id'")) != 0) { ?>
                        <span class="like"><i class="glyphicon glyphicon-thumbs-up" style="color:rgb(0,0,0)"></i></span>
                    <?php } else { ?>
                        <span class="like"><i class="glyphicon glyphicon-thumbs-up"
                                              style="color:rgba(0,0,0,0.30)"></i></span>
                    <?php } ?>
                    <span class="count"> <?php echo $get_answers['answers_upvotes']; ?> </span>
                </a>&nbsp;
            </button>

            <button type="vote_button" id="decrementalbutton" name="button2" <?PHP if($currentUserId == 0){ echo ' disabled '; }?>"
                    onclick="answerIncrementDislike(<?php echo $get_answers['answers_id']; ?>)">
                <a class="social-dislike">
                    <span class="dislike"> <?php echo $get_answers['answers_downvotes']; ?> </span>

                    <?php
                    if (mysqli_num_rows(mysqli_query($db, "SELECT * from answers_userdislikes where user_id='$currentUserId' AND answer_id='$answer_id'")) != 0) {
                        echo '<span class="dislikeA"><i class="glyphicon glyphicon-thumbs-down" style="color:rgb(0,0,0)"></i></span>';
                    } else {
                        echo '<span class="dislikeA"><i class="glyphicon glyphicon-thumbs-down" style="color:rgba(0,0,0,0.30)"></i></span>';
                    }
                    ?>
                </a>&nbsp;
            </button>
        </li>
        <li>
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $answer_by_id) { // only the user that created the answer can delete it
                include('delete_answer_view.php');
                include('modify_answer_view.php');
            }; ?>
        </li>
        <br>
        <?php $a++;
    } ?>
</ul>
<?php if (isset($_SESSION['auth'])) {
    echo '<form method="post" action="answer.php?id=' . $qus_id . '">
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="answer" required="" class="form-control" rows="5" id="comment"></textarea>
        </div>
        <button type="Submit" name="submit" class="btn btn-primary">Submit</button>
    </form>';
} ?>
</body>
</html>
