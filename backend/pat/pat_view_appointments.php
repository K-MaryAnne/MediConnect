<?php
session_start();
include('assets/inc/config.php');

// Check if the patient is logged in
if (!isset($_SESSION['pat_id'])) {
    header("Location: index.php");
    exit();
}

$pat_id = $_SESSION['pat_id'];

// Fetch upcoming appointments for the patient
$query = "SELECT a.*, d.doc_fname, d.doc_lname 
          FROM appointments a 
          JOIN his_docs d ON a.doc_id = d.doc_id 
          WHERE a.pat_id = ? AND a.appointment_date >= CURDATE() 
          ORDER BY a.appointment_date, a.appointment_time";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die("Query preparation failed: " . $mysqli->error);
}

$stmt->bind_param('i', $pat_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "No appointments found";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('assets/inc/head.php'); ?>
</head>
<body>

<div id="wrapper">
    <?php include("assets/inc/nav.php"); ?>
    <?php include("assets/inc/sidebar.php"); ?>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">View Upcoming Appointments</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Upcoming Appointments</h4>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($appointment = $res->fetch_object()) { ?>
                                            <tr>
                                                <td><?php echo $appointment->doc_fname . " " . $appointment->doc_lname; ?></td>
                                                <td><?php echo $appointment->appointment_date; ?></td>
                                                <td><?php echo $appointment->appointment_time; ?></td>
                                                <td><?php echo $appointment->duration . " minutes"; ?></td>
                                                <td><?php echo $appointment->status; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php include('assets/inc/footer.php'); ?>
    </div>
</div>

<div class="rightbar-overlay"></div>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

</body>
</html>
