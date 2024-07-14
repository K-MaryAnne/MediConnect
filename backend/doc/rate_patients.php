<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_POST['submit_rating'])) {
    $doc_id = $_SESSION['doc_id'];
    $pat_id = $_POST['pat_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Insert into ratings table
    $query = "INSERT INTO ratings (doc_id, pat_id, rating, review, rating_date) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iiis', $doc_id, $pat_id, $rating, $review);
    if ($stmt->execute()) {
        // Rating successfully added
        $success = "Rating submitted successfully.";
    } else {
        // Error occurred
        $error = "Failed to submit rating. Please try again.";
    }
}

// Fetch patients for dropdown
$query_patients = "SELECT * FROM his_patients";
$result_patients = $mysqli->query($query_patients);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .rating {
        unicode-bidi: bidi-override;
        direction: ltr; /* Left-to-right direction */
        text-align: center;
    }

    .rating>span {
        display: inline-block;
        position: relative;
        width: 1.1em;
        font-size: 24px;
        cursor: pointer;
        color: #ccc; /* Default color for unselected stars */
    }

    .rating>span:hover:before,
    .rating>span:hover~span:before {
        content: "\2605";
        position: absolute;
        color: gold; /* Color on hover */
    }

    .rating>span:before {
        content: "\2606";
        position: absolute;
    }
</style>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include('assets/inc/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Rate Patients</h4>
                            </div>
                        </div>
                    </div>     

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title">Rate Patients</h4>
                                <form method="post">
                                    <div class="form-group">
                                        <label>Select Patient:</label>
                                        <select class="form-control" name="pat_id" required>
                                            <option value="">Select Patient</option>
                                            <?php while ($row = $result_patients->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['pat_id']; ?>"><?php echo $row['pat_fname'] . ' ' . $row['pat_lname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Rating:</label>
                                        <div class="rating">
                                            <span data-value="1"><i class="fas fa-star"></i></span>
                                            <span data-value="2"><i class="fas fa-star"></i></span>
                                            <span data-value="3"><i class="fas fa-star"></i></span>
                                            <span data-value="4"><i class="fas fa-star"></i></span>
                                            <span data-value="5"><i class="fas fa-star"></i></span>
                                            <input type="hidden" name="rating" id="rating" value="0">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Review:</label>
                                        <textarea class="form-control" name="review" rows="3"></textarea>
                                    </div>
                                    <button type="submit" name="submit_rating" class="btn btn-success">Submit Rating</button>
                                </form>
                                <?php
                                if (isset($success)) {
                                    echo '<p class="text-success mt-2">' . $success . '</p>';
                                }
                                if (isset($error)) {
                                    echo '<p class="text-danger mt-2">' . $error . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include('assets/inc/footer.php'); ?>

        </div>
    </div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script>
        // JavaScript to handle star rating interaction
        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll(".rating span");

            stars.forEach((star, index) => {
                star.addEventListener("mouseenter", function () {
                    const value = star.getAttribute('data-value');
                    highlightStars(value);
                });

                star.addEventListener("mouseleave", function () {
                    const ratingValue = document.getElementById("rating").value;
                    highlightStars(ratingValue);
                });

                star.addEventListener("click", function () {
                    const value = star.getAttribute('data-value');
                    document.getElementById("rating").value = value;
                    highlightStars(value);
                });
            });

            function highlightStars(value) {
                stars.forEach((star, index) => {
                    star.style.color = index + 1 <= value ? "gold" : "#ccc";
                });
            }
        });
    </script>
</body>
</html>
