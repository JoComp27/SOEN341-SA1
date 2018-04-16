<?php
session_start();

class AcceptRefuseTest extends PHPUnit\Framework\TestCase
{
    /** @test */

    public function testTest1()
    {
        /*Test description: Interface/component + db test
          Coverage:
            Unit Coverage: answer_state_action.php

            Functionality coverage:
        - default answer state is no state (1)
        - answer state doesn't change given invalid values
        - answer can be accepted or refused when having no state
        - an answer state cannot change once accepted/refused

            Not covered:
        - only question creator can accept/refuse a state

            Database coverage:
        - a) table answer

            By Refat

        /****************************************************************************************
        The following is a stub running on Travis CI that simulates the website's mySQL database: table answers
        */

        $user = 'root';
        $password = '';
        $database = 'website_db';

        $db = new mysqli('localhost', $user, $password, $database) or die("Connection failed");

        // setup sql tables needed
        $db->query("DROP TABLE answers IF EXISTS");
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

        // set up data and info needed.
        $no_state = 1;
        $refused = 0;
        $accepted = 2;

        $sql = "insert into answers (reply_questions,answers_content,answers_date, reply_by, answers_by_user) values (1,'answer',NOW(), 1, 'user')";
        $db->query($sql);

        $sql = "insert into answers (reply_questions,answers_content,answers_date, reply_by, answers_by_user, answer_state) 
                values (1,'answer',NOW(), 1, 'user', $refused), (1,'answer',NOW(), 1, 'user', $accepted)";
        $db->query($sql);

        $id_of_answer_with_no_state = 0;
        $id_of_answer_with_refused_state = 1;
        $id_of_answer_with_accepted_state = 2;


        // TESTS


        //Testing an answer has no state (== 1) when created
        $select_query = "select * from answers where answers_id = '$id_of_answer_with_no_state'";
        $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
        $answer_from_stub = mysqli_fetch_assoc($sql);
        $this->assertEquals($no_state, $answer_from_stub['answer_state']);


        //Testing that an answer state won't change given invalid values
        $invalid_states_to_test = [3, -1, 5];

        foreach ($invalid_states_to_test as $invalid_state) {
            $mock_POST = [
                "state" => $invalid_state, // only valid states are 0, 1, 2
            ];

            $mock_GET = [
                "answer" => $id_of_answer_with_no_state,
            ];

            $this->source_code($mock_POST, $mock_GET, $db);

            //get answer
            $select_query = "select * from answers where answers_id = '$id_of_answer_with_no_state'";
            $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
            $answer_from_stub = mysqli_fetch_assoc($sql);

            $this->assertEquals($no_state, $answer_from_stub['answer_state']);
        }


        //Testing that an answer can be accepted
        $mock_POST = [
            "state" => $accepted,
        ];

        $mock_GET = [
            "answer" => $id_of_answer_with_no_state,
        ];

        $this->source_code($mock_POST, $mock_GET, $db);

        //get answer
        $select_query = "select * from answers where answers_id = '$id_of_answer_with_no_state'";
        $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
        $answer_from_stub = mysqli_fetch_assoc($sql);

        $this->assertEquals($accepted, $answer_from_stub['answer_state']);

        //reset the answer with no state to have no state
        $query = "UPDATE answers SET answer_state = $no_state WHERE answers_id = '$id_of_answer_with_no_state'";
        mysqli_query($db, $query) or die(mysqli_error($db));


        //Testing that an answer can be refused
        $mock_POST = [
            "state" => $refused,
        ];

        $mock_GET = [
            "answer" => $id_of_answer_with_no_state,
        ];

        $this->source_code($mock_POST, $mock_GET, $db);

        //get answer
        $select_query = "select * from answers where answers_id = '$id_of_answer_with_no_state'";
        $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
        $answer_from_stub = mysqli_fetch_assoc($sql);

        $this->assertEquals($refused, $answer_from_stub['answer_state']);

        //reset the answer with no state to have no state
        $query = "UPDATE answers SET answer_state = $no_state WHERE answers_id = '$id_of_answer_with_no_state'";
        mysqli_query($db, $query) or die(mysqli_error($db));


        //Testing that an already accepted/refused answer can not change state
        // for accepted state
        for ($valid_state = 0; $valid_state <= 2; $valid_state++) {
            $mock_POST = [
                "state" => $valid_state, // only valid states are 0, 1, 2
            ];

            $mock_GET = [
                "answer" => $id_of_answer_with_refused_state,
            ];

            $this->source_code($mock_POST, $mock_GET, $db);

            //get answer
            $select_query = "select * from answers where answers_id = '$id_of_answer_with_refused_state'";
            $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
            $answer_from_stub = mysqli_fetch_assoc($sql);

            $this->assertEquals($refused, $answer_from_stub['answer_state']);
        }

        // for refused state
        for ($valid_state = 0; $valid_state <= 2; $valid_state++) {
            $mock_POST = [
                "state" => $valid_state, // only valid states are 0, 1, 2
            ];

            $mock_GET = [
                "answer" => $id_of_answer_with_accepted_state,
            ];

            $this->source_code($mock_POST, $mock_GET, $db);

            //get answer
            $select_query = "select * from answers where answers_id = '$id_of_answer_with_accepted_state'";
            $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
            $answer_from_stub = mysqli_fetch_assoc($sql);

            $this->assertEquals($accepted, $answer_from_stub['answer_state']);
        }

    }

    public function source_code($mock_POST, $mock_GET, $db)
    {
        if (isset ($mock_POST['state'])) {
            $state = $mock_POST['state'];
            $ans_id = $mock_GET['id'];
            //$ques_id = $mock_GET['question_id'];

            // get current state
            $select_query = "select * from answers where answers_id = '$ans_id'";
            $sql = mysqli_query($db, $select_query) or die(mysqli_error($db));
            $answer = mysqli_fetch_assoc($sql);
            $current_state = $answer['answer_state'];

            if ($current_state == 2 && ($state == 0 || $state == 2)) { // state should only be able to be set to accepted or refused and only if it has no state
                $query = "UPDATE answers SET answer_state = $state WHERE answers_id = '$ans_id'";
                mysqli_query($db, $query) or die(mysqli_error($db));
            }
        }
    }

}

?>
