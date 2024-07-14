<?php
    session_start();
    include('assets/inc/config.php'); // Include configuration file

    if(isset($_POST['pat_login'])) {
        $pat_number = $_POST['pat_number'];
        $pat_pwd = $_POST['pat_pwd']; // Double encrypt to increase security

        $stmt = $mysqli->prepare("SELECT pat_id, pat_number FROM his_patients WHERE pat_number=? AND pat_pwd=?");
        $stmt->bind_param('ss', $pat_number, $pat_pwd);
        $stmt->execute();
        $stmt->bind_result($pat_id, $pat_number);
        $rs = $stmt->fetch();

        if($rs) {
            $_SESSION['pat_id'] = $pat_id;
            $_SESSION['pat_number'] = $pat_number;
            header("location: pat_dashboard.php");
            exit;
        } else {
            $err = "Access Denied. Please check your credentials.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>MediConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="MartDevelopers" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- Load Sweet Alert Javascript -->
    <script src="assets/js/swal.js"></script>
    <!-- Inject SWAL -->
    <?php if(isset($success)) {?>
    <!-- Code for injecting an alert -->
    <script>
        setTimeout(function () { 
            swal("Success","<?php echo $success;?>","success");
        }, 100);
    </script>
    <?php } ?>
    <?php if(isset($err)) {?>
    <!-- Code for injecting an alert -->
    <script>
        setTimeout(function () { 
            swal("Failed","<?php echo $err;?>","error");
        }, 100);
    </script>
    <?php } ?>
</head>
<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <a href="index.php">
                                    <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Enter your email address or number and password.</p>
                            </div>
                            <form method='post'>
                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email address or Number</label>
                                    <input class="form-control" name="pat_number" type="text" id="emailaddress" required="" placeholder="Enter your patient number">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" name="pat_pwd" type="password" required="" id="password" placeholder="Enter your password">
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" name="pat_login" type="submit"> Log In </button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="pat_reset_pwd.php" class="text-white-50 ml-1">Forgot your password?</a></p>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div> <!-- end page -->
    <?php include ("assets/inc/footer1.php");?>
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
</body>
</html>
