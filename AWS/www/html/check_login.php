<?php

include("sqL_connector.php");
include_once 'securimage/securimage.php';

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
    header('Location: sign_in_submission.php');

} else {
    $sql3 = "SELECT * from users where user_name = '" . $enteredUserinfo . "'";
    $sql4 = "SELECT * from users where user_email = '" . $enteredUserinfo . "'";
    $result3 = $db->query($sql3);
    $result4 = $db->query($sql4);
    $problem = "<div class='alert alert-danger'>";

    // show all problems in the form that exit
    if ((mysqli_num_rows($result3) == 0) && (mysqli_num_rows($result4) == 0)) {
        $problem .= "User name / email does not exist.<br><br>";
    } elseif ((mysqli_num_rows($result1) == 0) && (mysqli_num_rows($result2) == 0)) {
        $problem .= "Incorrect password.<br><br>";
    }
    if (!$captchaCorrect) {
        $problem .= "Incorrect Captcha<br><br>";
    }

    $problem .= "</div>";

    $url = "Location: sign_in_normal.php?problem=$problem";
    header($url);
    exit;
}
