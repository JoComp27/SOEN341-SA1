<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php include('sql_connector.php'); ?>

<!DOCTYPE html>

<html>
<head>

    <link href="profile.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <?php include "header.php" ?>
    <?php include "question_display.php" ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        // Reference: https://www.w3schools.com/howto/howto_js_tabs.asp
        function openTab(evt, obj) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(obj).style.display = "block";
            evt.currentTarget.className += " active";
        }

    </script>
</head>

<body>

<?php // Query for the user
if (isset($_GET['id'])) {
    $usr_id = $_GET['id'];
    $select_query = "SELECT * FROM users WHERE user_id='" . $usr_id . "'";
} else {
    $select_query = "SELECT * FROM users WHERE user_name='" . $_SESSION['user_name'] . "'";
}
$sql = mysqli_query($db, $select_query);
$user = mysqli_fetch_assoc($sql);
?>

<!--Start of big div -->
<div class="c1">
    <h1 class="">Welcome to <?php echo $user['user_name'] ?>'s profile page!</h1>
    <div>
        <!-- Display user's icon based on his/her gender -->
        <a href="" class="">
            <?php if ($user['user_gender'] == 'M')
                $imgName = "person-flat.png";
            else
                $imgName = "person-girl-flat.png"; ?>
            <?php
            echo "<img id='profilepic' title='profile image' src='https://freeiconshop.com/wp-content/uploads/edd/$imgName' />";
            ?>
        </a>
    </div>

    <!--Inactive buttons -->
    <button type="button" class="btn btn-success">Subscribe to me!</button>
    <!-- adds a follower to one user from the other who's session is connected-->
    <button type="button" class="btn btn-info">Send me a message</button>
    </br></br>

    <!--Displays basic information about user's profile -->
    <table class="t2">
        <tr>
            <th>About Me!</th>
            <th></th>
        </tr>
        <tr>
            <td>Gender:</td>
            <td> <?php echo $user['user_gender']; ?></td>
        </tr>
        <tr>
            <td>Birthday:</td>
            <td><?php echo $user['user_birthDate']; ?></td>
        </tr>
        <tr>
            <td>Member since:</td>
            <td><?php echo $user['user_date']; ?></td>
        </tr>
    </table>
    </br>


    <!--Reference: https://www.w3schools.com/howto/howto_css_icon_bar.asp -->
    <!-- This tab bar lets you navigate to view user's information and activity  -->
    <div class="tab">
        <!--Opens the activity tab -->
        <button class="tablinks" onclick="openTab(event, 'activity')"><a class="active" href="#"><i
                        class="fa fa-line-chart"></i></a>
        </button>
        <!--Opens the question tab which displays all the questions the user asked -->
        <button class="tablinks" onclick="openTab(event, 'question_mark')"><a href="#"><i
                        class="fa fa-question"></i></a>
        </button>
        <!-- Opens the edit profile tab-->
        <button class="tablinks" onclick="openTab(event, 'edit')"><a href="#"><i class="fa fa-edit"></i></a></button>
    </div>

    <!-- Reference: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_progressbar3&stacked=h -->
    <!-- Added a progress bar to illustrate user's activity and personal information -->
    <div id="activity" class="tabcontent">
        <table class="t2">
            <tr>
                <th><h2> User's Activity : </h2></th>
            </tr>
            <tr>
                <td>
                    <ul>
                        <div class="">
                            <!--Displays the number of questions asked -->
                            <h4> Questions asked : </h4>
                            <ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="<?php echo $user['user_questions_count']; ?>" aria-valuemin="0"
                                         aria-valuemax="100"
                                         style="width:<?php echo $user['user_questions_count']; ?>%">
                                        <?php echo $user['user_questions_count']; ?>
                                    </div>
                                </div>
                            </ul>

                            <!--Displays the number of answers -->
                            <h4> Number of Answers: </h4>
                            <ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar"
                                         aria-valuenow="<?php echo $user['user_answers_count']; ?>" aria-valuemin="0"
                                         aria-valuemax="100" style="width:<?php echo $user['user_answers_count']; ?>%">
                                        <?php echo $user['user_answers_count']; ?>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </ul>
                </td>
            </tr>
        </table>
    </div>

    <!--Displays every questions that user ever asked -->
    <div id="question_mark" class="tabcontent">
        <table class="t2">
            <tr>
                <th><h3> Questions from user:</h3></th>
                <br>
            </tr>
            <tr>
                <td class="showquestion">
                    <?php
                    $usr_id = $user['user_id'];
                    displayQuestions($db, 'SELECT * FROM questions WHERE question_by = ' . $usr_id . ' ORDER BY question_date DESC');
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <div id="edit" class="tabcontent">
        <table class="t2">
            <tr>
                <th>
                    <h3> Edit profile </h3>
                    <!-- link that directs to user's settings-->
                    <a href="settings.php"> Click here to change settings! </a>
                </th>
            </tr>
        </table>
    </div>
    </br>

    <!--End of big div -->
</div>

</body>
</html>
