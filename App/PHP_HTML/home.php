<!DOCTYPE html>

<html>
<head>
    <link href="ask_question.css" type="text/css" rel="stylesheet">
    <?php include "header.php";
          include "Display_Questions.php"?>

    <link rel="stylesheet" type="text/css" href="home.css">

</head>
<body>
<br>
<div class="container">
    <form method="POST" action="question_submission.php">
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
</div>
<div class="container">
    <h2>Top Questions</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Interesting</a></li>
        <li><a data-toggle="tab" href="#menu2">featured</a></li>
        <li><a data-toggle="tab" href="#menu3">hot</a></li>
        <li><a data-toggle="tab" href="#menu4">week</a></li>
        <li><a data-toggle="tab" href="#menu5">month</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h3>Interesting</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions WHERE question_deleted = 0 order by question_view_count desc');
                    ?>

                </table>
            </div>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Featured</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db,'SELECT * FROM questions WHERE question_deleted = 0 order by question_upvote desc');
                    ?>

                </table>
            </div> <!-- End panel -->

        </div>
        <div id="menu3" class="tab-pane fade">
            <h3>Hot</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions where DATE(question_date) = DATE(NOW()) AND question_deleted = 0')
                    ?>

                </table>
            </div>
        </div>
        <div id="menu4" class="tab-pane fade">
            <h3>Week</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db,'SELECT * FROM questions where (question_date between NOW() - INTERVAL 7 DAY AND NOW()) AND question_deleted = 0')
                    ?>

                </table>
            </div>
        </div>
        <div id="menu5" class="tab-pane fade">
            <h3>Month</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions where (question_date between NOW() - INTERVAL 30 DAY AND NOW()) AND question_deleted = 0')
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
</section>


</body>
</html>
