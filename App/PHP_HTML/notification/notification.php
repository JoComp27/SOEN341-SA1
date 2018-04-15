<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include('../sql_connector.php');
?>

<?php if (!isset($_SESSION['auth'])) {

    header('Location: SOEN341-SA1/App/PHP_HTML/home.php');
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT notification.*, notification_user.notification_status, notification_user.user_id
FROM notification
INNER JOIN notification_user ON notification.notification_id=notification_user.notification_id where notification_user.user_id = $user_id";

$result = mysqli_query($db, $sql);

$num_rows = mysqli_num_rows($result);

?>

<!DOCTYPE html>

<html>
<head>
    <!-- Adapted from open source license https://bootsnipp.com/snippets/xaPeQ -->
    <link rel="stylesheet" type="text/css" href="/SOEN341-SA1/App/PHP_HTML/notification/notification.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <?php include "../header.php" ?>

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
                <div class="mail-option">
                    <div class="chk-all">
                        <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                        <div class="btn-group">
                            <a data-toggle="dropdown" href="#" class="btn mini all" aria-expanded="false">
                                All
                                <i class="fa fa-angle-down "></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"> None</a></li>
                                <li><a href="#"> Read</a></li>
                                <li><a href="#"> Unread</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="btn-group">
                        <a data-original-title="Refresh" data-placement="top" data-toggle="dropdown" href="#"
                           class="btn mini tooltips">
                            <i class=" fa fa-refresh"></i>
                        </a>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">
                            More
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                            <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Move to
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                            <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                        </ul>
                    </div>
                    <?php echo '
                             <ul class="unstyled inbox-pagination">
                                 <li><span>1-' . $num_rows . ' of ' . $num_rows . '</span></li>';
                    ?>
                    <li>
                        <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                    </li>
                    </ul>
                </div>
                <table class="table table-inbox table-hover">
                    <tbody>

                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['notification_status'] == '0') {
                                echo ' <tr class="unread">';
                            } else echo '<tr class="">';

                            $preview = substr($row['notification_content'], 0, 60) . "...";
                            echo '<td class="inbox-small-cells">
                                      <input type="checkbox" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message  dont-show"> <a href = "/SOEN341-SA1/App/PHP_HTML/notification/notification_view_message.php?notification_id=' . $row["notification_id"] . '&id=' . $row["user_id"] . '" target = "blank"><h5>' . $row['notification_title'] . '</h4></a> </td>
                                  <td class="view-message ">' . $preview . '</td>
                                  <td class="view-message  text-right">' . $row['notification_date'] . '</td>
                                  </tr>';
                        }
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