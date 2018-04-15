<?php
//use PHPUnit\Framework\TestCase;

class QuestionTest extends PHPUnit\Framework\TestCase
{

    public function testTest1()
    {
        /*Interface/component + db test 
            Coverages:
                - Negative Tag results | Positive Tag results
                - 
            
        */


        /********************************
         * The following is a stub running on Travis CI that simulates the website's mySQL database.
         * Similation running on PHPunit
         */
        $user = 'root';
        $password = '';
        $database = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

        //$db->query("drop table questions if exists");
        $query = 'CREATE TABLE IF NOT EXISTS questions (
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
        $db->query("DROP TABLE tags IF EXISTS");

        $query = 'CREATE TABLE tags (
		  tag_id INT(16) NOT NULL AUTO_INCREMENT, 
		  tag_name VARCHAR(255) NOT NULL,
		  tag_description VARCHAR(255),
		  UNIQUE INDEX tag_name_unique (tag_name),
		  PRIMARY KEY (tag_id)
		)';
        $db->query($query);


        $baseline_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $baseline_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));

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
            // Iterates through every tags, inserts it in the tags table and
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
        $comparator_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $comparator_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));

        $this->assertTrue($comparator_count1 == ($baseline_count1 + 1));
        $this->assertTrue($comparator_count2 == ($baseline_count2 + 1));

    }
}

?>
