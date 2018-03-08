<!-- PURPOSE: Shows the delete answer button which allows user to delete an answer -->

<form name="deleteAnswer" action="deleteAnswer/delete_answer_action.php" method="post">
    <!-- As long as $answer_id is set, this action will work  -->
    <input type="hidden" name="answerId" value="<?php echo $answer_id?>">
    <input type="submit" value="Delete">
</form>