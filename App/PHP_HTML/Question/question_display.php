<?php

function displayQuestions($db, $SqlQuestionQuery)
{
    $sql = $SqlQuestionQuery;
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $sql2 = "SELECT count(*) as total from answers where reply_questions like '{$row["question_id"]}'";
            $answer_data = mysqli_query($db, $sql2);
            $data = mysqli_fetch_assoc($answer_data);

            $sql3 = "SELECT tag_name FROM tags T INNER JOIN question_tags QT ON T.tag_id = QT.tag_id WHERE QT.question_id = '{$row["question_id"]}'";
            $tag_data = mysqli_query($db, $sql3);

            echo '
            <tr >
              <td>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">' . $row["question_upvotes"] . '</p>
                </div>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">' . $data['total'] . '</p>
                </div>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"] . '</p>
                </div>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">
                   ';
            while ($tag = mysqli_fetch_row($tag_data)) {
                echo ' 
                          <a href = "tag.php?tag=' . $tag[0] . ' " target = "blank">' . $tag[0] . '</a> 
                          ';
            }
            echo '
                  </p>
                </div>
                <div class = "col-md-7 col-sm-7 col-xs-7">
                  <a href = "answer.php?id=' . $row["question_id"] . ' " target = "blank"><h4 style="padding-left:15%">' . $row["question_title"] . '</h4></a>
                </div>
              </td>
            </tr>
            <tr class="warning borderless">
              <td>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">votes</p>
                </div>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">answer</p>
                </div>
                <div class = "col-md-1 col-sm-1 col-xs-1">
                  <p class = "top-questions-stats">views</p>
                </div>
                <div class = "col-md-2 col-sm-2 col-xs-2">
                  <p>tags</p>
                </div>
                <div class = "col-md-7 col-sm-7 col-xs-7">
                  <p class = "asked"> asked on ' . $row["question_date"] . '</p>
                </div>
              </td>
            </tr> <!-- end row 2 -->';
        }
    } else {
        echo "0 results";
    }
}

?>