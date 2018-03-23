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
    <script>
        // Reference: https://www.w3schools.com/howto/howto_js_tabs.asp
        function openTab(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <link href="ask_question.css" type="text/css" rel="stylesheet">
    <?php include "header.php" ?>
    <link rel="stylesheet" type="text/css" href="home.css">

</head>

<body>

<?php // Query for the user
$select_query = "select * from users WHERE user_name='" . $_SESSION['user_name'] . "'";
$sql = mysqli_query($db, $select_query);
$user = mysqli_fetch_assoc($sql);
?>

<div class="c1">
    <h1 class="">Welcome to <?php echo $user['user_name'] ?>'s profile page!</h1>
    <div>
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

    <button type="button" class="btn btn-success" onclick="">Subscribe to me!</button>
    <button type="button" class="btn btn-info">Send me a message</button>
    </br></br>

    <table class="aboutme">
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
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'about')"><a class="active" href="#"><i
                        class="fa fa-address-card"></i></a></button>
        <button class="tablinks" onclick="openTab(event, 'mail')"><a href="#"><i class="fa fa-envelope"></i></a>
        </button>
        <button class="tablinks" onclick="openTab(event, 'activity')"><a href="#"><i class="fa fa-line-chart"></i></a>
        </button>
        <button class="tablinks" onclick="openTab(event, 'edit')"><a href="#"><i class="fa fa-edit"></i></a></button>
    </div>

    <div id="activity" class="tabcontent">
        <table class="t2">
            <tr>
                <th><h3>Activity</h3></th>
            </tr>
            <tr>
                <td>
                    <ul class="">
                        <li class=""><strong class="">Questions asked: <?php echo $user['user_questions_count']; ?></strong></li>
                        <li class=""><strong class="">Answers: <?php echo $user['user_answers_count']; ?></strong></li>
                        <li class=""><strong class="">Likes</strong></li>
                        <li class=""><strong class="">Followers</strong></li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>

    <div id="mail" class="tabcontent">
        <table class="t2">
            <tr>
                <th><h3> E-mail</h3></th>
            </tr>
            <tr>
                <td><?php echo $user['user_email']; ?></td>
            </tr>
        </table>
    </div>

    <div id="about" class="tabcontent">
        <table class="t2">
            <tr>
                <th><h3> User's bio: </h3></th>
            </tr>
            <tr>
                <td><?php echo $user['user_profile_description_long']; ?></td>
            </tr>
        </table>
    </div>

    <div id="edit" class="tabcontent">
        <table class="t2">
            <tr>
                <th><h3> Edit profile </h3></th>
            </tr>
            <tr>
                <td><?php echo $user['user_profile_description_long']; ?></td>
            </tr>
        </table>
    </div>

    </br>

</div>

</body>
</html>

