<?php
if (!isset($_SESSION)) {
    session_start();
}
?>


<?php include('sql_connector.php');
include('question_display.php') ?>

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
<div class="container">
<h2><?php echo $qt; ?></h2>

<table class="table">
    <?php
    displayQuestions($db, '
            SELECT * 
            FROM questions Q 
            INNER JOIN question_tags QT ON Q.question_id = QT.question_id 
            INNER JOIN tags T ON T.tag_id = QT.tag_id
            WHERE (T.tag_name = \'' . $qt . '\') AND (question_deleted = 0) 
            order by question_date desc')
    ?>

</table>
</div>
</body>