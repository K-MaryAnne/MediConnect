<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link href="<?= base_url('public/css/userprofile.css') ?>" rel="stylesheet">
</head>
<body>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold">Edogaru</span>
                <span class="text-black-50">edogaru@mail.com.my</span>
                <span> </span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form action="<?= base_url('profile/upload_image') ?>" method="post" enctype="multipart/form-data">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="First Name" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Surname</label>
                            <input type="text" class="form-control" name="last_name" value="" placeholder="Surname">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number" placeholder="Enter Phone Number" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Enter Address" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Town</label>
                            <input type="text" class="form-control" name="town" placeholder="Enter Town" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter Email" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Date of Birth</label>
                            <div class="d-flex">
                                <select class="form-control mr-1" id="day" name="day" style="width: auto;">
                                    <option value="">Day</option>
                                    <!-- Generate days 1-31 -->
                                    <script>
                                        for (let d = 1; d <= 31; d++) {
                                            document.write('<option value="' + d + '">' + d + '</option>');
                                        }
                                    </script>
                                </select>
                                <select class="form-control mr-1" id="month" name="month" style="width: auto;">
                                    <option value="">Month</option>
                                    <!-- Generate months 1-12 -->
                                    <script>
                                        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                        for (let m = 0; m < 12; m++) {
                                            document.write('<option value="' + (m+1) + '">' + monthNames[m] + '</option>');
                                        }
                                    </script>
                                </select>
                                <select class="form-control" id="year" name="year" style="width: auto;">
                                    <option value="">Year</option>
                                    <!-- Generate years from 1900 to current year -->
                                    <script>
                                        const currentYear = new Date().getFullYear();
                                        for (let y = currentYear; y >= 1900; y--) {
                                            document.write('<option value="' + y + '">' + y + '</option>');
                                        }
                                    </script>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">

    
                    </div>
                    <div class="mt-3">
                        <label class="labels">Profile Image</label>
                        <input type="file" class="form-control" name="profile_image">
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                    </div>
                </form>
                <div class="mt-5 text-center">
                   <button id="signupHealthcareProvider" class="btn btn-primary">Sign Up as Healthcare Provider</button>
                 </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="col-md-12">
                    <label class="labels">Additional Details</label>
                    <textarea class="form-control" placeholder="Additional details"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        document.getElementById('healthcareprovier_profile').onclick = function() {
            if (confirm('Are you sure you want to sign up as a healthcare provider?')) {
                window.location.href = '<?= 'http://localhost:8080/'('healthcareprovier_profile') ?>';
            }
        }
    </script>
</body>
</html>
