<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>

<html>
<head>
    <link href="ask_question.css" type="text/css" rel="stylesheet">
    <?php include "header.php"?>
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
<div class="container">
    <h1>Settings</h1>
    <h4>Notifications</h4>
    <h4>Personal Information</h4>
    <?php
    $select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
    $sql = mysqli_query($db, $select_query);
    $get_users = mysqli_fetch_assoc($sql);
    ?>
    <h8>Username: <strong><?php echo $get_users['user_name']; ?></strong></h8><br>
    <h8>Email: <strong><?php echo $get_users['user_email']; ?></strong></h8>&nbsp;&nbsp;<a style="color:blue;" onclick="show_CI(1)">Edit</a><br>
    <form id="question-form1" name="question-form1" method="POST" class="hidden">
        <input type="text" name="one">
        <input id="submit" type="submit">
        <br>
    </form>
    <h8>Password: <strong>You logged in, you know it </strong></h8>&nbsp;&nbsp;<a style="color:blue;" onclick="show_CI(2)">Edit</a><br>
    <form id="question-form2" method="POST" name="question-form2" class="hidden">
        <input required id="password" type="password" name="two" size="48" pattern="\w{6,}\d+" placeholder="Password">
        <input id="submit" type="submit">
        <div><span class="ttiptext">The password must contain at least 1 digit and 6 letters.</span></div>
    </form>
    <h8>Security Answer 1: <strong><?php echo $get_users['user_answer1']; ?></strong></h8>&nbsp;&nbsp;<a style="color:blue;" onclick="show_CI(3)">Edit</a><br>
    <form id="question-form3" method="POST" name="question-form3" class="hidden">
        <input type="text" name="three">
        <input id="submit" type="submit">
        <br>
    </form>

    <h8>Security Answer 2: <strong><?php echo $get_users['user_answer2']; ?></strong></h8>&nbsp;&nbsp;<a style="color:blue;" onclick="show_CI(4)">Edit</a><br>
    <form id="question-form4" method="POST" name="question-form4" class="hidden">
        <input type="text" name="four">
        <input id="submit" type="submit">
        <br>
    </form>
    <h8>Security Answer 3: <strong><?php echo $get_users['user_answer3']; ?></strong></h8>&nbsp;&nbsp;<a style="color:blue;" onclick="show_CI(5)">Edit</a><br>
    <form id="question-form5" method="POST" name="question-form5" class="hidden">
        <input type="text" name="five">
        <input id="submit" type="submit">
        <br>
    </form>
</div>


</body>
</html>

<?php
    if(isset($_POST['one'])){
        $one = $_POST["one"];
        $sql1 = "UPDATE users SET user_email = '$one' where user_name = '".$_SESSION['user_name']."'";
        $result1 = $db->query($sql1);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    else if(isset($_POST['two'])){
        $two = md5($_POST["two"]);
        $sql1 = "UPDATE users SET user_password = '$two' where user_name = '".$_SESSION['user_name']."'";
        $result1 = $db->query($sql1);
    }
    else if(isset($_POST['three'])){
        $three = $_POST["three"];
        $sql1 = "UPDATE users SET user_answer1 = '$three' where user_name = '".$_SESSION['user_name']."'";
        $result1 = $db->query($sql1);
    }
    else if(isset($_POST['four'])){
        $four = $_POST["four"];
        $sql1 = "UPDATE users SET user_answer2 = '$four' where user_name = '".$_SESSION['user_name']."'";
        $result1 = $db->query($sql1);
    }
    else if(isset($_POST['five'])){
        $five = $_POST["five"];
        $sql1 = "UPDATE users SET user_answer3 = '$five' where user_name = '".$_SESSION['user_name']."'";
        $result1 = $db->query($sql1);
    }
?>


<SCRIPT LANGUAGE="JavaScript">
    function show_CI(num) {
        var ans;
        if(num == 1) {
            document.getElementById("question-form1").classList.remove("hidden");
        }
        else if(num == 2) {
            document.getElementById("question-form2").classList.remove("hidden");
        }
        else if(num == 3) {
            document.getElementById("question-form3").classList.remove("hidden");
        }
        else if(num == 4) {
            document.getElementById("question-form4").classList.remove("hidden");
        }
        else if(num == 5) {
            document.getElementById("question-form5").classList.remove("hidden");
        }
    }
</SCRIPT>
