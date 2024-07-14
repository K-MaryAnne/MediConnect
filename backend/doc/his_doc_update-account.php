<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_profile'])) {
    $doc_fname = $_POST['doc_fname'];
    $doc_lname = $_POST['doc_lname'];
    $doc_id = $_SESSION['doc_id'];
    $doc_email = $_POST['doc_email'];
    $doc_dpic = $_FILES["doc_dpic"]["name"];
    move_uploaded_file($_FILES["doc_dpic"]["tmp_name"], "assets/images/users/" . $_FILES["doc_dpic"]["name"]);

    $query = "UPDATE his_docs SET doc_fname=?, doc_lname=?, doc_email=?, doc_dpic=? WHERE doc_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssi', $doc_fname, $doc_lname, $doc_email, $doc_dpic, $doc_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Profile Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

if (isset($_POST['update_pwd'])) {
    $doc_number = $_SESSION['doc_number'];
    $doc_pwd = sha1(md5($_POST['doc_pwd']));

    $query = "UPDATE his_docs SET doc_pwd =? WHERE doc_number = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('si', $doc_pwd, $doc_number);
    $stmt->execute();

    if ($stmt) {
        $success = "Password Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

// Fetch doctor details and average rating
$doc_id = $_SESSION['doc_id'];
$query = "SELECT d.*, 
                 COALESCE(AVG(r.rating), 0) AS avg_rating, 
                 COUNT(r.rating) AS num_ratings 
          FROM his_docs d 
          LEFT JOIN ratings r ON d.doc_id = r.doc_id 
          WHERE d.doc_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $doc_id);
$stmt->execute();
$res = $stmt->get_result();
$doctor = $res->fetch_object();

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
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo $doctor->doc_fname; ?> <?php echo $doctor->doc_lname; ?>'s Profile</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img src="../doc/assets/images/users/<?php echo $doctor->doc_dpic; ?>" class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">
                            <div class="text-centre mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Employee Full Name :</strong> <span class="ml-2"><?php echo $doctor->doc_fname; ?> <?php echo $doctor->doc_lname; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Employee Department :</strong> <span class="ml-2"><?php echo $doctor->doc_dept; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Employee Number :</strong> <span class="ml-2"><?php echo $doctor->doc_number; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Employee Email :</strong> <span class="ml-2"><?php echo $doctor->doc_email; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Average Rating:</strong> <span class="ml-2"><?php echo number_format($doctor->avg_rating, 1); ?> / 5 (<?php echo $doctor->num_ratings; ?> ratings)</span></p>
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
                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Change Password
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
                                                    <input type="text" name="doc_fname" class="form-control" id="firstname" placeholder="<?php echo $doctor->doc_fname; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" name="doc_lname" class="form-control" id="lastname" placeholder="<?php echo $doctor->doc_lname; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Email Address</label>
                                                    <input type="email" name="doc_email" class="form-control" id="useremail" placeholder="<?php echo $doctor->doc_email; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Profile Picture</label>
                                                    <input type="file" name="doc_dpic" class="form-control btn btn-success" id="useremail">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="settings">
                                    <form method="post">
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname">Old Password</label>
                                                    <input type="password" class="form-control" id="firstname" placeholder="Enter Old Password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">New Password</label>
                                                    <input type="password" class="form-control" name="doc_pwd" id="lastname" placeholder="Enter New Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="useremail">Confirm Password</label>
                                            <input type="password" class="form-control" id="useremail" placeholder="Confirm New Password">
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="update_pwd" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include("assets/inc/footer.php"); ?>
    </div>
</div>

<div class="rightbar-overlay"></div>

<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
</body>
</html>
