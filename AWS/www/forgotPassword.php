<?php
include ("sql_connector.php");
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <title>Sign In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="signUp.css">
    <style type="text/css">

        div.ttip {
            position: absolute;
            display: inline-block;
            opacity: 1;
        }

        .ttip .ttiptext {
            visibility: hidden;
            width: 200px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
        }

        .ttip:hover .ttiptext {
            visibility: visible;
        }
        .ttip .ttiptext {
            position: absolute;
            left: 15px;
            bottom: -10px;
        }

        img#tooltip{
            position: relative;
            left: -31px;
            bottom: -1px;
            height: 27px;
            width: 27px
        }

    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../home.php"><img id="img" src="logo3.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Help</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>
<nav>
    <div class="content">
        <form id="form" action="#" method="post">
            <h2>Forgot Password</h2>
            <input required type="text" name="input" placeholder="User name or Email" size="47" >
            <br><br>
            <input style="display: block; margin:0 auto;" id="sub" type="submit" name="submitform1" value="Submit">
            <br><br>
        </form>
        <form id="form2" action="#" method="post" class="hidden">
            <h1>Enter New Password for <strong id="name"></strong></h1>
            <input id="attempt" name="attempt" class="hidden">
            <input required id="password" type="password" name="user_pass" size="48" pattern="\w{6,}\d+" placeholder="Password">
            <div class="ttip"><img src="help.png" id="tooltip">
                <span class="ttiptext">The password must contain at least 1 digit and 6 letters.</span></div>
            <br><br>
            <input required  id="confirmPassword" type="password" name="cpassword" size="48" placeholder="Confirm password"><br><br>
            <input style="display: block; margin:0 auto;" id="sub" type="submit" name="submitform2" value="Submit">
            <br><br>
        </form>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["submitform1"])) {
        $enteredUserinfo = $_POST["input"];
        $sql1 = "SELECT * from users where user_name = \"$enteredUserinfo\"";
        $sql2 = "SELECT * from users where user_email = \"$enteredUserinfo\"";
        $result1 = $db->query($sql1);
        $result2 = $db->query($sql2);
        if ($result1->num_rows > 0 || $result2->num_rows > 0) {
        ?>
        <script>document.getElementById("form2").classList.remove("hidden");
            document.getElementById("form").classList.add("hidden");
            document.getElementById("name").innerHTML = "<?php echo $enteredUserinfo ?>";
            document.getElementById("attempt").value = "<?php echo $enteredUserinfo ?>";
        </script> <?php
        } else {
            echo "<div class='alert alert-danger'><strong>Error!</strong> Email or username does not exist.</div>";
        }
        }
        elseif(isset($_POST["submitform2"])) {
            if($_POST['user_pass'] == $_POST['cpassword']) {
                ?>
                <script>document.getElementById("form2").classList.add("hidden");
                    document.getElementById("form").classList.add("hidden");
                    document.getElementById("name").innerHTML;
                </script>
                <?php
                $enteredUserinfo = $_POST["attempt"];
                $user_pass = md5($_POST['user_pass']);
                $sql1 = "SELECT * from users where user_name = \"$enteredUserinfo\"";
                $sql2 = "SELECT * from users where user_email = \"$enteredUserinfo\"";
                $result1 = $db->query($sql1);
                $result2 = $db->query($sql2);
                if ($result1->num_rows > 0) {
                    $sql1 = "UPDATE users SET user_pass = '$user_pass' where user_name = '$enteredUserinfo'";
                    $result1 = $db->query($sql1);

                } elseif ($result2->num_rows > 0) {
                    $sql1 = "UPDATE users set user_pass = '$user_pass' where user_email = '$enteredUserinfo'";
                    $result1 = $db->query($sql1);
                }
                echo "<div class='alert alert-success'><strong>Success!</strong> Password has been changed.</div>";
                }
                else {
                    ?>
                    <script>document.getElementById("form2").classList.remove("hidden");
                        document.getElementById("form").classList.add("hidden");
                        document.getElementById("name").innerHTML = "<?php echo $_POST["attempt"] ?>";
                        document.getElementById("attempt").value = "<?php echo $_POST["attempt"] ?>";

                    </script> <?php
                        echo "<div class='alert alert-alert'><strong>Error!</strong> Passwords are not the same.</div>";
                }
            }
        }
        ?>
    </div>
</nav>


</body>
</html>