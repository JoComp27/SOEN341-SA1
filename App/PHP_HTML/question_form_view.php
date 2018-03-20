<!-- PURPOSE: Question form allows user to enter info about question, whether that is to add one or modify it-->

<!DOCTYPE html>

<html>
<head>

<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    </script>

</head>
<body>


<form id="question-form" method="POST" action="<?php echo "$question_action" ?>"> <!-- generic action on question for
                                                                                       separation of behaviour and view.-->
    <p id="question_field" name="question_field" class="hidden">
        <strong id="title_title" class="pretty">Title : </strong>
        <br>
        <input type="text" name="title">
        <br>
        <strong id="details_title">Details : </strong>
        <br>

<textarea name="area1" style="width: 600px; height: 150px;">
	
</textarea>

        </textarea>
        <br>

        <?php
        if (strpos($question_action, 'modify_question_action.php') === false) {
            echo '
                <strong id="tags_title">Associated Tags : </strong>
                <br>
                <input id="tags" name="tags" type="text" data-role="tagsinput" placeholder="Add tags">
                <br>
            ';
        } ?>

        <input id="submit" type="submit">

    </p>
</form>

</body>
</html>
