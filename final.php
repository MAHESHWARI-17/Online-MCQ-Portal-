<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();

  if (!isset($_GET['cat_id'])) {
      header("Location: exam.php");
      exit();
  }

  $cat_id = (int) $_GET['cat_id'];
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Congrats! You completed <?php echo $exam->
            getCategoryById($cat_id)['category_name']; ?> Exam</h1>
            <p class="lead">Check your final score below.</p>
            <br/>

            <div class="jumbotron">
                <h1 class="text-danger">Final Score:
                    <?php
                        if (isset($_SESSION['score'][$cat_id])) {
                            echo $_SESSION['score'][$cat_id];
                            unset($_SESSION['score'][$cat_id]); // Clear score after showing
                        } else {
                            echo 0;
                        }
                    ?>
                </h1>
            </div>
            <br/>
            <a class="btn btn-outline-success btn-lg" href="viewans.php?cat_id=<?php echo $cat_id; ?>"><span class="fa fa-check-circle"></span> View Answers</a>
            <a class="btn btn-outline-info btn-lg" href="exam.php"><span class="fa fa-arrow-right"></span> Choose Another Category</a>
            <br/><br/>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
