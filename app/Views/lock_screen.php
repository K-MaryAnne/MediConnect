<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('public/css/lockscreen.css') ?>">
    <title>Lock Screen</title>
    
</head>
<body>
    <div id="lock-screen-popup" class="lock-screen-popup">
        <div class="lock-screen-popup-content">
            <h3>Medical App - Unlock</h3>
            <form action="/lock-screen/unlock" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Unlock</button>
            </form>
        </div>
    </div>
    <script>
       
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('lock-screen-popup').style.display = 'block';
        });

     
        let inactivityTime = function () {
            let time;
            window.onload = resetTimer;
            window.onmousemove = resetTimer;
            window.onmousedown = resetTimer;
            window.ontouchstart = resetTimer;
            window.onclick = resetTimer;
            window.onkeypress = resetTimer;
            window.addEventListener('scroll', resetTimer, true);

            function lockScreen() {
                document.getElementById('lock-screen-popup').style.display = 'block';
            }

            function resetTimer() {
                clearTimeout(time);
                time = setTimeout(lockScreen, 300000); 
            }
        };

        inactivityTime();
    </script>
</body>
</html>
