<?php
session_start();
//use PHPUnit\Framework\TestCase;

class QuestionTest extends PHPUnit\Framework\TestCase;{

    public function testTest1(){

    	$user   = 'root';
        $password   = '';
        $database   = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");



    	$baseline_count1=mysqli_num_rows($db->query("select * from questions"));
    	$baseline_count2=mysqli_num_rows($db->query("select * from tags"));
    	
        $title = "Test title";
	    $details = "Test details";
	    $t = '1';
	    $tags = "tags";
	    $question_by_user = 'user_name';
	    $sql = "INSERT INTO questions (question_by, question_title, question_description, question_date, question_by_user) VALUES ($t, \"$title\", \"$details\", NOW(), '$question_by_user')";
	    $db->query($sql);

	    $sql = "select question_id from questions where question_by = \"$t\" and question_title = \"$title\"";
	    $result = $db->query($sql);
	    $row = $result->fetch_assoc();
	    $id = $row['question_id'];

	    $intQId = intval($id);

	    $tagArray = explode(",", $tags);

	    foreach ($tagArray as $tag) {
	        // Iterates through every tag, inserts it in the tags table and
	        // makes the Q to T association in the question_tags table
	        $sql = " INSERT INTO tags (tag_name) VALUES (\"$tag\") ";
	        $db->query($sql);

	        $sql = " SELECT tag_id FROM tags WHERE tag_name = \"$tag\"";
	        $result = $db->query($sql);
	        $Tid = $result->fetch_row();
	        $Tid_int = intval($Tid[0]);

	        $sql = "INSERT INTO question_tags (question_id, tag_id) VAlUES($intQId, $Tid_int)";
	        $db->query($sql);

    }
    	$comparator_count1=mysqli_num_rows($db->query("select * from questions"));
    	$comparator_count2=mysqli_num_rows($db->query("select * from tags"));

    	$this->assertTrue($comparator_count1 == ($baseline_count1 + 1));
    	$this->assertTrue($comparator_count2 == ($baseline_count2 + 1));

}
}

?>
