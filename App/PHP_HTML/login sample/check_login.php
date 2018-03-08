<?php

include("../sqL_connector.php");
if (!isset($_SESSION)) {
    session_start();
}

$enteredUserinfo = $_POST["user_name"];
$enteredPassword = md5($_POST["user_pass"]);

$sql1 = "SELECT * from users where user_name = \"$enteredUserinfo\" and user_pass =  \"$enteredPassword\"";

$sql2 = "SELECT * from users where user_email = \"$enteredUserinfo\" and user_pass =  \"$enteredPassword\"";

$result1 = $db->query($sql1);
$result2 = $db->query($sql2);

if ((mysqli_num_rows($result1) == 1) || (mysqli_num_rows($result2) == 1)) {
    $row = $result1->fetch_assoc();
    $_SESSION['auth'] = "True";
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['user_id'] = $row['user_id'];
    //$sql = "INSERT INTO loggedin (user_id, logged_in, active) VALUES ($row['user_id'], NOW(), 1)";
    //$db->query($sql);
    header('Location: signIn_Submission.php');


} else {
    $sql3 = "SELECT * from users where user_name = \"$enteredUserinfo\"";
    $sql4 = "SELECT * from users where user_email = \"$enteredUserinfo\"";
    $result1 = $db->query($sql3);
    $result2 = $db->query($sql4);
    $problem = "";

    if ((mysqli_num_rows($result1) == 1) || (mysqli_num_rows($result2) == 1)) {
        $problem = "<div class='alert alert-danger'><strong>Error!</strong> Incorrect password.</div>";
    } elseif (mysqli_num_rows($result1) == 0 && mysqli_num_rows($result2) == 1) {
        $problem = "<div class='alert alert-danger'><strong>Error!</strong> User name does not exist.</div>";
    } else {
        $problem = "<div class='alert alert-danger'><strong>Error!</strong> Email does not exist.</div>";
    }
    $url = "Location: signIn_1.php?problem=$problem";
    header($url);
    exit;
}
