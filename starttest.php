<?php include 'inc/header.php'; ?>
<?php
Session::checkSession();

if (!isset($_GET['cat_id'])) {
    header("Location: exam.php");
    exit();
}

$cat_id = (int) $_GET['cat_id'];
$category = $exam->getCategoryById($cat_id); // Get selected category
$total = $exam->getTotalQuestionsByCategory($cat_id);
$firstQ = $exam->getFirstQuestionByCategory($cat_id);
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg start-card">
                <div class="card-body p-5 text-center">
                    
                    <h1 class="card-title start-heading">
                        Welcome to <?php echo htmlspecialchars($category['category_name']); ?> Exam
                    </h1>
                    <p class="lead mb-4 text-muted">Test Your Knowledge</p>
                    <hr class="my-4 info-divider">

                    <div class="exam-details mb-5">
                        <p class="detail-item">
                            <i class="fa fa-list-ol detail-icon"></i> 
                            <strong>Number of Questions:</strong> <span class="detail-value"><?php echo $total; ?></span>
                        </p>
                        <p class="detail-item">
                            <i class="fa fa-question-circle detail-icon"></i> 
                            <strong>Question Type:</strong> <span class="detail-value">Multiple Choice</span>
                        </p>
                    </div>

                    <?php if ($total > 0 && $firstQ) { ?>
                        <a href="test.php?q=<?php echo $firstQ['quesNo']; ?>&cat_id=<?php echo $cat_id; ?>" 
                           class="btn btn-success btn-xl start-btn">
                           <span class="fa fa-arrow-right"></span> Start Exam
                        </a>
                    <?php } else { ?>
                        <div class="alert alert-warning">No questions found for this category!</div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Styling */
.start-card {
    border: none;
    border-radius: 20px;
    background: linear-gradient(160deg, #ffffff 0%, #f7f9fc 100%);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}
.start-card:hover {
    transform: translateY(-5px);
}

/* Heading */
.start-heading {
    font-weight: 800;
    color: #2c3e50;
    font-size: 2.25rem;
    margin-bottom: 0.5rem;
}

/* Divider */
.info-divider {
    border-top: 1px solid #e0e0e0;
    width: 60%;
    margin: 2rem auto;
}

/* Exam Details */
.exam-details {
    padding: 20px 0;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.detail-item {
    font-size: 1.15rem;
    margin-bottom: 10px;
    color: #34495e;
    font-weight: 500;
}

.detail-icon {
    color: #2ecc71;
    margin-right: 10px;
}

.detail-value {
    font-weight: 700;
    color: #27ae60;
}

/* Start Button */
.start-btn {
    font-size: 1.5rem;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 700;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    background-color: #2ecc71;
    border-color: #2ecc71;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4);
}

.start-btn:hover {
    background-color: #27ae60;
    border-color: #27ae60;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.6);
}
</style>

<?php include 'inc/footer.php'; ?>
