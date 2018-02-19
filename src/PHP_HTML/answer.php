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
	<script>
		function increment(id){
			<?php $qus_id =$_GET['id'];?>
			var x = "answer.php?id=<?php echo $qus_id ?>";
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST","incrementalVoting.php",true);
			xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xhttp.send("value="+id);
			window.location.href=x;
		}
	
		function decrement(id){
			<?php $qus_id =$_GET['id'];?>
			var x = "answer.php?id=<?php echo $qus_id ?>";
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST","decrementalVoting.php",true);
			xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xhttp.send("value="+id);
			window.location.href=x;
		}
	</script>
</head>
<body>
<?php include "header.php" ?>
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
<h2><?php echo $data['question_title']; ?></h2>
<ul class="list-group">
    <li class="list-group-item"><b> <?php echo $data['question_description']; ?></b></li>
</ul>
<ul class="list-group">
    <?php

    $select_query = "select * from answers where reply_questions ='$qus_id' order by answers_id DESC";
    $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
    $a = 1;

    while ($get_answers = mysqli_fetch_assoc($sql)) {?>
        <li id="<?php echo "answer-$a" ?>" class="list-group-item">
            <b>Ans <?php echo $a; ?>:</b> <?php echo $get_answers['answers_content']; ?>

            <?php include('answer_state.php'); ?>

                      <button type="vote_button" id="incrementalbutton" name="button1" onclick="increment(<?php echo $get_answers['answers_id']; ?>)">
            <a class="social-like">
                <span class="like"><i class="glyphicon glyphicon-thumbs-up"></i></span>
                <span class="count"> <?php echo $get_answers['answers_upvotes']; ?> </span>
            </a>&nbsp; </button>
			
			<button type="vote_button" id="decrementalbutton" name="button2" onclick="decrement(<?php echo $get_answers['answers_id']; ?>)">
            <a class="social-dislike">
                <span class="dislike"> <?php echo $get_answers['answers_downvotes'] ; ?> </span>
                <span class="like"><i class="glyphicon glyphicon-thumbs-down"></i></span>
            </a> </button>
        </li><br/>

        <?php $a++;
    } ?>
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
