<!-- Views/emails/appointment_confirmation_doctor.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        p {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Confirmation</h2>
        <p>Hello Dr. <?= $doctor_name ?>,</p>
        <p>This email is to confirm that you have an upcoming appointment with:</p>
        <ul>
            <li><strong>Patient:</strong> <?= $user['first_name'] ?></li>
            <li><strong>Date:</strong> <?= date('F j, Y', strtotime($date)) ?></li>
            <li><strong>Time:</strong> <?= date('h:i A', strtotime($time)) ?></li>
            <li><strong>Location:</strong> <?= $location ?></li>
        </ul>
        <p>Please review the patient's details and ensure all necessary preparations are made.</p>
        <p>If there are any changes or concerns, please contact the patient directly or our office.</p>
        <p>Thank you for your attention to this matter.</p>
        <p>Best regards,<br>MediConnect</p>
    </div>
</body>
</html>
