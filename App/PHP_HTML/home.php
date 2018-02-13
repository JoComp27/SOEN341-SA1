<!DOCTYPE html>
<html>
<head>
    <?php include "header.php" ?>
</head>
<body>
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

          $sql = "SELECT * FROM questions order by question_view_count desc";
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
                  <a href = "answer.php?id=' .$row["question_id"].' " target = "blank"><h4>' . $row["question_title"].'</h4></a>
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
                  <p class = "asked"> asked on ' .$row["question_date"]. '</p>
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

          $sql = "SELECT * FROM questions order by question_upvote desc";
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
                  <a href = "answer.php?id=' .$row["question_id"].' " target = "blank"><h4>' . $row["question_title"].'</h4></a>
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
                  <p class = "asked"> asked on ' .$row["question_date"]. '</p>
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
                  <a href = "answer.php?id=' .$row["question_id"].' " target = "blank"><h4>' . $row["question_title"].'</h4></a>
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
                  <a href = "answer.php?id=' .$row["question_id"].' " target = "blank"><h4>' . $row["question_title"].'</h4></a>
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
                  <a href = "answer.php?id=' .$row["question_id"].' " target = "blank"><h4>' . $row["question_title"].'</h4></a>
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
<?php CloseCon($db); ?>
