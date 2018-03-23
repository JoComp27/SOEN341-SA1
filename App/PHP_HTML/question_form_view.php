<!-- PURPOSE: Question form allows user to enter info about question, whether that is to add one or modify it-->

<!DOCTYPE html>

<html>
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
        <textarea rows="4" cols="50" name="details"></textarea>
        <br>
        <strong id="tags_title">Associated Tags : </strong>
        <br>
        <?php
        if (strpos($question_action, 'modify_question_action.php') === false) {
            echo '
        <input id="tags" type="text" data-role="tagsinput" placeholder="Add tags">
        <br>
        ';
        } ?>
        <input id="submit" type="submit">

    </p>
</form>

</body>
</html>
