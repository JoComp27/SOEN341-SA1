<!DOCTYPE html>

<html>
<head>
    <script type="text/javascript" src="\SOEN341-SA1\Library\nicEdit\nicEdit.js"></script>
    <script type="text/javascript" src="/SOEN341-SA1/Library/bootstrapTags/bootstrap-tagsinput.js"></script>
    <link rel="stylesheet" type="text/css" href="/SOEN341-SA1/Library/bootstrapTags/bootstrap-tagsinput.css">
    <script type="text/javascript">
        bkLib.onDomLoaded(function () {
            nicEditors.editors.push(
                new nicEditor().panelInstance(
                    document.getElementById('details')
                )
            );
        });
    </script>



</head>
<body>

<?php
$modifyingQuestion = !(strpos($question_action, 'question_modify.php') === false);
?>

<form id="question-form" method="POST" action="<?php echo "$question_action" ?>"> <!-- generic action on question for
                                                                                       separation of behaviour and view.-->
    <p id="question_field" name="question_field" class="hidden">
        <strong id="title_title" class="pretty">Title : </strong><br>
        <input type="text" name="title"
               value="<?php if ($modifyingQuestion) {
                   echo $data['question_title'];
               } ?>"
               required>
        <br><br>

        <strong id="details_title">Details : </strong>
        <br>
        <textarea name="details" id="details" style="width: 600px; height: 150px;">
            <?php if ($modifyingQuestion) {
                echo $data['question_description'];
            } ?>
        </textarea>
        <br>
        <strong id="tags_title">Associated Tags : </strong>
        <br>
        <input id="tags" name="tags" type="text" data-role="tagsinput" placeholder="Add tags"
               value="<?php
               if ($modifyingQuestion) {
                   echo $tagsValue;
               } ?>"
        >
        <br>
        <input id="submit" type="submit">
    </p>
</form>

</body>
</html>
