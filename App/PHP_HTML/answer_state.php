<script>
    function checkState(answerNumber) {
        var answerStateView = document.getElementById("answer-state-" + answerNumber);
        var state = parseInt(document.querySelector('input[name="state"]:checked').value);
        answerStateView.innerHTML = "<span>Answer has been " + (state === 2 ? "accepted" : "refused") + ".</span>";
    }
</script>

<div id="answer-state-<?php echo $a ?>" class="answer-state">
    <?php if ($get_answers['answer_state'] == 1) { ?>
        <form class="answer-state-form" name="answerState"
              action="answer_state_2.php?id=<?php echo $get_answers['answers_id'] ?>&question_id==<?php echo $get_answers['reply_questions'] ?>"
              method="post">
        <label><input type="submit" name="state" value="2" onchange="checkState(<?php echo $a ?>); this.form.submit()">
            Accept Answer</label>&nbsp;
        <label><input type="submit" name="state" value="0" onchange="checkState(<?php echo $a ?>); this.form.submit()">
            Refuse Answer</label>
        </form>
    <?php } elseif ($get_answers['answer_state'] == 2) { ?>
        <span>Answer has been accepted.</span>
    <?php } else { ?>
        <span>Answer has been refused.</span>
    <?php } ?>
</div>
