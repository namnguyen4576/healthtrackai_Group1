<?php
// Start the session
session_start();

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve doctor data for the edit form
if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // SQL to retrieve the doctor's data
    $sql = "SELECT id, name, specialty, qualification, gender, age, nickname, image FROM doctor WHERE id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the doctor data
        $row = $result->fetch_assoc();
    } else {
        echo "Doctor not found.";
        exit;
    }
}

// Handle doctor form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $qualification = $_POST['qualification'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $nickname = $_POST['nickname'];
    $image = $_POST['image'];

    // SQL to update the doctor data
    $sql = "UPDATE doctor SET name = '$name', specialty = '$specialty', qualification = '$qualification', 
            gender = '$gender', age = '$age', nickname = '$nickname', image = '$image' WHERE id = $doctor_id";

    if ($conn->query($sql) === TRUE) {
        echo "Doctor updated successfully!";
        header("Location: admin_doctor.php"); // Redirect back to the doctor list after update
        exit;
    } else {
        echo "Error updating doctor: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       /* Reset */
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body Style */
        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding-top: 70px; /* Ensure enough space to avoid content being covered */
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 15px;
            background-color: #2ca4ed;
            color: #ffffff;
            text-align: center;
            z-index: 1000;
        }

        header h1 {
            margin: 6px;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 10px;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            background-color: #1c80b8;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        /* Form Container */
        .form-container {
            background-color: #ffffff;
            padding: 25px;
            margin-top: 80px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .form-container h2 {
            text-align: center;
            color: #2ca4ed;
            margin-bottom: 20px;
        }

        .form-container label {
            margin: 10px 0 5px;
            font-size: 16px;
            color: #555;
            font-weight: 500;
        }

        .form-container input,
        .form-container select {
            padding: 12px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #2ca4ed;
        }

        .form-container button {
            padding: 12px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        /* Navigation Links */
        nav ul li a.section-btn {
            background-color: #2ca4ed;
        }

        nav ul li a.section-btn:hover {
            background-color: #1c80b8;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<header>
        <h1>HealthTrackAI</h1>
        <nav>
            <ul>
                <li><a href="admin.php"><i class="fas fa-key"></i>Acount User List</a></li>
                <li><a href="admin_doctor.php" class="section-btn">Doctor list</a></li>
                <li><a href="schedule_appointment.php" class="section-btn">Schedule Appointment list</a></li>
                <li><a href="add_doctor.php" class="section-btn">Add Doctor</a></li>
                <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
                <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

<!-- Edit Doctor Form -->
<div class="form-container">
    <h2>Edit Doctor</h2>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

        <label for="specialty">Specialty:</label>
        <input type="text" id="specialty" name="specialty" value="<?php echo $row['specialty']; ?>" required>

        <label for="qualification">Qualification:</label>
        <input type="text" id="qualification" name="qualification" value="<?php echo $row['qualification']; ?>" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>" required>

        <label for="nickname">Nickname:</label>
        <input type="text" id="nickname" name="nickname" value="<?php echo $row['nickname']; ?>">

        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" value="<?php echo $row['image']; ?>">

        <button type="submit">Save Changes</button>
    </form>
</div>
</body>
</html>
