<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include('sql_connector.php');
?>
<!DOCTYPE html>

<html>
<head>
    <title>Okapi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap-tagsinput.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="ask_question.js"></script>
    <script type="text/javascript" src="bootstrap-tagsinput.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tags').tagsinput({
                confirmKeys: [13, 44, 32, 188],
                maxTags: 8
            });
        });
    </script>

</head>
<body>
<!-- Navbar from bootstrap example template -->
<nav class="navbar navbar-default" style="background-color: #FF8C00; border-color: #E7E7E7;">
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
            <a class="navbar-brand" href="home.php"><img id="img" src="login sample/logo3.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style=>
            <ul class="nav navbar-nav">
                <li class="active"><a href="home.php">Ask <span class="sr-only">(current)</span></a></li>
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
            <!--  calling search.php for issue#68 -->
            <form action="search.php" method="GET">
                <input type="text" name="query"/>
                <input type="submit" value="Search"/>
            </form>
            <?php if (!isset($_SESSION['auth'])) {
                echo '<ul class="nav navbar-nav navbar-right">
                <li><a href="sign_in_merge_options.php">Sign In</a></li>
                <li><a href="sign_up.php">Sign Up</a></li>
            </ul>';
            } else {
                $id = $_SESSION['user_id'];
                $sql = "select count(*) as 'result' from notification_user where user_id = $id and notification_status = 0";
                $notification_count = mysqli_fetch_assoc(mysqli_query($db, $sql))['result'];
                echo '<ul class="nav navbar-nav navbar-right">
				<li><a href="#"> Welcome ' . strtoupper($_SESSION['user_name']) . '</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="profile.php"> Profile</a></li>
				<li><a href="sign_out_submission.php">Log Off</a></li>
            </ul>';
                echo '<button class="navbar-toggle collapsed">...</button>

				  <div class="nav navbar-brand pull-right">
					  <a href="notification.php" >
						<i class="glyphicon glyphicon-bell"></i>
						<span class="label label-danger">' . $notification_count . '</span>
					  </a>
				  </div>';
            }
            ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
</body>
</html>
