<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include('sql_connector.php');
?>

<?php
$user_id = $_GET['id'];
$notification_id = $_GET['notification_id'];

if (!isset($_SESSION['auth'])) header('Location: home.php');
if ($_SESSION['user_id'] != $user_id) header('Location: home.php'); //security check. Cannot view message if wrong id


$sql = "SELECT notification.*, notification_user.notification_status, notification_user.user_id
FROM notification
INNER JOIN notification_user ON notification.notification_id=notification_user.notification_id where notification_user.user_id = $user_id and notification.notification_id = $notification_id";

$result = mysqli_query($db, $sql);

$sql = "Update notification_user set notification_status = 1 where notification_id = $notification_id and user_id = $user_id";
mysqli_query($db, $sql);

?>

<!DOCTYPE html>

<html>
<head>
    <!-- Adapted from open source license https://bootsnipp.com/snippets/xaPeQ -->
    <link rel="stylesheet" type="text/css" href="notification.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <?php include "header.php" ?>

</head>


<body>
<div class="container">
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
    <div class="mail-box">

        </aside>
        <aside class="lg-side">
            <div class="inbox-head">
                <h3>Inbox</h3>
                <form action="#" class="pull-right position">
                    <div class="input-append">
                        <input type="text" class="sr-input" placeholder="Search Mail">
                        <button class="btn sr-btn" type="button"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="inbox-body">
                <table class="table table-inbox table-hover">
                    <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        $row = mysqli_fetch_assoc($result);
                        echo $row['notification_content'];
                    }


                    ?>
                    </tbody>
                </table>
            </div>
        </aside>
    </div>
</div>
</body>
</html>