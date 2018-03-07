<?php
if (!isset($_SESSION)) {
    session_start();
}
?>


<?php include('sql_connector.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <?php include "header.php" ?>

    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
</html>

<?php
$qt = $_GET['tag'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tags</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<h2><?php echo $qt; ?></h2>

<table class="table">
    <?php

    $sql = "SELECT * 
            FROM questions Q INNER JOIN question_tags QT 
            ON Q.question_id = QT.question_id 
            INNER JOIN tags T
            ON T.tag_id = QT.tag_id
            WHERE T.tag_name = '{$qt}' order by question_date desc";
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
            <tr>
              <td>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_upvote"] . '</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $data['total'] . '</p>
                </div>
                <div class = "col-md-1">
                  <p class = "top-questions-stats">' . $row["question_view_count"] . '</p>
                </div>
                <div class = "col-md-1">
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
                <div class = "col-md-7">
                  <a href = "answer.php?id=' . $row["question_id"] . ' " target = "blank"><h4 style="padding-left:15%">' . $row["question_title"] . '</h4></a>
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
    } else {
        echo "0 results";
    }
    ?>

</table>
</body>