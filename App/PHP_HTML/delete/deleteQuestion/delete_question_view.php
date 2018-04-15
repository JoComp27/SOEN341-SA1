<!-- PURPOSE: Shows the delete question button which allows user to delete question -->

<form name="deleteQuestion" action="./delete_question_action.php" method="post">
    <!-- As long as $qus_id is set, this action will work  -->
    <input type="hidden" name="questionId" value="<?php echo $qus_id ?>">
    <input type="submit" value="Delete">
</form>