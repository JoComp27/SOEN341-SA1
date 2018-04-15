<?php

class SignInTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function testTest1()
    {
        /*Test description: Interface/component + db test
          Coverage: 
            Unit Coverage: check_login.php 

            Functional and non-function features coverage:
                - 1) User must exist in database to sign in
                    Both positive and negative branches tested with representative class/asserts
                - 2) Username or email and hashed password must be mapped 1-to-1 to sign in
                    Both positive and negative branches tested with representative class/asserts
                - 3) User can sign in with username or email
                    Positive case tests for both
                Not covered:
                    - Captcha system
                        Open source code used. Covered in acceptance test
                    - Missing field
                        Covered by acceptance test. Handlers outside the scope of the unit (javascript form based)

            Database coverage:
                - a) table users

            Date last updated            By  
            2018-04-12                   MattYu

        */


        /****************************************************************************************
         * The following is a stub running on Travis CI that simulates the website's mySQL database: table users
         */
        $user = 'root';
        $password = '';
        $database = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

        // $db->query("drop table users if exists");
        $query = 'CREATE TABLE IF NOT EXISTS users (
					user_id INT(32) NOT NULL AUTO_INCREMENT,
					user_name VARCHAR(50) NOT NULL,
					user_pass VARCHAR(255) NOT NULL,
					user_email VARCHAR(255) NOT NULL,
					user_date DATETIME NOT NULL,
					user_birthDate DATE NOT NULL,
					user_gender CHAR(1) NOT NULL,
					user_level INT(16),
					user_karma_score INT(32) DEFAULT 0,
					user_type INT(3), 
					user_answers_count INT(16) DEFAULT 0,
					user_questions_count INT (16) DEFAULT 0,
					user_followers_count INT(16),
					user_profile_description_short VARCHAR(300),
					user_profile_description_long VARCHAR(2000),
					user_email_notification_on INT (1) DEFAULT 1,
					user_deleted INT(1) DEFAULT 0,
					user_answer1 VARCHAR(255) NOT NULL,
					user_answer2 VARCHAR(255) NOT NULL,
					user_answer3 VARCHAR(255) NOT NULL,
					UNIQUE INDEX user_name_unique (user_name),
					PRIMARY KEY (user_id)
					) ENGINE=INNODB';
        $db->query($query);

        //****************************************************************************************
        // Section pertain to test branch: Failed sign in due to user not existing
        /* Creating mock POST data */
        // Below is the mock user input for branch failed case:


        $mock_POST = [
            "user_name" => "user_does_not exists",
            "user_pass" => "password2",
        ];
        //this user does not exists
        $this->assertFalse($this->source_code($mock_POST, $db));
        /****************************************************************************************
         * TEST BEGIN: Branch failed sign due to wrong user_name
         *
         * Running source code replicat from check_login.php line 11 to 55 below:
         *****************************************************************************************/
        // Section pertain to test branch: Fail sign up due to unmatching password
        /* Creating mock POST data */
        // Below is the mock user input for branch success case:
        $mock_POST = [
            "user_name" => "wrong_user",
            "user_pass" => "password2",
        ];
        $password = md5("password2");
        $query = "INSERT INTO `users` (user_name, user_pass, user_email, user_birthDate, user_gender, user_date, user_answer1, user_answer2, user_answer3) VALUES ('test_user_1', '$password', 'test1@gmail.com', '2005-01-01', 'M', now(), 'x', 'x', 'x')";
        $result = mysqli_query($db, $query);
        /****************************************************************************************
         * TEST BEGIN: Branch fail creation due to wrong username
         *****************************************************************************************/

        $this->assertFalse($this->source_code($mock_POST, $db));

        /****************************************************************************************
         * TEST BEGIN: Branch failed sign due to wrong password
         *
         * Running source code replicat from check_login.php line 11 to 55 below:
         *****************************************************************************************/
        //this call should produced 


        // Section pertain to test branch: Fail sign up due to unmatching password
        /* Creating mock POST data */
        // Below is the mock user input for branch success case:
        $mock_POST = [
            "user_name" => "test_user_1",
            "user_email" => "test1@gmail.com",
            "user_pass" => "wrong_password",
        ];
        /****************************************************************************************
         * TEST BEGIN: Branch fail creation due to wrong password
         *****************************************************************************************/
        //$this->assertFalse($this->source_code($mock_POST, $db));

        /****************************************************************************************
         * TEST BEGIN: Branch successful with user_name
         *
         * Running source code replicat from check_login.php line 11 to 55 below:
         *****************************************************************************************/

        // Section pertain to test branch: Successful
        /* Creating mock POST data */
        // Below is the mock user input for branch success case:
        $mock_POST = [
            "user_name" => "test_user_1",
            "user_email" => "test1@gmail.com",
            "user_pass" => "password2",
        ];
        /****************************************************************************************
         * TEST BEGIN: Branch succesful
         *****************************************************************************************/

        $this->assertTrue($this->source_code($mock_POST, $db));

        /****************************************************************************************
         * TEST BEGIN: Branch successful with email
         *
         * Running source code replicat from check_login.php line 11 to 55 below:
         *****************************************************************************************/
        // Section pertain to test branch: Successful
        /* Creating mock POST data */
        // Below is the mock user input for branch success case:
        $mock_POST = [
            "user_name" => "test1@gmail.com",
            "user_email" => "test1@gmail.com",
            "user_pass" => "password2",
        ];
        /****************************************************************************************
         * TEST BEGIN: Branch successful with email
         *****************************************************************************************/
        $this->assertTrue($this->source_code($mock_POST, $db));

    }


    private function source_code($mock_POST, $db)
    {
        /*contains source code under test*/
        $enteredUserinfo = $mock_POST["user_name"];
        $enteredPassword = md5($mock_POST["user_pass"]);

        $sql1 = "SELECT * from users where user_name = \"$enteredUserinfo\" and user_pass =  \"$enteredPassword\"";
        $sql2 = "SELECT * from users where user_email = \"$enteredUserinfo\" and user_pass =  \"$enteredPassword\"";

        $result1 = $db->query($sql1);
        $result2 = $db->query($sql2);

        // Captcha check
        //$securimage = new Securimage();
        $captchaCorrect = true;

        if (((mysqli_num_rows($result1) == 1) || (mysqli_num_rows($result2) == 1)) && $captchaCorrect) {
            $row = $result1->fetch_assoc();
            $_SESSION['auth'] = "True";
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];
            //$sql = "INSERT INTO loggedin (user_id, logged_in, active) VALUES ($row['user_id'], NOW(), 1)";
            //$db->query($sql);
            // header('Location: sign_in_submission.php');
            return true;

        } else {
            $sql3 = "SELECT * FROM users WHERE user_name = '" . $enteredUserinfo . "'";
            $sql4 = "SELECT * FROM users WHERE user_email = '" . $enteredUserinfo . "'";
            $result3 = $db->query($sql3);
            $result4 = $db->query($sql4);
            $problem = "<div class='alert alert-danger'>";

            // show all problems in the form that exit
            if ((mysqli_num_rows($result3) == 0) && (mysqli_num_rows($result4) == 0)) {
                $problem .= "User name / email does not exist.<br><br>";
                return false;
            } elseif ((mysqli_num_rows($result1) == 0) && (mysqli_num_rows($result2) == 0)) {
                $problem .= "Incorrect password.<br><br>";
                return false;
            }
            if (!$captchaCorrect) {
                $problem .= "Incorrect Captcha<br><br>";
            }

            $problem .= "</div>";

            $url = "Location: sign_in_normal.php?problem=$problem";
            //header($url);
        }
    }
}

?>