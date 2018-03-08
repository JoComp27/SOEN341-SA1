<form method="POST" action="<?php $question_action ?>"> <!-- generic action on question for separation of
                                                             behaviour and view.-->
    <button id="ask" type="button"><span> Ask a Question!</span></button>
    <br>
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

        <input id="tags" name="tags" type="text" data-role="tagsinput" placeholder="Add tags">
        <br>
        <input id="submit" type="submit">
    </p>
</form>