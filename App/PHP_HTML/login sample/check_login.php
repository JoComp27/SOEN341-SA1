<?php

include("../sqL_connector.php");
include_once '../securimage/securimage.php';

if (!isset($_SESSION)) {
    session_start();
}


$enteredUserinfo = $_POST["user_name"];
$enteredPassword = md5($_POST["user_pass"]);

$sql1 = "SELECT * from users where user_name = \"$enteredUserinfo\" and user_pass =  \"$enteredPassword\"";
$sql2 = "SELECT * from users where user_email = \"$enteredUserinfo\" and user_pass =  \"$enteredPassword\"";

$result1 = $db->query($sql1);
$result2 = $db->query($sql2);

// Captcha check
$securimage = new Securimage();
$captchaCorrect = $securimage->check($_POST['captcha_code']);

if (((mysqli_num_rows($result1) == 1) || (mysqli_num_rows($result2) == 1)) && $captchaCorrect) {
    $row = $result1->fetch_assoc();
    $_SESSION['auth'] = "True";
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['user_id'] = $row['user_id'];
    //$sql = "INSERT INTO loggedin (user_id, logged_in, active) VALUES ($row['user_id'], NOW(), 1)";
    //$db->query($sql);
    header('Location: signIn_Submission.php');

} else {
    $sql3 = "SELECT * from users where user_name = '".$enteredUserinfo."'";
    $sql4 = "SELECT * from users where user_email = '".$enteredUserinfo."'";
    $result1 = $db->query($sql3);
    $result2 = $db->query($sql4);
    $problem = "";

    // show all problems in the form that exit
    if ((mysqli_num_rows($result1) == 1) || (mysqli_num_rows($result2) == 1)) {
        $problem .= "<div class='alert alert-danger'>Incorrect password.</div>";
    } else {
        $problem .= "<div class='alert alert-danger'> User name / email does not exist.</div>";
    }
    if (!$captchaCorrect) {
        $problem .= "<div class='alert alert-danger'>Incorrect Captcha</div>";
    }
    $url = "Location: signIn_1.php?problem=$problem";
    header($url);
    exit;
}
