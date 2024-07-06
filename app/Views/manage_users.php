
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
        <span class="title">Statistics</span>
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
                <img src="imgs/admin.png" alt="">
                </div>
            </div>

           <!-- ======================= Cards ================== -->
<div class="cardBox">
    <a href="<?= base_url('view-doctors') ?>">
        <div class="card">
            <div>
                <div class="numbers">Doctors</div>
                <div class="cardName">View Doctors</div>
            </div>
            <div class="iconBx">
                <ion-icon name="medkit-outline"></ion-icon>
            </div>
        </div>
    </a>

    <a href="<?= base_url('view-nurses') ?>">
        <div class="card">
            <div>
                <div class="numbers">Nurses</div>
                <div class="cardName">View Nurses</div>
            </div>
            <div class="iconBx">
                <ion-icon name="heart-outline"></ion-icon>
            </div>
        </div>
    </a>

    <a href="<?= base_url('view-patients') ?>">
        <div class="card">
            <div>
                <div class="numbers">Patients</div>
                <div class="cardName">View Patients</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </div>
    </a>
</div>


<!-- ================ Doctors List ================= -->
<!-- <div class="details">
    <div class="recentDoctors">
        <div class="cardHeader">
            <h2>Doctors</h2>
            <a href="#" class="btn">View All</a>
        </div>

        <table>
            <thead>
                <tr>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Specialisation</td>
                    <td>Years of Experience</td>
                    <td>Rating</td>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($doctors) && is_array($doctors)): ?>
                    <?php foreach ($doctors as $doctor): ?>
                    <tr>
                        <td><?= esc($doctor->First_Name) ?></td>
                        <td><?= esc($doctor->Last_Name) ?></td>
                        <td><?= esc($doctor->Specialisation) ?></td>
                        <td><?= esc($doctor->Years_of_Experience) ?></td>
                        <td><?= esc($doctor->Rating) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No doctors found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> -->

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