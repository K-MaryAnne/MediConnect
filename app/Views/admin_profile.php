<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Include any additional stylesheets or scripts here -->
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Admin Profile</h3>
                        <form action="<?= base_url('admin/updateProfile') ?>" method="post" enctype="multipart/form-data">
                            <!-- Display error messages if any -->
                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= session('error') ?>
                                </div>
                            <?php endif; ?>

                            <!-- Display success messages if any -->
                            <?php if (session()->has('success')): ?>
                                <div class="alert alert-success" role="alert">
                                    <?= session('success') ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $admin->First_Name ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $admin->Last_Name ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $admin->Email ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= $admin->Phone_Number ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= $admin->Address ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="town" class="form-label">Town</label>
                                <input type="text" class="form-control" id="town" name="town" value="<?= $admin->Town ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= $admin->Date_of_Birth ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image">
                                <?php if (!empty($admin->Profile_Photo)): ?>
                                    <img src="<?= base_url($admin->Profile_Photo) ?>" class="mt-2" style="max-width: 200px;" alt="Profile Photo">
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
