<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="ask_question.css">
    <script src="ask_question.js"></script>
</head>
<body onload="timedate()">

<form action="question_submission.php" method="POST">
    <button id="ask" type="button">Ask a Question!</button>
    <br>
    <p id="question_field" name="question_field" class="hidden">
        <strong id="title_title" class="pretty">Title</strong>
        <br>
        <input type="text" name="title">
        <br>
        <strong id="details_title">Details</strong>
        <br>
        <textarea rows="4" cols="50" name="details"></textarea>
        <br>
        <input type="submit">
    </p>
    <br>
</form>
</body>
</html>
