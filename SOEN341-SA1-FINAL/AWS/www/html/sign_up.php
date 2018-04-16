<?php
include "sql_connector.php";


if (!isset($_SESSION)) {
    session_start();
}

function closeCon($db)
{
    $db->close();
}

if (isset($_POST['submitform']) && $_POST['user_pass'] == $_POST['cpassword']) {

    $user_name = mysqli_real_escape_string($db, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($db, $_POST['user_email']);


    $user_check_query = "SELECT * FROM users WHERE user_name ='$user_name' OR user_email='$user_email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['user_name'] === $user_name) {
            ?>
            <script type="text/javascript">alert("username already exist");</script>
            <?php
        }

        if ($user['user_email'] === $user_email) {
            ?>
            <script type="text/javascript">alert("email already exist");</script>
            <?php
        }
    }
	else{

    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $user_pass = md5($_POST['user_pass']);
    $dateOfBirth = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];
    $gender = $_POST['gender'];


    $query = "INSERT INTO `users` (user_name, user_pass, user_email, user_birthDate, user_gender, user_date, user_answer1, user_answer2, user_answer3) VALUES ('$user_name', '$user_pass', '$user_email', '$dateOfBirth', '$gender', now(), '$answer1', '$answer2', '$answer3')";
    $result = mysqli_query($db, $query);

    //once sign up is successful, automatically log the user in and generate a welcome message with session
    $_SESSION['auth'] = "True";
    $_SESSION['user_name'] = $user_name;
    $user_id_check_query = "SELECT user_id FROM users WHERE user_name = '$user_name' AND user_email='$user_email' LIMIT 1";
    $result = mysqli_query($db, $user_id_check_query);
    $user_id = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user_id['user_id'];


    //add a welcome message to user inbox

    $query = "insert into notification (notification_title, notification_date, notification_content) values('Welcome to Okapi!',NOW(), 'Hi $user_name, <br/> <br/> Welcome to Okapi.com, a platform that allows user to exchange questions and share knowledges! <br/> <br/> On behalf of the Okapi team, we wish you a pleasant journey. <br/><br/> Sincerely, <br/> Team Okapi')";
    $notice_result = mysqli_query($db, $query);
    $latest_local_notification_id = mysqli_fetch_assoc(mysqli_query($db, "SELECT LAST_INSERT_ID() as 'result'"))['result'];
    $user_id = $user_id['user_id'];
    $sql = "insert into notification_user (notification_id, user_id) values ('$latest_local_notification_id', '$user_id')";
    mysqli_query($db, $sql);
    header('Location: home.php');
	}
} else if (isset($_POST['submitform']) && $_POST['user_pass'] != $_POST['cpassword']) {
    ?>
    <script type="text/javascript">alert("two passwords do not match. Try again!");</script>
    <?php
}
?>


<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <title>signUp</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="sign.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <style type="text/css">

        #form {
            text-align: center;
        }

        div.ttip {
            position: hidden;
            display: inline-block;
            opacity: 1;
            left: 2.5%;
        }

        .ttip .ttiptext {
            visibility: visible;
            color: black;
            text-align: center;
            padding: 5px 0;
            font-family: 'Gloria Hallelujah', cursive;

        }

        .ttip:hover .ttiptext {
            visibility: visible;
        }

        .ttip .ttiptext {
            position: relative;
        }

        img#tooltip {
            position: relative;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php"><img id="img" src="logo.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>


<div class="content">
    <form id="form" action="sign_up.php" method="post">
        <h2>Sign Up</h2>

        <input required type="text" name="user_name" placeholder="User name">
        <br><br>
        <input required type="email" name="user_email" placeholder="Email"><br>
        <br><br>

        <input required type="radio" id="Male"
               name="gender" value="M">
        <label for="Male">Male</label>
        <br>
        <input type="radio" id="Female"
               name="gender" value="F">

        <label for="Female">Female</label>
        <br>
        <br>
        <div id="bd">Birthday:</div>
        <select name="month">
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">May</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08">Aug</option>
            <option value="09">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>&nbsp;
        <select name="day">
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
        </select>&nbsp;
        <select name="year">
            <option value="2017">2017</option>
            <option value="2016">2016</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
            <option value="2013">2013</option>
            <option value="2012">2012</option>
            <option value="2011">2011</option>
            <option value="2010">2010</option>
            <option value="2009">2009</option>
            <option value="2008">2008</option>
            <option value="2007">2007</option>
            <option value="2006">2006</option>
            <option value="2005" selected="1">2005</option>
            <option value="2004">2004</option>
            <option value="2003">2003</option>
            <option value="2002">2002</option>
            <option value="2001">2001</option>
            <option value="2000">2000</option>
            <option value="1999">1999</option>
            <option value="1998">1998</option>
            <option value="1997">1997</option>
            <option value="1996">1996</option>
            <option value="1995">1995</option>
        </select><br><br>
        <h3 id="bd">Security Questions: </h3>
        <div id="q1">Mother's maiden name:</div>
        <input required type="answer1" name="answer1" placeholder="Answer"><br>
        <div id="q2">Childhood bestfriend:</div>
        <input required type="answer2" name="answer2" placeholder="Answer"><br>
        <div id="q3">Favourite restaurant:</div>
        <input required type="answer3" name="answer3" placeholder="Answer"><br>
        <br>
        <br>
        <input required id="password" type="password" name="user_pass" size="48" pattern="\w{6,}\d+"
               placeholder="Password">
        <div class="ttip"><img src="help.png" id="tooltip">
            <span class="ttiptext">The password must contain at least 1 digit and 6 letters.</span></div>
        <br><br>

        <input required id="confirmPassword" type="password" name="cpassword"
               placeholder="Confirm password"><br><br>

        <div style="padding-bottom: 25px;"><input style="display: block; margin:0 auto;" id="sub" type="submit"
                                                  name="submitform"></div>
    </form>

</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>
</html>