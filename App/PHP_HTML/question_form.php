<!DOCTYPE html>

<html>
<head>
    <script type="text/javascript" src="nicEdit.js"></script>
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

                   $sql3 = "SELECT tag_name FROM tags T INNER JOIN question_tags QT ON T.tag_id = QT.tag_id WHERE QT.question_id = '{$data["question_id"]}'";
                   $tag_data = mysqli_query($db, $sql3);

                   $tag_array[] = [];

                   while ($tag = mysqli_fetch_row($tag_data)) {
                       array_push($tag_array, $tag[0]);
                   }

                   array_shift($tag_array);

                   $tags = implode(",", $tag_array);

                   echo $tags;
               } else {
                   echo "";
               } ?>">
        <br>

        <input id="submit" type="submit">
    </p>
</form>

</body>
</html>
