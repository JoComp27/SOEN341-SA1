<?php include('sql_connector.php'); ?>

// PURPOSE: runs query that modifies a question

<?php
$title = $_POST["title"];
$details = $_POST["details"];
$tags = $_POST["tags"];
$questionId = $_GET["questionId"];

$query = "UPDATE questions
          SET question_title = '$title', question_description  = '$details'
          WHERE question_id = '$questionId'";
mysqli_query($db, $query) or die(mysqli_error($db));

$query = "DELETE FROM question_tags WHERE question_id = '$questionId'";
mysqli_query($db, $query) or die(mysqli_error($db));

$tagArray = explode(",", $tags);

foreach ($tagArray as $tag) {
    $sql = " INSERT INTO tags (tag_name) VALUES (\"$tag\") ";
    $db->query($sql);

    $sql = " SELECT tag_id FROM tags WHERE tag_name = \"$tag\"";
    $result = $db->query($sql);
    $Tid = $result->fetch_row();
    $Tid_int = intval($Tid[0]);

    $sql = "INSERT INTO question_tags (question_id, tag_id) VAlUES($questionId, $Tid_int)";
    $db->query($sql);
}

$redirect = 'Location: answer.php?id=' . $questionId;
header($redirect);
?>
