<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate your Doctor</title>
    <link rel="stylesheet" href="<?= base_url('public/css/bootstrap.min.css') ?>">
    <!-- Add any additional CSS links here -->
</head>
<body>
    <div class="container">
        <h2>Rate Doctor: <?= esc($doctor['First_Name'] . ' ' . $doctor['Last_Name']) ?></h2>

        <!-- Display error message if there's any -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Display success message if rating submitted successfully -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('rating/rateDoctor/' . $doctor['User_id']) ?>" method="post">
            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <input type="number" name="rating" class="form-control" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea name="review" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
    </div>

    <script src="<?= base_url('public/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Add any additional JavaScript files or scripts here -->
</body>
</html>
