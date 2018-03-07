<?php include('connection.php'); ?>
<?php
if(isset($_POST['submit'])){
    $question = $_REQUEST['question'];
    $sql = "insert into questions (question_title,question_date)values('$question',NOW())";

    ?>

    <?php if(mysqli_query($link,$sql)){  ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your question has been posted successfully.
        </div>
    <?php	}else{ ?>
        <div class="alert alert-danger">
            <strong>Sorry!</strong> Somthing went wrong.
        </div>
    <?php } ?>

<?php }  ?>
<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h2>Questions Listing</h2>

<form method="post" action="index.php">
    <div class="form-group">
        <label for="comment">Add New Question:</label>
        <textarea name="question" required="" class="form-control" rows="5" id="comment"></textarea>
    </div>
    <button type="Submit" name="submit" class="btn btn-primary">Submit</button>
</form>
<ul class="list-group">
    <?php
    $select_query = "select * from questions order by question_id DESC";
    $sql = mysqli_query($link,$select_query) or die(mysqli_error($link));
    $a = 1;
    while($get_questions=mysqli_fetch_assoc($sql)){

        ?>
        <li class="list-group-item"><b>Qus <?php echo $a; ?>:</b> <a href="answer.php?id=<?php echo $get_questions['question_id']; ?>" style="text-decoration: none;"><?php echo $get_questions['question_title']; ?></a></li>
        <?php $a++; } ?>
</ul>

    
    
</body>
</html>
