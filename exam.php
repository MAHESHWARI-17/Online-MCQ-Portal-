<?php include 'inc/header.php'; ?>
<?php
Session::checkSession(); // Make sure user is logged in
$categories = $exam->getCategories(); // Fetch all categories

// Define an array of attractive colors for the buttons
$button_colors = [
    '#007bff', // Blue
    '#28a745', // Green
    '#dc3545', // Red
    '#ffc107', // Yellow
    '#17a2b8', // Cyan
    '#6f42c1', // Purple
    '#fd7e14', // Orange
    '#e83e8c', // Pink
    '#6610f2', // Indigo
    '#20c997', // Teal
];

// Shuffle the colors for a random assignment each time (optional)
shuffle($button_colors);

// Initialize a counter for assigning colors
$color_index = 0;
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg category-card">
                <div class="card-body p-5 text-center">
                    <h1 class="card-title mb-4 category-heading">Select a Category to Start Exam</h1>
                    <p class="lead mb-4 text-muted">Click on any category to attempt its questions. Good luck! 🚀</p>
                    <div class="category-buttons">
                        <?php if ($categories && $categories->num_rows > 0) { ?>
                            <?php while ($cat = $categories->fetch_assoc()) { 
                                $current_color = $button_colors[$color_index % count($button_colors)];
                                $color_index++;
                            ?>
                                <a href="starttest.php?cat_id=<?php echo $cat['id']; ?>" 
                                   class="btn btn-lg category-btn m-2" 
                                   style="border-color: <?php echo $current_color; ?>; color: <?php echo $current_color; ?>;"
                                   onmouseover="this.style.backgroundColor='<?php echo $current_color; ?>'; this.style.color='#ffffff'; this.style.boxShadow='0 4px 10px <?php echo $current_color; ?>4D';"
                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?php echo $current_color; ?>'; this.style.boxShadow='none';"
                                >
                                   <?php echo htmlspecialchars($cat['category_name']); ?>
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-warning">No categories available to start the exam!</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Overall Page Background */
body {
    background: linear-gradient(to right, #ece9e6, #ffffff);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Push footer to bottom */
.container.my-5 {
    flex-grow: 1;
}

/* Main card styles */
.category-card {
    border: none;
    border-radius: 20px;
    background: linear-gradient(160deg, #ffffff 0%, #f7f9fc 100%);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}
.category-card:hover {
    transform: translateY(-5px);
}

/* Heading */
.category-heading {
    font-weight: 800;
    color: #2c3e50;
    letter-spacing: 0.5px;
}

/* Lead paragraph */
.lead {
    color: #7f8c8d;
    font-size: 1.15rem;
}

/* Category Buttons */
.category-btn {
    font-size: 1.15rem; 
    padding: 14px 30px; 
    border-radius: 30px; 
    transition: all 0.3s ease-in-out, transform 0.1s ease;
    margin: 10px; 
    font-weight: 600; 
    text-transform: uppercase; 
    letter-spacing: 0.5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border-width: 2px;
}
.category-btn:hover {
    transform: scale(1.03) translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

/* Button container */
.category-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding-top: 20px;
    gap: 15px;
}
</style>

<?php include 'inc/footer.php'; ?>
