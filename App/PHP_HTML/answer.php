<?php include('sql_connector.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>home page template </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Navbar from bootstrap example template -->
<nav class="navbar navbar-default" style="background-color: #9999ff; border-color: #E7E7E7;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Okapi</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style=>
            <ul class="nav navbar-nav">
                <li class="active"><a href="ask_question.php">Ask <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Questions</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Categories <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Top questions</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Sign In</a></li>
                <li><a href="#">Sign Up</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
</body>
</html>

<?php
$qus_id = $_GET['id'];

$select_query = "select * from questions where question_id = '$qus_id'";
$question_data = mysqli_query($db, $select_query) or die(mysqli_error($db));
$data = mysqli_fetch_assoc($question_data);

$query = "Update questions set question_view_count = question_view_count + 1 where question_id = '$qus_id'";
mysqli_query($db, $query) or die(mysqli_error($db));
?>

<?php
if (isset($_POST['submit'])) {
    $answer = $_REQUEST['answer'];
    $sql = "insert into answers (reply_questions,answers_content,answers_date)values('$qus_id','$answer',NOW())";

    ?>

    <?php if (mysqli_query($db, $sql)) { ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your answer has been posted successfully.
        </div>
    <?php } else { ?>
        <div class="alert alert-danger">
            <strong>Sorry!</strong> Somthing went wrong.
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
<h2><?php echo $data['question_title']; ?></h2>
<ul class="list-group">
    <li class="list-group-item"><b> <?php echo $data['question_description']; ?></b></li>
</ul>
<ul class="list-group">
    <?php

    $select_query = "select * from answers where reply_questions ='$qus_id' order by answers_id DESC";
    $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
    $a = 1;
    while ($get_answers = mysqli_fetch_assoc($sql)) {


        ?>
        <li id="<?php echo "answer-$a" ?>" class="list-group-item">
            <b>Ans <?php echo $a; ?>:</b> <?php echo $get_answers['answers_content']; ?>

            <?php include('answer_state.php'); ?>

            <a class="social-like">
                <span class="like"><i class="glyphicon glyphicon-thumbs-up"></i></span>
                <span class="count">5</span>
            </a>&nbsp;
            <a class="social-dislike">
                <span class="dislike">4</span>
                <span class="like"><i class="glyphicon glyphicon-thumbs-down"></i></span>
            </a>
        </li><br/>


        <?php $a++;
    }


    ?>
</ul>


<form method="post" action="answer.php?id=<?php echo $qus_id; ?>">
    <div class="form-group">
        <label for="comment">Comment:</label>
        <textarea name="answer" required="" class="form-control" rows="5" id="comment"></textarea>
    </div>
    <button type="Submit" name="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>
