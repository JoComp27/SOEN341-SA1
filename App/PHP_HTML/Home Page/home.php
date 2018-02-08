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
		  <?php

          $sql = "SELECT question_upvote, question_view_count, question_title FROM questions";
          $result = mysqli_query($db, $sql);

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                  echo "Upvote: " . $row["question_upvote"]. " - Count: " . $row["question_view_count"]. " " . $row["question_title"]. "<br>";
              }
          } 
          else {
              echo "0 results";
          }

      ?>
		</div>
		<div id="menu2" class="tab-pane fade">
		  <h3>Featured</h3>
		        <?php

          $sql = "SELECT question_upvote, question_view_count, question_title FROM questions";
          $result = mysqli_query($db, $sql);


          echo '<div class = "row"> <!-- begin top questions table -->
      <div class = "col-md-10">
        <div class = "panel-body">
          <table class="table">
            <tr class="warning">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">0</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">1</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">13</p>
                </div>
                <div class = "col-md-9">
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
                  <p class = "asked">asked 29 secs ago Darryl Mendonez</p>
                </div>
              </td>
            </tr> <!-- end row 1 -->
            <tr class="warning">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">0</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">2</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">13</p>
                </div>
                <div class = "col-md-9">
                  <a href = "http://stackoverflow.com/questions/33602203/reorder-dynamic-text-field-id" target = "blank"><h4>Reorder dynamic text field ID</h4></a>
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
                  <p class = "asked">asked 29 secs ago Ethan</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->
            <tr class="warning">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">-1</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">1</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">43</p>
                </div>
                <div class = "col-md-9">
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
                  <p class = "asked">asked 6 days ago Darryl Mendonez</p>
                </div>
              </td>
            </tr> <!-- end row 3 -->
            <tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">0</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">0</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">7</p>
                </div>
                <div class = "col-md-9">
                </div>
              </td>
            </tr>
            <tr class="borderless">
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
                  <p class = "asked">asked 1 min ago Jan zHepHirotHz</p>
                </div>
              </td>
            </tr> <!-- end row 4 -->
            <tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">3</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">1</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">60</p>
                </div>
                <div class = "col-md-9">
                  <a href = "http://stackoverflow.com/questions/33590177/multiple-image-file-upload-with-captions" target = "blank"><h4>Multiple Image File Upload with Captions</h4></a>
                </div>
              </td>
            </tr>
            <tr class = "borderless">
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
                  <p class = "asked">modified 25 min ago Nevi</p>
                </div>
              </td>
            </tr> <!-- end row 5 -->
          </table>
        </div> <!-- End panel -->
      </div> <!-- End 9 columns for Top Questions table -->'

      ?>
		</div>
		<div id="menu3" class="tab-pane fade">
		  <h3>Hot</h3>
		  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
		</div>
		<div id="menu4" class="tab-pane fade">
		  <h3>Week</h3>
		  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
		</div>
		<div id="menu5" class="tab-pane fade">
		  <h3>Month</h3>
		  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
		</div>
	  </div>
    </div>
  </section>
    
   
</body>
</html>
