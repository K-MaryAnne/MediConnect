<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('assets/inc/head.php'); ?>
    <title>Apply to be a Doctor</title>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Applications</a></li>
                                        <li class="breadcrumb-item active">Apply to be a Doctor</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Apply to be a Doctor</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill all fields</h4>

                                    <div class="container">
                                        <h2>Apply to be a Doctor</h2>

                                        <?php
                                        // Validate and process form submission
                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            // Directory where uploaded files will be saved
                                            $uploadDir = "uploads/";

                                            // Create directory if it does not exist
                                            if (!file_exists($uploadDir)) {
                                                mkdir($uploadDir, 0777, true);
                                            }

                                            // File names
                                            $licenseFile = $uploadDir . basename($_FILES["license"]["name"]);
                                            $idFile = $uploadDir . basename($_FILES["id"]["name"]);

                                            // Check if files are PDFs
                                            $pdfFileTypeLicense = strtolower(pathinfo($licenseFile, PATHINFO_EXTENSION));
                                            $pdfFileTypeID = strtolower(pathinfo($idFile, PATHINFO_EXTENSION));

                                            if ($pdfFileTypeLicense != "pdf" || $pdfFileTypeID != "pdf") {
                                                echo '<div class="alert alert-danger" role="alert">Error: Both files must be in PDF format.</div>';
                                            } else {
                                                // Upload files
                                                if (move_uploaded_file($_FILES["license"]["tmp_name"], $licenseFile) &&
                                                    move_uploaded_file($_FILES["id"]["tmp_name"], $idFile)) {
                                                    echo '<div class="alert alert-success" role="alert">Application successfully submitted!</div>';
                                                    // You can process further actions here (e.g., save application details to database).
                                                } else {
                                                    echo '<div class="alert alert-danger" role="alert">Error uploading files.</div>';
                                                }
                                            }
                                        }
                                        ?>

                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="license">License (PDF):</label>
                                                <input type="file" class="form-control-file" id="license" name="license" accept=".pdf" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="id">ID Front and Back (combined PDF):</label>
                                                <input type="file" class="form-control-file" id="id" name="id" accept=".pdf" required>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Submit Application</button>
                                        </form>
                                    </div>
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

    <!-- Bootstrap and necessary JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
