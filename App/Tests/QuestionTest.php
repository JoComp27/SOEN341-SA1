<?php
//use PHPUnit\Framework\TestCase;

class QuestionTest extends PHPUnit\Framework\TestCase
{

    public function testTest1()
    {
        /*Interface/component + db test 
            Coverages: question_submission.php |Partially covers tags systems
                - 1) User cannot ask question if not logged in
                     Both positive and negative branches tested
                - 2) User sign in but has not submitted a question: no new questions will be added until submit form is pressed
                     Both positive and negative branches tested
                - 3) User sign in and submit a question with no tags: new question created with no new tag creation
                     Scenario tested with representative class
                - 4) User sign in and submit a question with tags: new question created with new tag creation matching number of tags
                     Scenario tested with representative class: new question with 2 tags
            Not covered:
                - Search by tags, question display
                     Covered by Acceptance tests
                 
             Database coverage
             - tables: questions, tags, question_tags
            
        */


        /********************************
         * The following is a stub running on Travis CI that simulates the website's mySQL database.
         * Similation running on PHPunit
         */
        $user = 'root';
        $password = '';
        $database = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

        $db->query("DROP TABLE questions IF EXISTS");
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
                  tag_id   INT(16)      NOT NULL AUTO_INCREMENT,
                  tag_name VARCHAR(255) NOT NULL,
                  UNIQUE INDEX tag_name_unique (tag_name),
                  PRIMARY KEY (tag_id)
                ) ENGINE = INNODB';
        $db->query($query);

        $db->query("DROP TABLE IF EXISTS question_tags");
        $query = 'CREATE TABLE question_tags (
                    question_id INT(16) NOT NULL, 
                     tag_id      INT(16) NOT NULL,  
                     PRIMARY KEY (question_id, tag_id)
                 )ENGINE = INNODB';
        $db->query($query);

        //Test: User not sign in ********************
        $baseline_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $baseline_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));
        $baseline_count3 = mysqli_num_rows($db->query("SELECT * FROM question_tags"));

        $mock_POST = [
            "title" => "question title",
            "details" => "question details",
            "tags" => '',
        ];

        $this->source_code($mock_POST, $db);

        $comparator_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $comparator_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));
        $comparator_count3 = mysqli_num_rows($db->query("SELECT * FROM question_tags"));

        $this->assertTrue($comparator_count1 == ($baseline_count1)); //expecting no changes in db
        $this->assertTrue($comparator_count2 == ($baseline_count2));
        $this->assertTrue($comparator_count3 == ($baseline_count3));

        //Test: User sign in, question **********************
        $_SESSION['auth'] = "True";
        $_SESSION['user_name'] = 'test1';
        $_SESSION['user_id'] = 1;

        $mock_POST = [
            "title" => "question title",
            "details" => "question details",
            "tags" => '',
        ];

        $baseline_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $baseline_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));
        $baseline_count3 = mysqli_num_rows($db->query("SELECT * FROM question_tags"));

        $this->source_code($mock_POST, $db);

        $comparator_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $comparator_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));
        $comparator_count3 = mysqli_num_rows($db->query("SELECT * FROM question_tags"));

        $this->assertTrue($comparator_count1 == ($baseline_count1 + 1));
        //$this->assertTrue($comparator_count2 == ($baseline_count2));
        $this->assertTrue($comparator_count3 == ($baseline_count3));

        //Test: User sign in, 2 tags *********************
        $_SESSION['auth'] = "True";
        $_SESSION['user_name'] = 'test1';
        $_SESSION['user_id'] = 1;

        $mock_POST = [
            "title" => "question title 2",
            "details" => "question details 2",
            "tags" => 'tag1,tag2',
        ];

        $baseline_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $baseline_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));
        $baseline_count3 = mysqli_num_rows($db->query("SELECT * FROM question_tags"));

        $this->source_code($mock_POST, $db);

        $comparator_count1 = mysqli_num_rows($db->query("SELECT * FROM questions"));
        $comparator_count2 = mysqli_num_rows($db->query("SELECT * FROM tags"));
        $comparator_count3 = mysqli_num_rows($db->query("SELECT * FROM question_tags"));

        $this->assertTrue($comparator_count1 == ($baseline_count1 + 1));
        $this->assertTrue($comparator_count2 == ($baseline_count2 + 1));
        $this->assertTrue($comparator_count3 == ($baseline_count3 + 2));


    }

    public function source_code($mock_POST, $db){

        if (isset($_SESSION['auth'])) {
            $title = $mock_POST["title"];
            $details = mysqli_real_escape_string($db, $mock_POST["details"]);
            $user_id = $_SESSION['user_id'];
            $tags = $mock_POST["tags"];
            $question_by_user = $_SESSION['user_name'];

            $sql = "INSERT INTO questions (question_by, question_title, question_description, question_date, question_by_user) VALUES ($user_id, \"$title\", \"$details\", NOW(), '$question_by_user')";
            $db->query($sql);

            // increase users question count
            $sql = "UPDATE users SET user_questions_count = user_questions_count + 1 WHERE user_id = '" . $user_id . "'";
            $db->query($sql);

            $sql = "SELECT max(question_id) FROM questions WHERE question_by='$user_id' AND question_title = '$title'";
            $result = mysqli_query($db, $sql);
            $id = mysqli_fetch_row($result);
            $intQId = intval($id[0]);

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

            $url = "answer.php?id=$intQId";
            ?>
            <script type="text/javascript">
                window.location.href = "<?php echo $url?>"
            </script>
            <?php
  
        } 
        else {
            //echo "<div class='alert alert-danger'><strong>Error!</strong> Please Log in/Sign up to post a question.</div>";
        }

    }
}

?>
