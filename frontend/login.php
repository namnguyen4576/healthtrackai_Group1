<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTrackAI - Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <script>
        function redirectToHome() {
            window.location.href = "index.php"; // Change to your index file path if necessary
        }
    </script>
</head>

<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <header>
        <h1>HealthTrackAI</h1>
        <nav>
            <ul>
                <li><a href="#chat" onclick="redirectToHome()"><i class="fas fa-home"></i> HOME</a></li>
            </ul>
        </nav>
    </header>

    <div class="login-container">
        <h2>User Login</h2>
        <form action="#">
            <label for="user-email">Email:</label>
            <input type="email" id="user-email" name="user-email" required>

            <label for="user-password">Password:</label>
            <input type="password" id="user-password" name="user-password" required>

            <button type="submit">Login</button>
        </form>

        <p>Not registered? <a href="register.php">Create an account</a></p>
    </div>

</body>

</html>
