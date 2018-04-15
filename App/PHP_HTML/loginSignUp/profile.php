<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php include('sql_connector.php'); ?>

<!DOCTYPE html>

<html>
<head>
    <style>
        body {
            margin-left: 100px;
            margin-right: 100px;
            background-color: white;
            width: 1100px;
            margin-top: 100px
        }

        .c1 {
            length: 700px;
            margin-left: 100px;
            margin-right: 100px;
            background-color: lightgrey;
            margin-top: 50px;
            margin-bottom: 50px
        }

        .aboutme {
            border: 2px solid black;
            width: 200px;
            margin-left: 50px;
            margin-top: 50px
        }

        tr, td {
            border: 2px solid blue
        }

        #profilepic {
            border-radius: 50%;
            position: relative;
            float: right;
            margin-right: 50px;
        }
    </style>

    <link href="ask_question.css" type="text/css" rel="stylesheet">
    <?php include "header.php" ?>
    <link rel="stylesheet" type="text/css" href="home.css">

</head>

<body>

<div class="c1">
    <h1 class="">Welcome to <?php echo $_SESSION['user_name'] ?>'s profile page!</h1>
    <div><a href="" class=""><img id="profilepic" title="profile image" class=""
                                  src="https://freeiconshop.com/wp-content/uploads/edd/person-flat.png"></a>
    </div>

    <button type="button" class="btn btn-success">Follow me!</button>
    <button type="button" class="btn btn-info">Send me a message</button>
    <br>

    <table class="aboutme">
        <tr>
            <th>About Me!</th>
        </tr>
        <tr>
            <td>Gender:</td>
            <td> <?php $select_query = "SELECT * FROM users WHERE user_name='" . $_SESSION['user_name'] . "'";
                $sql = mysqli_query($db, $select_query);
                $get_users = mysqli_fetch_assoc($sql);
                echo $get_users['user_gender']; ?></td>
        </tr>
        <tr>
            <td>Birthday:</td>
            <td><?php $select_query = "SELECT * FROM users WHERE user_name='" . $_SESSION['user_name'] . "'";
                $sql = mysqli_query($db, $select_query);
                $get_users = mysqli_fetch_assoc($sql);
                echo $get_users['user_birthDate']; ?></td>
        </tr>
        <tr>
            <td>Member since:</td>
            <td> <?php $select_query = "SELECT * FROM users WHERE user_name='" . $_SESSION['user_name'] . "'";
                $sql = mysqli_query($db, $select_query);
                $get_users = mysqli_fetch_assoc($sql);
                echo $get_users['user_date']; ?></td>
        </tr>
    </table>


    <ul class="">
        <li class=""><strong>Activity </strong></li>
        <li class=""><strong class="">Questions asked</strong></li>
        <li class=""><strong class="">Answers</strong></li>
        <li class=""><strong class="">Likes</strong></li>
        <li class=""><strong class="">Followers</strong></li>
    </ul>

    <div class="">Social Media</div>
    <div class="">Bio</div>

</div>

</body>
</html>

