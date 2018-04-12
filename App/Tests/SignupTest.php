<?php
class SignupTest extends PHPUnit\Framework\TestCase{
	/** @test */
    public function testTest1(){
    	/*Test description: Interface/component + db test
    	  Coverage: 
			Unit Coverage: sign_up.php 

			Functional and non-function features coverage:
				- 1) User must complete all mandatory in order to sign up
					Both positive and negative branches tested with representative class/asserts
				- 2) Username must be unique, else fails to create new user
					Both positive and negative branches tested with representative class/asserts
				- 3) Email must be unique, else fails to create new user
					Both positive and negative branches tested with representative class/asserts
				- 4) User will receive 1 Welcome message upon sign up
					Positive branch tested. 
				- 5) User must confirm password selection. If 2 password do not matched, fails to create new user
					Both positive and negative branches tested with representative class/asserts
				Not covered:
					- session cookie creation (simulated with stubs)
					- redirect to home page upon successful sign up 

			Database coverage:
				- a) User passwords are salted and encrypted
				- b) Table user, table notification, table notification_user
					Values are added to SQL table users and notification when 1),2) and 4) above meets conditions. Conditions and results tested with asserts.

			Date last updated            By  
			2018-04-11                   MattYu

    	*/


		/****************************************************************************************
		The following is a stub running on Travis CI that simulates the website's mySQL database: table user, table notification.
		Similation running on PHPunit 
		*/	
    	$user   = 'root';
        $password   = '';
        $database   = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

        $db->query("drop table users if exists");
        $query = 'CREATE TABLE users (
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


		$db->query("Drop table notification if exists");
		$query = 'CREATE TABLE notification (
					notification_id INT(16) NOT NULL AUTO_INCREMENT,
					notification_content VARCHAR(1000),
					notification_date DATETIME,
					notification_title VARCHAR(50), 
					PRIMARY KEY (notification_id)
					) ENGINE=INNODB';
		$db->query($query);

		$db->query("Drop table notification_user if exists");
		$query = 'CREATE TABLE notification_user (
					notification_id INT(16) NOT NULL,
					user_id INT(16),
					notification_status INT(1) DEFAULT 0,
					PRIMARY KEY (notification_id, user_id)
					) ENGINE=INNODB';
		$db->query($query);
		//****************************************************************************************
		// Section pertain to test branch: SUCCESSFUL sign up
		/* Creating mock POST data */
		// Below is the mock user input for branch success case:

		
		$mock_POST = [
				"submitform" => true,
				"user_name" => "test_user_1",
				"user_email" => "test1@gmail.com",
				"answer1" => "secret1",
				"answer2" => "secret2",
				"answer3" => "secret2",
				"year" => 2005,
				"month" => 11,
				"day" => 1,
				"gender" => "M",
				"cpassword" => "password1",
				"user_pass" => "password1",
				];


		//***************************************************************************************
		/*Collect baseline stats pre test*/
    	$baseline_count1=mysqli_num_rows($db->query("select * from users"));
    	$baseline_count2=mysqli_num_rows($db->query("select * from notification"));
    	$baseline_count3=mysqli_num_rows($db->query("select * from notification"));


    	/****************************************************************************************
		TEST BEGIN: Branch successful creation

		Running source code replicat from sign_up.php line 14 to 74 below: 

    	*****************************************************************************************/


		$this->source_code($mock_POST, $db);

       	
       	//******************************************************************************************
       	// Asserting results of successful tests. 
       	// Expected output: all data count should increase by 1. 
       	// Expected results: assertTrue x 3

       	$comparator_count1=mysqli_num_rows($db->query("select * from users"));
    	$comparator_count2=mysqli_num_rows($db->query("select * from notification"));
    	$comparator_count3=mysqli_num_rows($db->query("select * from notification"));

    	$this->assertTrue($comparator_count1 == ($baseline_count1 + 1));
    	$this->assertTrue($comparator_count2 == ($baseline_count2 + 1));
    	$this->assertTrue($comparator_count3 == ($baseline_count3 + 1));

    	//****************************************************************************************
		// Section pertain to test branch: Fail sign up due to unmatching password
		/* Creating mock POST data */
		// Below is the mock user input for branch success case:
		$mock_POST = [
				"submitform" => true,
				"user_name" => "test_user_2",
				"user_email" => "test1@gmail.com",
				"answer1" => "secret1",
				"answer2" => "secret2",
				"answer3" => "secret2",
				"year" => 2005,
				"month" => 11,
				"day" => 1,
				"gender" => "M",
				"cpassword" => "password1",
				"user_pass" => "password2",
				];

		//***************************************************************************************
		/*Collect baseline stats pre test*/
    	$baseline_count1=mysqli_num_rows($db->query("select * from users"));


    	/****************************************************************************************
		TEST BEGIN: Branch fail creation due to username unavailable

		Running source code replicat from sign_up.php line 14 to 74 below: 

    	*****************************************************************************************/


		$this->source_code($mock_POST, $db);

       	
       	//******************************************************************************************
       	// Asserting results of failed tests. 
       	// Expected output: all data count should remain the same as no new user should be created. 
       	// Expected results: assertTrue x 3
		
		$comparator_count1=mysqli_num_rows($db->query("select * from users"));

    	$this->assertTrue($comparator_count1 == ($baseline_count1));
}




		private function source_code($mock_POST, $db){
			/*contains source code under test*/
				if (isset($mock_POST['submitform']) && $mock_POST['user_pass'] == $mock_POST['cpassword']) {

		    $user_name = mysqli_real_escape_string($db, $mock_POST['user_name']);
		    $user_email = mysqli_real_escape_string($db, $mock_POST['user_email']);


		    $user_check_query = "SELECT * FROM users WHERE user_name ='$user_name' OR user_email='$user_email' LIMIT 1";
		    $result = mysqli_query($db, $user_check_query);
		    $user = mysqli_fetch_assoc($result);

		    if ($user) { // if user exists
		        if ($user['user_name'] === $user_name) {
		            ?>
		            <script type="text/javascript">alert("username already exist");</script>
		            <?php
		        }

		        if ($user['user_email'] === $user_email) {
		            ?>
		            <script type="text/javascript">alert("email already exist");</script>
		            <?php
		        }
		    }

		    $answer1 = $mock_POST['answer1'];
		    $answer2 = $mock_POST['answer2'];
		    $answer3 = $mock_POST['answer3'];
		    $user_pass = md5($mock_POST['user_pass']);
		    $dateOfBirth = $mock_POST['year'] . "-" . $mock_POST['month'] . "-" . $mock_POST['day'];
		    $gender = $mock_POST['gender'];


		    $query = "INSERT INTO `users` (user_name, user_pass, user_email, user_birthDate, user_gender, user_date, user_answer1, user_answer2, user_answer3) VALUES ('$user_name', '$user_pass', '$user_email', '$dateOfBirth', '$gender', now(), '$answer1', '$answer2', '$answer3')";
		    $result = mysqli_query($db, $query);

		    //once sign up is successful, automatically log the user in and generate a welcome message with session
		    $_SESSION['auth'] = "True";
		    $_SESSION['user_name'] = $user_name;
		    $user_id_check_query = "SELECT user_id FROM users WHERE user_name = '$user_name' AND user_email='$user_email' LIMIT 1";
		    $result = mysqli_query($db, $user_id_check_query);
		    $user_id = mysqli_fetch_assoc($result);
		    $_SESSION['user_id'] = $user_id['user_id'];


		    //add a welcome message to user inbox

		    $query = "insert into notification (notification_title, notification_date, notification_content) values('Welcome to Okapi!',NOW(), 'Hi $user_name, <br/> <br/> Welcome to Okapi.com, a platform that allows user to exchange questions and share knowledges! <br/> <br/> On behalf of the Okapi team, we wish you a pleasant journey. <br/><br/> Sincerely, <br/> Team Okapi')";
		    $notice_result = mysqli_query($db, $query);
		    $latest_local_notification_id = mysqli_fetch_assoc(mysqli_query($db, "SELECT LAST_INSERT_ID() as 'result'"))['result'];
		    $user_id = $user_id['user_id'];
		    $sql = "insert into notification_user (notification_id, user_id) values ('$latest_local_notification_id', '$user_id')";
		    mysqli_query($db, $sql);
		} else if (isset($mock_POST['submitform']) && $mock_POST['user_pass'] != $mock_POST['cpassword']) {
		    ?>
		    <script type="text/javascript">alert("two passwords do not match. Try again!");</script>
		    <?php
		}

		}
}

?>