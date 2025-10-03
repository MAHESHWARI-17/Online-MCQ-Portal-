<?php include 'inc/header.php'; ?>
<?php
Session::checkSession();

if (!isset($_GET['cat_id'])) {
    header("Location: exam.php");
    exit();
}

$cat_id = (int)$_GET['cat_id'];
$category = $exam->getCategoryById($cat_id);
$total = $exam->getTotalQuestionsByCategory($cat_id);

// --- Calculate Score and Clear Session Answers ---
$score = $exam->getResult($cat_id);
$exam->removeAnswers($cat_id); // Clear answers after grading

// Determine pass/fail status (50% threshold example)
$pass_threshold = 0.5;
$passed = ($total > 0 && ($score / $total) >= $pass_threshold);
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <!-- Result Card -->
        <div class="col-lg-8 mb-5">
            <div class="card shadow-lg p-5 text-center result-card">
                <h1 class="result-heading mb-4">Exam Results for <?php echo htmlspecialchars($category['category_name']); ?></h1>

                <div class="score-box p-4 rounded mb-4">
                    <p class="mb-0 score-label">Total Questions: <?php echo $total; ?></p>
                    <h2 class="score-value my-3 <?php echo $passed ? 'text-success' : 'text-danger'; ?>">
                        Your Score: <?php echo $score; ?> / <?php echo $total; ?>
                    </h2>
                    <p class="mb-0 score-status font-weight-bold">
                        <?php echo $passed ? '🎉 Congratulations! You Passed the Exam!' : '😔 Keep practicing! You can do better next time.'; ?>
                    </p>
                </div>

                <a href="exam.php" class="btn btn-primary btn-lg mt-3">Start Another Exam</a>
            </div>
        </div>

        <!-- Detailed Answer Review -->
        <div class="col-lg-10">
            <h2 class="text-center mb-4 answer-review-heading">Detailed Answer Review</h2>

            <div class="card shadow-sm p-4">
                <?php
                $questions = $exam->getQuestionsByCategory($cat_id);
                if ($questions) {
                    $q_index = 1;
                    while ($question = $questions->fetch_assoc()) {
                        $quesNo = $question['quesNo'];
                ?>
                <div class="question-container mb-4 p-3 border rounded shadow-sm">
                    <strong>Que <?php echo $q_index; ?>: <?php echo htmlspecialchars($question['ques']); ?></strong>
                    <ul class="list-unstyled mt-3 answer-options">
                        <?php
                        $answers = $exam->getAnswer($quesNo);
                        if ($answers) {
                            while ($ans = $answers->fetch_assoc()) {
                        ?>
                        <li class="p-2 <?php echo ($ans['rightAns'] == '1') ? 'correct-answer' : ''; ?>">
                            <?php if ($ans['rightAns'] == '1') { ?>
                                <i class="fa fa-check-circle correct-icon"></i> 
                                <strong><?php echo htmlspecialchars($ans['ans']); ?></strong> (Correct Answer)
                            <?php } else { ?>
                                <i class="fa fa-dot-circle review-icon"></i>
                                <?php echo htmlspecialchars($ans['ans']); ?>
                            <?php } ?>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <?php $q_index++; } 
                } else { ?>
                    <div class="alert alert-warning text-center">No questions found for review!</div>
                <?php } ?>
            </div>

            <a href="exam.php" class="btn btn-success btn-lg mt-5">
                <span class="fa fa-arrow-left"></span> Back to Categories
            </a>
        </div>
    </div>
</div>

<style>
body {
    background: linear-gradient(to right, #ece9e6, #ffffff);
    min-height: 100vh;
}

/* Result Card */
.result-card {
    border: none;
    border-radius: 15px;
    background: linear-gradient(160deg, #ffffff 0%, #f7f9fc 100%);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}
.result-heading {
    font-weight: 800;
    color: #2c3e50;
    font-size: 2rem;
}
.score-box {
    border: 3px solid #ddd;
    background-color: #f0f0f0;
    border-radius: 10px !important;
}
.score-label { font-weight: 500; color: #7f8c8d; }
.score-value { font-size: 2.5rem; font-weight: 900; }
.text-success { color: #2ecc71 !important; }
.text-danger { color: #e74c3c !important; }

/* Answer Review */
.answer-review-heading {
    font-weight: 700;
    color: #34495e;
    font-size: 1.75rem;
}
.question-container {
    background-color: #ffffff;
    border: 1px solid #e0e0e0 !important;
}
.answer-options li {
    padding: 10px 15px !important;
    border-bottom: 1px dashed #eee;
    color: #333;
}
.correct-answer {
    background-color: #e9fff4; /* Light green */
    font-weight: 500;
}
.correct-icon { color: #2ecc71; margin-right: 5px; }
.review-icon { color: #95a5a6; margin-right: 5px; }
.list-unstyled { padding-left: 0; }
</style>

<?php include 'inc/footer.php'; ?>
