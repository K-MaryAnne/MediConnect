
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediconnect Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                        <div class="user">
                <img src="imgs/assistance.png" alt="">
                </div>
                        </span>
                        <span class="title">MediConnect</span>
                    </a>
                </li>
<!-- 
                <li>
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
                </li>

                <li>
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
                    <img src="imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Daily Views</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">Sales</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">284</div>
                        <div class="cardName">Comments</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">$7,842</div>
                        <div class="cardName">Earning</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

<!-- ================ Nurses List ================= -->
<div class="container mt-5">
    <h2>Nurses List</h2>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Specialisation</th>
                <th>Years of Experience</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nurses as $nurse) : ?>
                <tr>
                    <td><?= $nurse->User_ID ?></td>
                    <td><?= $nurse->First_Name ?></td>
                    <td><?= $nurse->Last_Name ?></td>
                    <td><?= $nurse->Specialisation ?></td>
                    <td><?= $nurse->Years_of_Experience ?></td>
                    <td><?= $nurse->Email ?></td>
                    <td><?= $nurse->status ?></td>
                    <td>
                        <a href="<?= site_url('NurseCrudController/edit_nurse/' . $nurse->User_ID) ?>" class="btn btn-primary">Edit</a>
                        <a href="<?= site_url('NurseCrudController/delete_nurse/' . $nurse->User_ID) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this nurse?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <!-- ================= Recent Customers ================ -->
    <!-- <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Recent Customers</h2>
        </div>

        <table>
            <tr>
                <td width="60px">
                    <div class="imgBx"><img src="imgs/customer02.jpg" alt=""></div>
                </td>
                <td>
                    <h4>David <br> <span>Italy</span></h4>
                </td>
            </tr>

            <tr>
                <td width="60px">
                    <div class="imgBx"><img src="imgs/customer01.jpg" alt=""></div>
                </td>
                <td>
                    <h4>Amit <br> <span>India</span></h4>
                </td>
            </tr>
            
            // Add more customers as needed
        </table>
    </div>
</div>
</div>
</div> -->




    <!-- =========== Scripts =========  -->
    <script src="js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>