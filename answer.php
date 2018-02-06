<?php include('connection.php'); ?>
<?php
$qus_id = $_GET['id'];

$select_query = "select * from questions where question_id = '$qus_id'";
$question_data = mysqli_query($link,$select_query) or die(mysqli_error($link));
$data=mysqli_fetch_assoc($question_data); 
?>

<?php
if(isset($_POST['submit'])){ 
  	$answer = $_REQUEST['answer'];
  	$sql = "insert into answers (reply_questions,answers_content,answers_date)values('$qus_id','$answer',NOW())";

  	?>

<?php if(mysqli_query($link,$sql)){  ?>
<div class="alert alert-success">
  <strong>Success!</strong> Your answer has been posted successfully.
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
	<title>Q&A - Answers</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h2>Answer Listing</h2>
<ul class="list-group">
  <li class="list-group-item"><b>Qus: <?php echo $data['question_title']; ?></b></li>
</ul>  
 <ul class="list-group">
 <?php 

$select_query = "select * from answers where reply_questions ='$qus_id' order by answers_id DESC";
$sql = mysqli_query($link,$select_query) or die(mysqli_error($link));
$a = 1;
while($get_answers=mysqli_fetch_assoc($sql)){
	

  ?> 
  <li class="list-group-item"><b>Ans <?php echo $a; ?>:</b> <?php echo $get_answers['answers_content']; ?></li>
  	<a class="social-like" >
                    <span class="like"><i class="glyphicon glyphicon-thumbs-up"></i></span>
                    <span class="count" >5</span>
                </a>
                &nbsp;
                <a class="social-dislike" >
                    <span class="dislike" >4</span>
                    <span class="like"><i class="glyphicon glyphicon-thumbs-down"></i></span>
                </a>
  </li>

  
  <?php $a++; } 

  

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
