<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor - Mediconnect Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                        <img src="imgs/assistance.png" alt="">
                        </span>
                        <span class="title">MediConnect</span>
                    </a>
                </li>

                <!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li> -->

                <li>
                    <a href="<?= base_url('manage-users') ?>">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Users</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('applications_view') ?>">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">User Applications</span>
                    </a>
                </li>

                <li>
    <a href="<?= base_url('stats') ?>">
        <span class="icon">
            <ion-icon name="stats-chart-outline"></ion-icon>
        </span>
        <span class="title">Stats</span>
    </a>
</li>


                <li>
                    <a href="<?= base_url('admin/profile') ?>">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Profile</span>
                    </a>
                </li>

                <!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li> -->

                <!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li> -->
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                <img src="imgs/admin.png" alt="">
                </div>
            </div>

            

            <!-- ======================= Edit Doctor ================== -->
            <div class="container mt-5">
                <h2>Edit Doctor</h2>
                <!-- Display Validation Errors -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <form action="<?= site_url('DoctorCrudController/update_doctor/'.$doctor->User_ID) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="First_Name">First Name</label>
                        <input type="text" class="form-control" id="First_Name" name="First_Name" value="<?= $doctor->First_Name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Last_Name">Last Name</label>
                        <input type="text" class="form-control" id="Last_Name" name="Last_Name" value="<?= $doctor->Last_Name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Specialisation">Specialisation</label>
                        <input type="text" class="form-control" id="Specialisation" name="Specialisation" value="<?= $doctor->Specialisation ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Years_of_Experience">Years of Experience</label>
                        <input type="number" class="form-control" id="Years_of_Experience" name="Years_of_Experience" value="<?= $doctor->Years_of_Experience ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email" value="<?= $doctor->Email ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" <?= $doctor->status == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $doctor->status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="<?= site_url('view-doctors') ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
