<?php
//use PHPUnit\Framework\TestCase;

class AnswerTest extends PHPUnit\Framework\TestCase{

    public function testTest3(){
		
		
		$user   = 'root';
        $password   = '';
        $database   = 'website_db';
        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");
        $db->query("drop table questions if exists");
        $query = 'CREATE TABLE questions (
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
		
		
		$db->query("Drop table tags if exists");
		$query = 'CREATE TABLE tags (
		  tag_id INT(16) NOT NULL AUTO_INCREMENT, 
		  tag_name VARCHAR(255) NOT NULL,
		  tag_description VARCHAR(255),
		  UNIQUE INDEX tag_name_unique (tag_name),
		  PRIMARY KEY (tag_id)
		)';
		$db->query($query);
		
		
		$db->query("DROP TABLE IF EXISTS answers");
		$query = 'CREATE TABLE answers(
			answers_id INT(16) NOT NULL AUTO_INCREMENT,
			answers_content VARCHAR(5000),
			answers_date DATETIME,
			reply_questions INT(16) NOT NULL, -- which question is this answer addressed to. foreign key to question_id in table questions
			reply_by INT(32), -- foreign key to users_id in table user
			answers_by_user VARCHAR(50), -- Minimize processing time/reducing inner join calls
			answers_upvotes INT(8),
			answers_downvotes INT(8),
			answer_state INT(1) DEFAULT 1, -- State 2= accepted, state 1 = pending, state 0= refused. Whether the answer has been refused or accepted
			answer_deleted INT(1) DEFAULT 0, -- If 0: answer is up. If 1, user has deleted the answer
			PRIMARY KEY (answers_id)
		)';
		$db->query($query);
		
		
		
    	
        $this->assertTrue(True);
    }

}

?>
