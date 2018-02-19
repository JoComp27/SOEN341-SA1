<?php $user   = 'root';
$password   = '';
$database   = 'website_db';

$db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <title>Sign In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="signUp.css">

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../home.php"><img id="img" src="logo.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Help</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="content">
    <form id="form" action="#" method="post">
        <h2>Sign In</h2>
        <input required type="text" name="user_name" placeholder="User name" size="47" >
        <br><br>
        <input required id="password" type="password" name="user_pass" size="48" placeholder="Password"><br><br>
        <br>
        <div style="padding-bottom: 25px;"><input style="display: block; margin:0 auto;" id="sub" type="submit" name="submitform" value="Log In"></div>
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST["user_name"];
        $pass = $_POST["user_pass"];
        $sql = "SELECT user_name, user_pass from users where user_name = \"$name\"";
        $result = $db->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['user_pass'] == md5($pass)) {
                $sql = "INSERT INTO loggedin (user_id, logged_in, active) VALUES (\"$name\", NOW(), 1)";
                $db->query($sql);
                header('Location: signIn_Submission.php');
                exit;
            }
            else
                echo "<div class='alert alert-danger'><strong>Error!</strong> Password does not match.</div>";
        }
        else {
            echo "<div class='alert alert-danger'><strong>Error!</strong> Username does not exist.</div>";
        }

    }
    ?>
</div>

</body>
</html>