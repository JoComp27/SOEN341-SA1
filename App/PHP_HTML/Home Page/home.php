<?php
    include('sql_connector.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>home page template </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
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
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Okapi</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style= >
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Ask <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Questions</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
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
	<div class="container">
	  <h2>Top Questions</h2>

	  <ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#home">Interesting</a></li>
		<li><a data-toggle="tab" href="#menu2">featured</a></li>
		<li><a data-toggle="tab" href="#menu3">hot</a></li>
		<li><a data-toggle="tab" href="#menu4">week</a></li>
		<li><a data-toggle="tab" href="#menu5">month</a></li>
	  </ul>

	  <div class="tab-content">
		<div id="home" class="tab-pane fade in active">
		  <h3>Interesting</h3>
		  <div class = "tab-content">
          <table class="table">
            <?php

          $sql = "SELECT * FROM questions order by question_view_count";
          $result = mysqli_query($db, $sql);

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
                  $sql2 = "SELECT count(*) as total from answers where reply_questions like '{$row["question_id"]}'";
                  $answer_data = mysqli_query($db, $sql2);
                  $data = mysqli_fetch_assoc($answer_data);
                  echo '<tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvote"].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' .$data['total'].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"].'</p>
                </div>
                <div class = "col-md-9">
                  <a href = "#" target = "blank"><h4>' . $row["question_title"].'</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7">
                  <p class = "asked">' .$row["question_date"]. '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
             }
          } 
          else {
              echo "0 results";
          }
          ?>

        </table>
        </div>
		</div>
		<div id="menu2" class="tab-pane fade">
		  <h3>Featured</h3>
        <div class = "tab-content">
          <table class="table">
		        <?php

          $sql = "SELECT * FROM questions order by question_upvote";
          $result = mysqli_query($db, $sql);

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
                  $sql2 = "SELECT count(*) as total from answers where reply_questions like '{$row["question_id"]}'";
                  $answer_data = mysqli_query($db, $sql2);
                  $data = mysqli_fetch_assoc($answer_data);
                  echo '<tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvote"].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' .$data['total'].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"].'</p>
                </div>
                <div class = "col-md-9">
                  <a href = "#" target = "blank"><h4>' . $row["question_title"].'</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7">
                  <p class = "asked">' .$row["question_date"]. '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
             }
          } 
          else {
              echo "0 results";
          }
          ?>

        </table>
        </div> <!-- End panel -->

		</div>
		<div id="menu3" class="tab-pane fade">
		  <h3>Hot</h3>
		  <div class = "tab-content">
          <table class="table">
            <?php

          $sql = "SELECT * FROM questions where DATE(question_date) = DATE(NOW())";
          $result = mysqli_query($db, $sql);

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
                  $sql2 = "SELECT count(*) as total from answers where reply_questions like '{$row["question_id"]}'";
                  $answer_data = mysqli_query($db, $sql2);
                  $data = mysqli_fetch_assoc($answer_data);
                  echo '<tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvote"].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' .$data['total'].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"].'</p>
                </div>
                <div class = "col-md-9">
                  <a href = "#" target = "blank"><h4>' . $row["question_title"].'</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7">
                  <p class = "asked">asked on ' .$row["question_date"]. '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
             }
          } 
          else {
              echo "0 question asked today";
          }
          ?>

        </table>
        </div> 
		</div>
		<div id="menu4" class="tab-pane fade">
		  <h3>Week</h3>
		  <div class = "tab-content">
          <table class="table">
            <?php

          $sql = "SELECT * FROM questions where DATE(question_date) < curdate() - INTERVAL DAYOFWEEK(curdate()) - 1 DAY";
          $result = mysqli_query($db, $sql);

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
                  $sql2 = "SELECT count(*) as total from answers where reply_questions like '{$row["question_id"]}'";
                  $answer_data = mysqli_query($db, $sql2);
                  $data = mysqli_fetch_assoc($answer_data);
                  echo '<tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvote"].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' .$data['total'].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"].'</p>
                </div>
                <div class = "col-md-9">
                  <a href = "#" target = "blank"><h4>' . $row["question_title"].'</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7">
                  <p class = "asked">asked on ' .$row["question_date"]. '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
             }
          } 
          else {
              echo "0 results";
          }
          ?>

        </table>
        </div> 
		</div>
		<div id="menu5" class="tab-pane fade">
		  <h3>Month</h3>
		  <div class = "tab-content">
          <table class="table">
            <?php

          $sql = "SELECT * FROM questions where question_date between NOW() - INTERVAL 30 DAY AND NOW()";
          $result = mysqli_query($db, $sql);

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
                  $sql2 = "SELECT count(*) as total from answers where reply_questions like '{$row["question_id"]}'";
                  $answer_data = mysqli_query($db, $sql2);
                  $data = mysqli_fetch_assoc($answer_data);
                  echo '<tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvote"].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' .$data['total'].'</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"].'</p>
                </div>
                <div class = "col-md-9">
                  <a href = "#" target = "blank"><h4>' . $row["question_title"].'</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7">
                  <p class = "asked">asked on ' .$row["question_date"]. '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
             }
          } 
          else {
              echo "0 results";
          }
          ?>

        </table>
        </div> 
		</div>
	  </div>
    </div>
  </section>
    
   
</body>
</html>
