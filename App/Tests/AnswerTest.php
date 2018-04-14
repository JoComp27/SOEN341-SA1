<?php
session_start();

class AnswerTest extends PHPUnit\Framework\TestCase{
	/** @test */
	/*
    public function testTest1(){
    	/*Test description: Interface/component + db test
    	  Coverage: 
			Unit Coverage: answer.php 

			Functionality coverage:
				- When user submit a question, 
				Not covered:
				- One to many association between question and answers
					Covered in acceptance test
				- One to one association between answer and user 
					Covered in acceptance test

			Database coverage:
				- a) table answer insert

			Date last updated            By  
			2018-04-12                   MattYu

    	/****************************************************************************************
		The following is a stub running on Travis CI that simulates the website's mySQL database: table users
		*/	
		
    	$user   = 'root';
        $password   = '';
        $database   = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

        $db->query("drop table questions if exists");
        $query = 'CREATE TABLE if not exists questions (
				question_id INT(16) NOT NULL AUTO_INCREMENT,
				question_title VARCHAR(255),
				question_date DATETIME,
				question_cat INT(16),
				question_by INT(32),
				question_by_user VARCHAR(50),
				question_upvote INT(16) DEFAULT 0,
				question_keyword_tag VARCHAR(500),
				question_description VARCHAR(1000),
				question_view_count INT(16) DEFAULT 0,
				question_deleted INT(1) DEFAULT 0,
				PRIMARY KEY (question_id)
				)';
		$db->query($query);

        $db->query("drop table answers if exists");
        $query = 'CREATE TABLE answers(
					answers_id INT(16) NOT NULL AUTO_INCREMENT,
					answers_content VARCHAR(5000),
					answers_date DATETIME,
					reply_questions INT(16) NOT NULL, 
					reply_by INT(32),
					answers_by_user VARCHAR(50),
					answers_upvotes INT(8) DEFAULT 0,
					answers_downvotes INT(8) DEFAULT 0,
					answer_state INT(1) DEFAULT 1,
					answer_deleted INT(1) DEFAULT 0, 
					PRIMARY KEY (answers_id)
					)ENGINE=INNODB';
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

		$sql = "INSERT INTO questions (question_by, question_title, question_description, question_date, question_by_user) VALUES (1,'test', 'test', NOW(), 'user_test')";
    	$db->query($sql);


    	$qus_id = $_GET['id'];

		$select_query = "select * from questions where question_id = '$qus_id'";
		$question_data = mysqli_query($db, $select_query) or die(mysqli_error($db));
		$data = mysqli_fetch_assoc($question_data);


		//Testing user not sign in and not submitted a question
		$baseline_count1=mysqli_num_rows($db->query("select * from answers"));
    	$baseline_count2=mysqli_num_rows($db->query("select * from notification"));
    	$baseline_count3=mysqli_num_rows($db->query("select * from notification_user"));

    	$this->source_code($mock_POST, null, $db, $data);

    	$comparator_count1=mysqli_num_rows($db->query("select * from answers"));
    	$comparator_count2=mysqli_num_rows($db->query("select * from notification"));
    	$comparator_count3=mysqli_num_rows($db->query("select * from notification_user"));
    	$this->assertTrue($comparator_count1 == ($baseline_count1));
    	$this->assertTrue($comparator_count2 == ($baseline_count2));
    	$this->assertTrue($comparator_count3 == ($baseline_count3));

    	//Testing user not sign in and submitted a request

    	$mock_POST = [
				"submit" => true,
				];

		$mock_REQUEST = [
				"answer" => "Test answer",
		];

		$baseline_count1=mysqli_num_rows($db->query("select * from answers"));
    	$baseline_count2=mysqli_num_rows($db->query("select * from notification"));
    	$baseline_count3=mysqli_num_rows($db->query("select * from notification_user"));

    	$this->source_code($mock_POST, $mock_REQUEST, $db, $data);

    	$comparator_count1=mysqli_num_rows($db->query("select * from answers"));
    	$comparator_count2=mysqli_num_rows($db->query("select * from notification"));
    	$comparator_count3=mysqli_num_rows($db->query("select * from notification_user"));
    	$this->assertTrue($comparator_count1 == ($baseline_count1));
    	$this->assertTrue($comparator_count2 == ($baseline_count2));
    	$this->assertTrue($comparator_count3 == ($baseline_count3));

    	//Testing user sign in and not submitted a request

    	$_SESSION['user_id'] = '1';
    	$_SESSION['user_name'] = 'test_user';
    	$mock_POST = [];

    	$baseline_count1=mysqli_num_rows($db->query("select * from answers"));
    	$baseline_count2=mysqli_num_rows($db->query("select * from notification"));
    	$baseline_count3=mysqli_num_rows($db->query("select * from notification_user"));

    	$this->source_code($mock_POST, $mock_REQUEST, $db, $data);

    	$comparator_count1=mysqli_num_rows($db->query("select * from answers"));
    	$comparator_count2=mysqli_num_rows($db->query("select * from notification"));
    	$comparator_count3=mysqli_num_rows($db->query("select * from notification_user"));
    	$this->assertTrue($comparator_count1 == ($baseline_count1));
    	$this->assertTrue($comparator_count2 == ($baseline_count2));
    	$this->assertTrue($comparator_count3 == ($baseline_count3));

    	//Testing user sign in and submitted a request
    	$mock_POST = [
				"submit" => true,
				];

		$baseline_count1=mysqli_num_rows($db->query("select * from answers"));
    	$baseline_count2=mysqli_num_rows($db->query("select * from notification"));
    	$baseline_count3=mysqli_num_rows($db->query("select * from notification_user"));

    	$this->source_code($mock_POST, $mock_REQUEST, $db, $data);

    	$comparator_count1=mysqli_num_rows($db->query("select * from answers"));
    	$comparator_count2=mysqli_num_rows($db->query("select * from notification"));
    	$comparator_count3=mysqli_num_rows($db->query("select * from notification_user"));
    	$this->assertTrue($comparator_count1 == ($baseline_count1 + 1));
    	$this->assertTrue($comparator_count2 == ($baseline_count2 + 1));
    	$this->assertTrue($comparator_count3 == ($baseline_count3 + 1));


	}

	public function source_code($mock_POST, $mock_REQUEST $db, $data){


		if (isset($mock_POST['submit']) && isset($_SESSION['user_id'])) {
		    $answer = mysqli_real_escape_string($db, $mock_REQUEST['answer']);
		    $reply_by = $_SESSION['user_id'];
		    $answers_by_user = $_SESSION['user_name'];

		    $sql = "insert into answers (reply_questions,answers_content,answers_date, reply_by, answers_by_user) values('$qus_id','$answer',NOW(), '$reply_by', '$answers_by_user')";

		   	if (mysqli_query($db, $sql)) {

		     
		        $sql = "UPDATE users SET user_answers_count = user_answers_count + 1 WHERE user_id = '" . $_SESSION['user_id'] . "'";
		        $db->query($sql);

		        $title_question = $data['question_title'];
		        $url = "<a href=\'answer.php?id=$qus_id\'><h4>answer.php?id=$qus_id</h4></a>";
		        $sql = "insert into notification (notification_title, notification_date, notification_content) values('$answers_by_user replied to your question',NOW(), 'You received a new reply from $answers_by_user for question: $title_question $url')";
		        $notice_result = mysqli_query($db, $sql);
		        $latest_local_notification_id = mysqli_fetch_assoc(mysqli_query($db, "SELECT LAST_INSERT_ID() as 'result'"))['result'];
		        $question_user_id = $data['question_by'];
		        $sql = "insert into notification_user (notification_id, user_id) values ('$latest_local_notification_id', '$question_user_id')";
		        mysqli_query($db, $sql);

		   
	}
	*/
}
?>
