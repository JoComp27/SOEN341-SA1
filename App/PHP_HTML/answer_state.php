<div class="answer-state">
    <?php if ($get_answers['answer_state'] == 1) { ?>
        <form action="">
            <input type="radio" name="state" value="2">Accept Answer &nbsp;
            <input type="radio" name="state" value="0">Refuse Answer
        </form>
    <?php } elseif ($get_answers['answer_state'] == 2) { ?>
        <span>Answer has been accepted</span>
    <?php } else { ?>
        <span>Answer has been refused</span>
    <?php } ?>
</div>