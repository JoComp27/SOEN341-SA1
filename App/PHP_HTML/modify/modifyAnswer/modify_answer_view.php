<!-- PURPOSE: Shows the modify answer button which allows user to modify an answer -->
<script src="../modify/modifyAnswer/answer_form.js"></script>

<input type="button" value="Modify" onclick="toggleModifyAnswerForm(<?php echo $a ?>)">

<div id="modify-answer-<?php echo $a ?>" style="margin: 10px 0;" class="hidden">
    <form id="modify-answer-form-<?php echo $a ?>" action="../modifyAnswer/modify_answer_action.php" method="post">
        <div class="form-group">
            <input type="hidden" name="questionId" value="<?php echo $qus_id ?>">
            <input type="hidden" name="answerId" value="<?php echo $answer_id ?>">
            <textarea name="description" class="form-control" rows="5" style="width: 50%"></textarea>
            <input type="Submit">
        </div>
    </form>
</div>
