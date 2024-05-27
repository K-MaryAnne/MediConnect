<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Your MediConnect Account</title>
    <link rel="stylesheet" href="<?= base_url('public/css/email.css') ?>">
</head>
<body>
    <div class="email-container">
        <div class="header">
        <img src="<?= base_url('public/images/Logo.png') ?>" alt="Logo">

        </div>
        <div class="content">
            <h1>Welcome to MediConnect!</h1>
            <p>You’re just one click away from getting started with MediConnect. All you need to do is verify your email address to activate your MediConnect account.</p>
            <div class="button">
                <a href="<?= $activationLink ?>">Activate my Account</a>
            </div>
            <p>Once your account is activated, you can start using all of MediConnect’s features to organize, test, monitor, and share your medical data and requests.</p>
            <p>You’re receiving this email because you recently created a new MediConnect account or added a new email address. If this wasn’t you, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>This email was sent to <?= $email ?>, which is associated with a MediConnect account.</p>
            <p>© 2024 MediConnect Inc., All Rights Reserved</p>
            <p>MediConnect Inc., Nairobi, Kenya</p>
        </div>
    </div>
</body>
</html>
