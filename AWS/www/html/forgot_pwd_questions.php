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
        <form id="form1" action="#" method="post">
            <h3 id="bd">Security Questions for <?php echo $_SESSION["username"]; ?>: </h3>
            <?php
            $num = rand(1,3);
            switch ($num) {
                case 1:
                    echo "<div id=\"q1\">Mother's maiden name: </div>";
                    break;
                case 2:
                    echo "<div id=\"q2\">Childhood bestfriend: </div>";
                    break;
                case 3:
                    echo "<div id=\"q3\">Favourite restaurant: </div>";
                    break;
            }?>
            <input required type="answer" name="answer" placeholder="answer"><br>
            <br>
            <br>
            <input style="display: block; margin:0 auto;" id="sub" type="submit" name="submitform1" value="Submit">
            <br><br>
        </form>
        <?php
        if(isset($_POST["submitform1"])) {
            $answer = $_POST["answer"];
            $qa = "user_answer".$_SESSION["num"];
            $name = $_SESSION["username"];
            $sql1 = "SELECT $qa  from users where user_name = \"$name\"";
            $sql2 = "SELECT $qa from users where user_email = \"$name\"";
            $result1 = $db->query($sql1);
            $result2 = $db->query($sql2);
            if ($result1->num_rows > 0 ) {
                $row = $result1->fetch_assoc();
                if($answer == $row[$qa]) {
                    ?>
                   <script type="text/javascript">
                       window.location.href = "forgot_pwd_reset_pwd.php";
                   </script> <?php
                }
                else
                    echo "<div class='alert alert-alert'><strong>Error!</strong> Security answer is not correct.</div>";

            } elseif ($result1->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $row[$qa];
                if($answer == $row[$qa]) {
                ?>
                    <script type="text/javascript">
                        window.location.href = "forgot_pwd_reset_pwd.php";
                    </script> <?php
                }
                else
                    echo "<div class='alert alert-alert'><strong>Error!</strong> Security answer is not correct.</div>";
            }
        }
        $_SESSION["num"] = $num;
        ?>
    </div>
</nav>
</body>
</html>