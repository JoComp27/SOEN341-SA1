<!DOCTYPE html>

<html>
<head>
    <?php include "header.php";
    include "question_display.php" ?>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link href="question_ask_button.css" type="text/css" rel="stylesheet">
</head>
<body>
<br>
<div class="container">
    <button id="ask" class="question-form-button" type="button"><span> Ask a Question!</span></button>
    <br>
    <?php
    $question_action = 'question_submission.php'; // action can be chosen separately from form view
    include('question_form.php');                 // question form now in its own file
    ?>
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
                    displayQuestions($db, 'SELECT * FROM questions WHERE question_deleted = 0 ORDER BY question_view_count DESC');
                    ?>

                </table>
            </div>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Featured</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions WHERE question_deleted = 0 ORDER BY question_upvotes DESC');
                    ?>

                </table>
            </div> <!-- End panel -->

        </div>
        <div id="menu3" class="tab-pane fade">
            <h3>Hot</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions WHERE DATE(question_date) = DATE(NOW()) AND question_deleted = 0')
                    ?>

                </table>
            </div>
        </div>
        <div id="menu4" class="tab-pane fade">
            <h3>Week</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions WHERE (question_date BETWEEN NOW() - INTERVAL 7 DAY AND NOW()) AND question_deleted = 0')
                    ?>

                </table>
            </div>
        </div>
        <div id="menu5" class="tab-pane fade">
            <h3>Month</h3>
            <div class="tab-content">
                <table class="table">
                    <?php
                    displayQuestions($db, 'SELECT * FROM questions WHERE (question_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()) AND question_deleted = 0')
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

</body>
</html>
