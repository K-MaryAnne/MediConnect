<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$pat_id = $_SESSION['pat_id'];
$pat_number = $_SESSION['pat_number'];

// Get patient details
$ret = "SELECT * FROM his_patients WHERE pat_number=?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $pat_number);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_object();

// Function to calculate age from date of birth
function calculateAge($dob) {
    $dob = new DateTime($dob);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y; // Return years
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php"); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content -->
                <div class="container-fluid">

                    <!-- Start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                        <li class="breadcrumb-item active">View My Profile</li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->pat_fname; ?> <?php echo $row->pat_lname; ?>'s Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- End page title -->

                    <!-- Patient Profile Details -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Full Name</th>
                                                <td><?php echo $row->pat_fname; ?> <?php echo $row->pat_lname; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td><?php echo $row->pat_addr; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile Phone</th>
                                                <td><?php echo $row->pat_phone; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td><?php echo $row->pat_dob; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Age</th>
                                                <td><?php echo calculateAge($row->pat_dob); ?> years</td>
                                            </tr>
                                            <!-- Additional fields can be added as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php'); ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
