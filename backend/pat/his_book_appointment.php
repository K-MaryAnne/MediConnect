<?php
session_start();
include('assets/inc/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the patient is logged in
if (!isset($_SESSION['pat_id'])) {
    header("Location: index.php");
    exit();
}

// Initialize variables
$success = $err = '';

if (isset($_POST['book_appointment'])) {
    $pat_id = $_SESSION['pat_id'];
    $doc_id = $_POST['doc_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $duration = $_POST['duration'];

    // Check if the appointment date is in the future
    $currentDateTime = new DateTime();
    $selectedDateTime = new DateTime("$appointment_date $appointment_time");
    if ($selectedDateTime < $currentDateTime) {
        $err = "You cannot book appointments for past dates or times.";
    } else {
        // Check if the appointment slot is already taken
        $query = "SELECT * FROM appointments WHERE doc_id = ? AND appointment_date = ? AND appointment_time = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iss', $doc_id, $appointment_date, $appointment_time);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $err = "The selected date and time is already taken. Please choose a different slot.";
        } else {
            // Insert the new appointment
            $query = "INSERT INTO appointments (pat_id, doc_id, appointment_date, appointment_time, duration) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('iissi', $pat_id, $doc_id, $appointment_date, $appointment_time, $duration);
            $stmt->execute();

            if ($stmt) {
                $success = "Appointment booked successfully";

                // Fetch patient details
                $query = "SELECT pat_email FROM his_patients WHERE pat_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('i', $pat_id);
                $stmt->execute();
                $res = $stmt->get_result();
                $patient = $res->fetch_object();

                // Send confirmation email
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.example.com'; // Set the SMTP server to send through
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@example.com'; // SMTP username
                    $mail->Password = 'your_email_password'; // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    //Recipients
                    $mail->setFrom('your_email@example.com', 'MediConnect');
                    $mail->addAddress($patient->pat_email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Appointment Confirmation';
                    $mail->Body    = "Dear Patient,<br><br>Your appointment has been successfully booked.<br><br>Details:<br>Date: $appointment_date<br>Time: $appointment_time<br>Duration: $duration minutes<br><br>Thank you,<br>MediConnect";

                    $mail->send();
                } catch (Exception $e) {
                    $err = "Appointment booked but failed to send email. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $err = "Failed to book appointment. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('assets/inc/head.php'); ?>
</head>
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

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="patient_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Appointments</a></li>
                                    <li class="breadcrumb-item active">Book Appointment</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Book an Appointment</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Fill all fields</h4>

                                

                                <!-- Booking Form -->
                                <form method="post">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="doc_id" class="col-form-label">Select Doctor</label>
                                            <select name="doc_id" class="form-control" id="doc_id" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                $query = "SELECT * FROM his_docs";
                                                $stmt = $mysqli->prepare($query);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                while($doc = $res->fetch_object()) {
                                                    echo "<option value='$doc->doc_id'>$doc->doc_fname $doc->doc_lname</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="appointment_date" class="col-form-label">Date</label>
                                            <input type="date" name="appointment_date" class="form-control" id="appointment_date" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="appointment_time" class="col-form-label">Time</label>
                                            <input type="time" name="appointment_time" class="form-control" id="appointment_time" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="duration" class="col-form-label">Duration</label>
                                            <select name="duration" class="form-control" id="duration" required>
                                                <option value="30">30 minutes</option>
                                                <option value="60">1 hour</option>
                                                <option value="90">1.5 hours</option>
                                                <option value="120">2 hours</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" name="book_appointment" class="btn btn-success">Book Appointment</button>
                                </form>
                                <!-- End Booking Form -->
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
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

<!-- App js-->
<script src="assets/js/app.min.js"></script>

</body>
</html>
