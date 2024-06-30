<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
 
        .error-message {
            color: red;
        }
        .guideline {
            color: red;
            font-size: 12px;
            margin: 2px 0;
        }
        .guideline.valid {
            color: green;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-body">
            <h2 class="text-primary">Sign Up</h2>
            <?php if (session()->get('success')): ?>
                <div class="alert alert-success"><?= session()->get('success') ?></div>
            <?php endif; ?>
            <?php if (session()->get('error')): ?>
                <div class="alert alert-danger"><?= session()->get('error') ?></div>
            <?php endif; ?>
            <form id="signupForm" action="<?= base_url('sign-up/register') ?>" method="post">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="First_Name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="Last_Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="Password" required>
                    <div id="passwordGuidelines">
                        <p class="guideline" id="minLength">Password must have at least 8 characters</p>
                        <p class="guideline" id="upperCase">Password must have at least one uppercase letter</p>
                        <p class="guideline" id="lowerCase">Password must have at least one lowercase letter</p>
                        <p class="guideline" id="number">Password must have at least one number</p>
                        <p class="guideline" id="specialChar">Password must have at least one special character (e.g., @, #, etc.)</p>
                    </div>

                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" class="form-control" id="phone_number" name="Phone_Number" required>
                    <small id="phoneHelp" class="form-text"></small>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="Gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
               
                <button type="submit" class="btn btn-primary" id="submitButton" disabled>Sign Up</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.querySelector("#phone_number");
            var iti = window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "us";
                        callback(countryCode);
                    });
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

            function updateMask() {
                var countryData = iti.getSelectedCountryData();
                var maskPattern = "+" + countryData.dialCode + " 999 999 9999"; 
                $(input).inputmask("remove");
                $(input).inputmask({
                    mask: maskPattern,
                    placeholder: maskPattern.replace(/9/g, "_")
                });
            }

            updateMask();
            
            input.addEventListener('countrychange', function() {
                updateMask();
            });

            function validatePhoneNumber() {
                var phoneNumber = input.value.replace(/\D/g, ''); // Remove all non-digit characters
                var isValid = iti.isValidNumber();
                var minLength = iti.getNumberType() === intlTelInputUtils.numberType.FIXED_LINE ? 10 : 8;
                var maxLength = iti.getNumberType() === intlTelInputUtils.numberType.MOBILE ? 15 : 10;
                var errorMsg = "";

                if (phoneNumber.length > 0 && phoneNumber.length < minLength) {
                    errorMsg = "The phone number is too short.";
                } else if (phoneNumber.length > maxLength) {
                    errorMsg = "The phone number is too long.";
                } else if (phoneNumber.length > 0 && !isValid) {
                    errorMsg = "The phone number is invalid.";
                }

                var phoneHelp = document.getElementById('phoneHelp');
                phoneHelp.textContent = errorMsg;
                phoneHelp.className = errorMsg ? 'error-message' : '';

                return isValid && phoneNumber.length >= minLength && phoneNumber.length <= maxLength;
            }

            input.addEventListener('blur', validatePhoneNumber);
            input.addEventListener('input', validatePhoneNumber);

            var form = document.getElementById('signupForm');
            form.addEventListener('submit', function(event) {
                if (!validatePhoneNumber()) {
                    event.preventDefault();
                    alert("Please enter a valid phone number.");
                }
            });

            $('#password').on('input', function() {
                var password = $(this).val();
                var minLength = password.length >= 8;
                var upperCase = /[A-Z]/.test(password);
                var lowerCase = /[a-z]/.test(password);
                var specialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
                var number = /[0-9]/.test(password);

                $('#minLength').toggleClass('valid', minLength);
                $('#upperCase').toggleClass('valid', upperCase);
                $('#lowerCase').toggleClass('valid', lowerCase);
                $('#specialChar').toggleClass('valid', specialChar);
                $('#number').toggleClass('valid', number);

                var allValid = minLength && upperCase && lowerCase && specialChar && number;
                $('#submitButton').prop('disabled', !allValid);
            });
        });
    </script>
</body>
</html>
