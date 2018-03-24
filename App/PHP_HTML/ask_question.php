<?php echo "hi_not1" ?>
<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    </script>


<form id="question-form" method="POST" action="<?php echo "$question_action" ?>"> <!-- generic action on question for
                                                                                       separation of behaviour and view.-->
    <p id="question_field" name="question_field" class="hidden">
        <strong id="title_title" class="pretty">Title : </strong>
        <br>
        <input type="text" name="title">
        <br>
        <strong id="details_title">Details : </strong>
        <br>
        		<textarea name="details" style="width: 600px; height: 150px;"></textarea>
        <br>

        <?php
        if (strpos($question_action, 'question_modify.php') === false) {
            ?>
            <strong id="tags_title">Associated Tags : </strong>
            <br>
        <input id="tags" name="tags" type="text" data-role="tagsinput" placeholder="Add tags">
        <br>
        <?php }
            ?>
        <input id="submit" type="submit">

    </p>
</form>
