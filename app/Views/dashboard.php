<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediconnect Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            width: 100%;
            padding: 10px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="card text-center">
        <h1 class="text-primary">Welcome to Mediconnect</h1>
        <p>Your reliable homecare management system</p>
        <a href="<?= base_url('/lock') ?>" class="btn btn-primary">Lock</a>
        <a href="<?= base_url('/logout') ?>" class="btn btn-secondary mt-3">Logout</a>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
