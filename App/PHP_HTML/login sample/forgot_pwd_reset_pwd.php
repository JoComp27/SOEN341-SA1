<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>4
    <?php include('login_header.php');
    ?>
</head>
<body>
<nav>
    <div class="content">
        <form id="form2" action="#" method="post">
            <h2>Enter New Password for <?php echo $_SESSION["username"]; ?></php></h2>
            <input required id="password" type="password" name="user_pass" size="48" pattern="\w{6,}\d+" placeholder="Password">
            <div class="ttip"><img src="help.png" id="tooltip">
                <span class="ttiptext">The password must contain at least 1 digit and 6 letters.</span></div>
            <br><br>
            <input required  id="confirmPassword" type="password" name="cpassword" size="48" placeholder="Confirm password"><br><br>
            <input style="display: block; margin:0 auto;" id="sub" type="submit" name="submitform3" value="Submit">
            <br><br>
        </form>
        <?php
            if(isset($_POST["submitform3"])) {
                if ($_POST['user_pass'] == $_POST['cpassword']) {
                    $user_pass = md5($_POST['user_pass']);
                    $name = $_SESSION["username"];
                    $sql1 = "SELECT *  from users where user_name = \"$name\"";
                    $sql2 = "SELECT * from users where user_email = \"$name\"";
                    $result1 = $db->query($sql1);
                    $result2 = $db->query($sql2);
                    if ($result1->num_rows > 0) {
                        $sql1 = "UPDATE users SET user_pass = '$user_pass' where user_name = '$name'";
                        $result1 = $db->query($sql1);

                    } elseif ($result2->num_rows > 0) {
                        $sql1 = "UPDATE users set user_pass = '$user_pass' where user_email = '$name'";
                        $result1 = $db->query($sql1);
                    }
                    echo "<div class='alert alert-success'><strong>Success!</strong> Password has been changed.</div>";
                    session_destroy();
                } else {
                    echo "<div class='alert alert-alert'><strong>Error!</strong> Passwords are not the same.</div>";
                }
            }
        ?>
    </div>
</nav>
</body>
</html>