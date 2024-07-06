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
        <p>Hello <?= $user['first_name'] ?>,</p>
        <p>We are pleased to inform you that your appointment has been confirmed for:</p>
        <ul>
            <li><strong>Date:</strong> <?= date('F j, Y', strtotime($date)) ?></li>
            <li><strong>Time:</strong> <?= date('h:i A', strtotime($time)) ?></li>
            <li><strong>Doctor:</strong> Dr. <?= $doctor_name ?></li>
        </ul>
        <p>Please have any necessary documents or information related to your appointment.</p>
        <p>If you have any questions or need to make changes, please contact us as soon as possible.</p>
        <p>Thank you for choosing our services.</p>
        <p>Best regards,<br>MediConnect</p>
    </div>
</body>
</html>
