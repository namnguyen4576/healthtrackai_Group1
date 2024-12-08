<?php
// Start session and connect to database
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get customer ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch customer data
$user = [];
if ($id > 0) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("Customer not found.");
    }
    $stmt->close();
}

// Update customer data when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Prepare SQL for update
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name=?, email=?, contact=?, gender=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $contact, $gender, $hashed_password, $id);
    } else {
        $sql = "UPDATE users SET name=?, email=?, contact=?, gender=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $contact, $gender, $id);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Customer updated successfully!'); window.location.href = 'admin.php';</script>";
    } else {
        echo "Error updating customer: " . $conn->error;
    }
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTrackAI - Edit Customer</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #333;
            padding: 20px;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 6px;
            background: #0056b3;
            transition: background 0.3s ease;
        }

        nav ul li a:hover {
            background: #004085;
        }

        .form-container {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            /* Gradient background */
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15), 0 2px 6px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            max-width: 600px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2), 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .form-container h2 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 25px;
            color: #007bff;
            font-weight: 600;
            letter-spacing: 1px;
        }

        form label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        form input,
        form select {
            width: 100%;
            padding: 12px 15px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            color: #555;
            background-color: #fafafa;
            transition: border-color 0.3s, background-color 0.3s;
        }

        form input:focus,
        form select:focus {
            border-color: #007bff;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        }

        form button {
            margin-top: 25px;
            padding: 12px 18px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(145deg, #007bff, #0056b3);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
        }

        form button:hover {
            background: linear-gradient(145deg, #0056b3, #004085);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        form a {
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
            font-weight: 500;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        form a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <h1>HealthTrackAI - Customer Management</h1>
        <nav>
            <ul>
                <li><a href="admin.php">User List</a></li>
                <li><a href="admin_doctor.php">Doctor List</a></li>
                <li><a href="schedule_appointment.php">Appointments</a></li>
                <li><a href="add_doctor.php">Add Doctor</a></li>
                <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h2>Edit Customer</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php echo ($user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>

            <label for="password">Password (leave blank to keep current password):</label>
            <input type="password" id="password" name="password">

            <button type="submit">Update Customer</button>
            <a href="admin.php">Back</a>
        </form>
    </div>
</body>

</html>