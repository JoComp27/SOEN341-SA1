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
        <form id="form" action="#" method="post">
            <h2>Forgot Password</h2>
            <input required type="text" name="input" placeholder="User name or Email" size="47" >
            <br><br>
            <input style="display: block; margin:0 auto;" id="sub" type="submit" name="submitform1" value="Submit">
            <br><br>
        </form>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $enteredUserinfo = $_POST["input"];
            $sql1 = "SELECT * from users where user_name = \"$enteredUserinfo\"";
            $sql2 = "SELECT * from users where user_email = \"$enteredUserinfo\"";
            $result1 = $db->query($sql1);
            $result2 = $db->query($sql2);
            if ($result1->num_rows > 0 || $result2->num_rows > 0) {
                $_SESSION["username"] = $enteredUserinfo;
                ?>
                <script type="text/javascript">
                    window.location.href = "forgotPassword_QnA.php";
                </script> <?php
            } else {
                echo "<div class='alert alert-danger'><strong>Error!</strong> Email or username does not exist.</div>";
            }
        }
        ?>
    </div>
</nav>


</body>
</html>