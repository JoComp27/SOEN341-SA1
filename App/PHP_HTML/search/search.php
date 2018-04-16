<!DOCTYPE html>
<html>
<head>
    <?php include "../header.php" ?>
</head>
</html>
<body>
<div class="container">
    <h2>The Search Results</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Questions</a></li>
    </ul>

    <div id="home" class="tab-pane fade in active">
        <div class="tab-content">
            <table class="table">


                <?php
                $query = trim($_GET['query']);

                //echo "query is ".$query;
                // gets value sent over search form

                $min_length = 1;
                // you can set minimum length of the query if you want

                if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

                    $search_query = "select questions.question_id,questions.question_view_count,questions.question_title, questions.question_date, 
							questions.question_upvotes, ifnull(count(answers.answers_id),0) as total
							from questions left join answers on (answers.reply_questions = questions.question_id)
							where (questions.question_description like '%$query%' OR questions.question_title like '%$query%') 
							group by questions.question_id,questions.question_view_count,questions.question_title, questions.question_date, questions.question_upvotes;";
                    $question_data = mysqli_query($db, $search_query) or die(mysqli_error($db));

                    if (mysqli_num_rows($question_data) == 0) {
                        echo "No questions found which contain the text: '$query'";
                    } else {
                        echo nl2br("\r\nThe following questions have been found that match your text :'" . $query . "'\r\n\n");

                        while ($row = mysqli_fetch_array($question_data)) {
                            echo '<tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvotes"] . '</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["total"] . '</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"] . '</p>
                </div>
                <div class = "col-md-9">
                  <a href = "/SOEN341-SA1/App/PHP_HTML/answer/answer.php?id=' . $row["question_id"] . ' " target = "blank"><h4>' . $row["question_title"] . '</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7">
                  <p class = "asked"> asked on ' . $row["question_date"] . '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
                        }
                    }
                } else { // if an empty string was searched
                    echo "Please enter at least one character to search";
                }
                ?>
</body>
</html>
