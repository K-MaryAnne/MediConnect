<?php
// Start the session if it hasn't been started
if (!isset($_SESSION)) {
    session_start();
}

// Include database connection
$mysqli = null;
$config_path = __DIR__ . '/config.php'; // Adjust the path if necessary
if (file_exists($config_path)) {
    include($config_path);
}

// Check if session variables are set
if (isset($_SESSION['pat_id']) && isset($_SESSION['pat_number'])) {
    $pat_id = $_SESSION['pat_id'];
    $pat_number = $_SESSION['pat_number'];
    
    // Ensure $mysqli is available
    if ($mysqli) {
        $ret = "SELECT * FROM his_patients WHERE pat_id = ? AND pat_number = ?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('is', $pat_id, $pat_number);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
?>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            <li class="d-none d-sm-block">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <i class="fe-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/users/<?php echo $row->pat_profpic; ?>" alt="pat_profpic" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <?php echo $row->pat_fname; ?> <?php echo $row->pat_lname; ?> <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="pat_update_patient.php" class="dropdown-item notify-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Update Account</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="pat_logout_partial.php" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <span class="logo-lg">
                <img src="assets/images/mediconnectlogo.png" alt="" height="90">
            </span>
           
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
        </ul>
    </div>
<?php
        }
    } else {
        echo "Error: Database connection not established.";
    }
} else {
    echo "Error: User not logged in.";
}
?>
