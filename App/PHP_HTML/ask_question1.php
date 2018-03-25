<!DOCTYPE html>

<html>
<head>
<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() {
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
$qus_id = $_GET['id'];

if (strpos($question_action, 'question_modify.php') === true) {
include('sql_connector.php'); 

$select_query = "select * from questions where question_id = '$qus_id'  and question_deleted = 0 ";
$question_data = mysqli_query($db, $select_query) or die(mysqli_error($db));
$data = mysqli_fetch_assoc($question_data);
}
?>

<form id="question-form" method="POST" action="<?php echo "$question_action" ?>"> <!-- generic action on question for
                                                                                       separation of behaviour and view.-->
    <p id="question_field" name="question_field" class="hidden">
        <strong id="title_title" class="pretty">Title : </strong>
        <br>
        <input type="text" name="title">
        <br>
        <strong id="details_title">Details : </strong>
        <br>
		<textarea name="details" id="details" style="width: 600px; height: 150px;" >
            <?php echo $data['question_description']?>
        </textarea>
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

</body>
</html>
