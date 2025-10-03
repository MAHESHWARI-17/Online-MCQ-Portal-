<?php include 'inc/header.php'; ?>
<?php
Session::checkSession();

if (!isset($_GET['cat_id']) || !isset($_GET['q'])) {
    header("Location: exam.php");
    exit();
}

$cat_id = (int)$_GET['cat_id'];
$quesNo = (int)$_GET['q'];

// --- Fetch Question and Answers ---
$total = $exam->getTotalQuestionsByCategory($cat_id);
$question = $exam->getQuestionByCategoryAndNumber($cat_id, $quesNo);
$answers = $exam->getAnswer($quesNo);

// --- Calculate Display Number ---
$allQues = $exam->getQuestionsByCategory($cat_id);
$display_number = 1;
if ($allQues) {
    $i = 1;
    while ($q = $allQues->fetch_assoc()) {
        if ($q['quesNo'] == $quesNo) {
            $display_number = $i;
            break;
        }
        $i++;
    }
}

// --- Handle Form Submission ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ans'])) {
        $exam->saveAnswer($quesNo, $_POST['ans'], $cat_id); // Save answer
    }

    // If SUBMIT button clicked
    if (isset($_POST['submit_exam'])) {
        header("Location: viewans.php?cat_id=" . $cat_id);
        exit();
    }

    // Else, handle NEXT
    $nextQuestion = $exam->getNextQuestion($cat_id, $quesNo);
    if ($nextQuestion) {
        header("Location: test.php?q=" . $nextQuestion['quesNo'] . "&cat_id=" . $cat_id);
        exit();
    } else {
        header("Location: viewans.php?cat_id=" . $cat_id);
        exit();
    }
}
?>

<!-- HTML and Form Rendering -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg test-card">
                <div class="card-body p-5">

                    <h2 class="text-center mb-4 test-header">
                        Question <?php echo $display_number; ?> of <?php echo $total; ?>
                    </h2>
                    <hr class="my-4">

                    <?php if ($question) { ?>
                        <h3>Que <?php echo $question['quesNo']; ?>: <?php echo htmlspecialchars($question['ques']); ?></h3>
                        <br/>

                        <form method="post" action="">
                            <input type="hidden" name="quesNo" value="<?php echo $quesNo; ?>">

                            <div class="options-list">
                                <?php $ans_i = 1; ?>
                                <?php if ($answers) { while ($ans = $answers->fetch_assoc()) { ?>
                                    <div class="form-check custom-radio-option">
                                        <input class="form-check-input" type="radio" name="ans" id="ans_<?php echo $ans_i; ?>" value="<?php echo $ans['id']; ?>" required>
                                        <label class="form-check-label" for="ans_<?php echo $ans_i; ?>">
                                            <?php echo $ans['ans']; ?>
                                        </label>
                                    </div>
                                <?php $ans_i++; } } ?>
                            </div>

                            <div class="mt-4 text-center">
                                <?php 
                                    $nextQuestion = $exam->getNextQuestion($cat_id, $quesNo);
                                    if ($nextQuestion) {
                                        echo '<button type="submit" name="next" class="btn btn-primary btn-lg next-btn"><span class="fa fa-arrow-right"></span> Next Question</button>';
                                    } else {
                                        echo '<button type="submit" name="submit_exam" class="btn btn-success btn-lg submit-btn"><span class="fa fa-check"></span> Submit Exam</button>';
                                    }
                                ?>
                            </div>
                        </form>
                    <?php } else { ?>
                        <div class="alert alert-danger text-center">Question not found.</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
