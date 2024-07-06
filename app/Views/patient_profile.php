<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link href="<?= base_url('public/css/userprofile.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <!-- Placeholder image, replace with actual user photo -->
                    <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <span class="font-weight-bold">Edogaru</span>
                    <span class="text-black-50">edogaru@mail.com.my</span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <!-- Edit Profile Form -->
                    <form id="edit-profile-form" action="<?= base_url('profile/update') ?>" method="post">
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
                                <input type="date" class="form-control" name="date" id="date" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Profile Photo Section -->
        <div class="container mt-5">
            <h5>Update Profile Photo</h5>
            <form id="photo-upload-form" enctype="multipart/form-data">
                <input type="file" name="profile_photo" id="profile_photo">
                <button type="submit" class="btn btn-primary mt-2">Upload Photo</button>
            </form>
            <div id="message"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // AJAX for profile photo upload
            $('#photo-upload-form').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);

                $.ajax({
                    url: '<?= base_url('/patient-profile/uploadPhoto') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#message').text(response.message).removeClass('text-danger').addClass('text-success');
                        } else {
                            $('#message').text(response.message).removeClass('text-success').addClass('text-danger');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#message').text('An error occurred: ' + error).removeClass('text-success').addClass('text-danger');
                    }
                });
            });

            // Optional: AJAX for profile information update (included for completeness)
            $('#edit-profile-form').on('submit', function(e) {
                e.preventDefault();
                
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle response as needed
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
