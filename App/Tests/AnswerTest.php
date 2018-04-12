<?php
class AnswerTest extends PHPUnit\Framework\TestCase{
	/** @test */
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

    	*/


		/****************************************************************************************
		*/
	}

	public function source_code($mock_post, $db){


		if (isset($_POST['submit']) && isset($_SESSION['user_id'])) {
		    $answer = mysqli_real_escape_string($db, $_REQUEST['answer']);
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
}
?>
