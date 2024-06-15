<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
    body {
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    padding: 20px;
}

.text-primary {
    color: #4466D1 !important;
}

.btn-primary {
    background-color: #4466D1;
    border: none;
    width: 100%;
    padding: 10px;
}

.btn-primary:hover {
    background-color: #3652a1;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Ensure padding doesn't affect total width */
}
   </style>
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
            <h2 class="text-primary">Reset Password</h2>
            <?php if (session()->get('error')): ?>
                <div class="alert alert-danger"><?= session()->get('error') ?></div>
            <?php endif; ?>
            <form action="<?= base_url('sign-up/update-password') ?>" method="post">
                <input type="hidden" name="token" value="<?= $token ?>">
                <input type="hidden" name="email" value="<?= $email ?>">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div id="passwordGuidelines">
                        <p class="guideline" id="minLength">Password must have at least 8 characters</p>
                        <p class="guideline" id="upperCase">Password must have at least one uppercase letter</p>
                        <p class="guideline" id="lowerCase">Password must have at least one lowercase letter</p>
                        <p class="guideline" id="number">Password must have at least one number</p>
                        <p class="guideline" id="specialChar">Password must have at least one special character (e.g., @, #, etc.)</p>
                    </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
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
            </script>
</body>
</html>
