<?php
session_start();
include('assets/inc/config.php');

// Check if the doctor is logged in
if (!isset($_SESSION['doc_id'])) {
    header("Location: index.php");
    exit();
}

$doc_id = $_SESSION['doc_id'];

if (isset($_POST['accept_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "UPDATE appointments SET status = 'Accepted' WHERE appointment_id = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Preparation failed: " . $mysqli->error);
    }
    $stmt->bind_param('i', $appointment_id);
    $stmt->execute();
} elseif (isset($_POST['reject_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "UPDATE appointments SET status = 'Rejected' WHERE appointment_id = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Preparation failed: " . $mysqli->error);
    }
    $stmt->bind_param('i', $appointment_id);
    $stmt->execute();
}

// Fetch upcoming appointments
$query = "SELECT a.*, p.pat_fname, p.pat_lname 
          FROM appointments a 
          JOIN his_patients p ON a.pat_id = p.pat_id 
          WHERE a.doc_id = ? AND a.appointment_date >= CURDATE() 
          ORDER BY a.appointment_date, a.appointment_time";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die("Query preparation failed: " . $mysqli->error);
}

$stmt->bind_param('i', $doc_id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res) {
    die("Query execution failed: " . $stmt->error);
}

// Debugging: Check number of results and some sample data
$num_results = $res->num_rows;
echo "<script>console.log('Number of results: " . $num_results . "');</script>";

if ($num_results > 0) {
    $first_row = $res->fetch_assoc();
    echo "<script>console.log('First row data: " . json_encode($first_row) . "');</script>";
    // Reset the result pointer to the beginning
    $res->data_seek(0);
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
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="doctor_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Appointments</a></li>
                                    <li class="breadcrumb-item active">View Appointments</li>
                                </ol>
                            </div>
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
                                            <th>Patient Name</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if ($num_results === 0) {
                                            echo "<tr><td colspan='6'>No appointments found</td></tr>";
                                        } else {
                                            while ($appointment = $res->fetch_object()) { ?>
                                                <tr>
                                                    <td><?php echo $appointment->pat_fname . " " . $appointment->pat_lname; ?></td>
                                                    <td><?php echo $appointment->appointment_date; ?></td>
                                                    <td><?php echo $appointment->appointment_time; ?></td>
                                                    <td><?php echo $appointment->duration . " minutes"; ?></td>
                                                    <td><?php echo $appointment->status; ?></td>
                                                    <td>
                                                        <?php if ($appointment->status == 'Pending') { ?>
                                                            <form method="post" style="display:inline;">
                                                                <input type="hidden" name="appointment_id" value="<?php echo $appointment->appointment_id; ?>">
                                                                <button type="submit" name="accept_appointment" class="btn btn-success">Accept</button>
                                                            </form>
                                                            <form method="post" style="display:inline;">
                                                                <input type="hidden" name="appointment_id" value="<?php echo $appointment->appointment_id; ?>">
                                                                <button type="submit" name="reject_appointment" class="btn btn-danger">Reject</button>
                                                            </form>
                                                        <?php } else { ?>
                                                            <span class="badge badge-<?php echo $appointment->status == 'Accepted' ? 'success' : 'danger'; ?>">
                                                                <?php echo $appointment->status; ?>
                                                            </span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                        <?php 
                                            } 
                                        } 
                                        ?>
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
