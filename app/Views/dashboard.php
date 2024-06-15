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
        #lockScreenOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998; 
            display: none; 
            justify-content: center;
            align-items: center;
        }
        #lockScreenPopup, #loginForm {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            z-index: 9999; 
        }
        body.locked #lockScreenOverlay {
            display: flex;
        }
        body.locked .blurred {
            filter: blur(5px);
            pointer-events: none;
            user-select: none;
        }
        #loginForm form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

#loginForm .form-group {
    width: 100%;
    margin-bottom: 15px;
}

#loginForm label {
    margin-bottom: 5px;
}

#loginForm input[type="email"],
#loginForm input[type="password"] {
    width: 100%;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

#loginForm button[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #4466D1;
    color: #fff;
}

#loginForm button[type="submit"]:hover {
    background-color: #3652a1;
}

    </style>


</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light blurred">
        <a class="navbar-brand" href="#">MediConnect</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="lockScreenButton" class="nav-link btn btn-primary text-white" href="javascript:void(0);">Lock</a>
                </li>
                <li class="nav-item ml-2">
                    <a class="nav-link btn btn-secondary text-white" href="<?= base_url('/logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="card text-center blurred" style="margin-top: 100px;">
        <h1 class="text-primary">Welcome to MediConnect</h1>
        <p>Your reliable homecare management system</p>
        <div class="mt-4">
            <h2>About MediConnect</h2>
            <p>Imagine getting the specialized care you need, right at home.</p>
            <p>Our app connects you with qualified nurses and doctors, all conveniently located nearby. Find the perfect fit based on reviews, ratings, and transparent pricing, and enjoy a seamless experience that puts your well-being first.</p>
        </div>
    </div>

    <div id="lockScreenOverlay">
        <div id="lockScreenPopup">
            <p>Are you sure you want to lock the screen?</p>
            <button id="confirmLockButton">Yes</button>
            <button id="cancelLockButton">No</button>
        </div>
        <div id="loginForm" style="display: none;">
    <p>Screen Locked. Please Log in to continue.</p>
    <form id="unlockForm" action="unlock.php" method="post">
        <div class="form-group">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Unlock Screen</button>
    </form>
</div>

    </div>

    <script>
        document.getElementById('lockScreenButton').addEventListener('click', function() {
            document.body.classList.add('locked');
            document.getElementById('lockScreenPopup').style.display = 'block';
            document.getElementById('loginForm').style.display = 'none';
        });

        document.getElementById('confirmLockButton').addEventListener('click', function() {
            document.body.classList.add('locked');
            document.getElementById('lockScreenPopup').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        });

        document.getElementById('cancelLockButton').addEventListener('click', function() {
            document.body.classList.remove('locked');
            document.getElementById('lockScreenPopup').style.display = 'none';
        });

        document.getElementById('unlockForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch('unlock.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.body.classList.remove('locked');
                    document.getElementById('lockScreenOverlay').style.display = 'none';
                } else {
                    alert('Login failed. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>