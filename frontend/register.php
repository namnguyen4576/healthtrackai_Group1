<?php
require 'configs/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Use prepared statements to insert user information into the database
    $sql = "INSERT INTO users (name, email, contact, gender, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $contact, $gender, $hashedPassword);

    if ($stmt->execute()) {
        // If registration is successful, display a success message
        echo "<script>
                alert('Registration successful! Please log in.');
                window.location.href = 'index.php'; // Redirect to the index page
              </script>";
    } else {
        // If there is an error during registration
        echo "<script>
                alert('An error occurred during registration. Please check your information.');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HealthTrackAI</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>HealthTrackAI</h1>
        <nav>
            <ul>
                <li><a href="index.php" onclick="redirectToHome()"><i class="fas fa-home"></i> HOME</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="registration" id="registration">
            <h2>Create Your Account</h2>
            <form action="" method="POST">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" required>
                </div>

                <div>
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Register</button>
            </form>
        </section>
    </main>
</body>
</html>
