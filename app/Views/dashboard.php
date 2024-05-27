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
            flex-direction: column;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            padding: 20px;
            margin-top: 20px;
        }
        .text-primary {
            color: #4466D1 !important;
        }
        .btn-primary {
            background-color: #4466D1;
            border: none;
        }
        .btn-primary:hover {
            background-color: #3652a1;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .navbar {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">MediConnect</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="<?= base_url('/lock-screen') ?>">Lock</a>
                </li>
                <li class="nav-item ml-2">
                    <a class="nav-link btn btn-secondary text-white" href="<?= base_url('/logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="card text-center" style="margin-top: 100px;">
        <h1 class="text-primary">Welcome to MediConnect</h1>
        <p>Your reliable homecare management system</p>
        <div class="mt-4">
            <h2>About MediConnect</h2>
            <p>Imagine getting the specialized care you need, right at home.</p>
            <p>Our app connects you with qualified nurses and doctors, all conveniently located nearby. Find the perfect fit based on reviews, ratings, and transparent pricing, and enjoy a seamless experience that puts your well-being first.</p>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
