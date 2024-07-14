<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Handle profile update
if (isset($_POST['update_profile'])) {
    $pat_fname = $_POST['pat_fname'];
    $pat_lname = $_POST['pat_lname'];
    $pat_id = $_SESSION['pat_id'];
    $pat_email = $_POST['pat_email'];
    $pat_sec_email = $_POST['pat_sec_email']; // Added secondary email
    $pat_phone = $_POST['pat_phone']; // Added phone number
    $pat_profpic = $_FILES["pat_profpic"]["name"];
    move_uploaded_file($_FILES["pat_profpic"]["tmp_name"], "assets/images/users/" . $_FILES["pat_profpic"]["name"]);

    // SQL to update captured values
    $query = "UPDATE his_patients SET pat_fname=?, pat_lname=?, pat_email=?, pat_sec_email=?, pat_phone=?, pat_profpic=? WHERE pat_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssi', $pat_fname, $pat_lname, $pat_email, $pat_sec_email, $pat_phone, $pat_profpic, $pat_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Profile Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

// Fetch patient details and average rating
$pat_id = $_SESSION['pat_id'];
$query = "SELECT p.*, 
                 COALESCE(AVG(r.rating), 0) AS avg_rating, 
                 COUNT(r.rating) AS num_ratings 
          FROM his_patients p 
          LEFT JOIN ratings r ON p.pat_id = r.pat_id 
          WHERE p.pat_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $pat_id);
$stmt->execute();
$res = $stmt->get_result();
$patient = $res->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include('assets/inc/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title"><?php echo $patient->pat_fname . " " . $patient->pat_lname; ?>'s Profile</h4>
                            </div>
                        </div>
                    </div>     

                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="assets/images/users/<?php echo $patient->pat_profpic; ?>" class="rounded-circle avatar-lg img-thumbnail"
                                    alt="profile-image">

                                <div class="text-centre mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $patient->pat_fname . " " . $patient->pat_lname; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo $patient->pat_email; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Average Rating :</strong> <span class="ml-2"><?php echo number_format($patient->avg_rating, 1); ?> (<?php echo $patient->num_ratings; ?> ratings)</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-xl-8">
                            <div class="card-box">
                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                            Update Profile
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="aboutme">
                                        <form method="post" enctype="multipart/form-data">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" name="pat_fname" class="form-control" id="firstname" value="<?php echo $patient->pat_fname; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="text" name="pat_lname" class="form-control" id="lastname" value="<?php echo $patient->pat_lname; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Email Address</label>
                                                        <input type="email" name="pat_email" class="form-control" id="useremail" value="<?php echo $patient->pat_email; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="usersecemail">Secondary Email</label>
                                                        <input type="email" name="pat_sec_email" class="form-control" id="usersecemail" value="<?php echo $patient->pat_sec_email; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userphone">Phone Number</label>
                                                        <input type="text" name="pat_phone" class="form-control" id="userphone" value="<?php echo $patient->pat_phone; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Profile Picture</label>
                                                        <input type="file" name="pat_profpic" class="form-control btn btn-success" id="useremail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div> <!-- content -->
            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
