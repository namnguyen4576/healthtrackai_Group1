<?php
// Start the session
session_start();

// Connect to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users and doctors for dropdowns
$users_result = $conn->query("SELECT name FROM users");
$doctors_result = $conn->query("SELECT name FROM doctor");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_date = $_POST['appointment_date'];

    // Insert the new appointment into the database
    $sql = "INSERT INTO appointments (user_name, doctor_name, date) VALUES ('$user_name', '$doctor_name', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to appointment list after successful insertion
        header('Location: appointment_list.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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

        /* Form Container */
        .form-container {
            background-color: #ffffff;
            padding: 25px;
            margin-top: 80px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            /* Stack items vertically */
            align-items: stretch;
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
        .form-container select,
        .form-container button {
            padding: 12px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s;
            width: 100%;
            /* Make inputs and buttons full width */
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #2ca4ed;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        /* Form Container */
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            margin: 40px auto;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        .form-container h2 {
            text-align: center;
            color: #007bff;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .form-container label {
            margin: 10px 0 5px;
            font-size: 14px;
            color: #457b9d;
            font-weight: 600;
            text-transform: uppercase;
        }

        .form-container input,
        .form-container select {
            padding: 15px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: #f8f9fa;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #2ca4ed;
            box-shadow: 0 0 4px rgba(44, 164, 237, 0.5);
            outline: none;
        }

        .form-container button {
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #28a745, #218838);
            color: #fff;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .form-container button:hover {
            background: linear-gradient(135deg, #218838, #28a745);
            transform: scale(1.02);
        }

        .form-container button:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    <header>
        <h1>HealthTrackAI - Add Schedule Appointment</h1>
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
        <h2>Schedule an Appointment</h2>
        <form method="POST" action="schedule_appointment.php">
            <label for="user_name">Select Customer</label>
            <select id="user_name" name="user_name" required>
                <?php
                if ($users_result->num_rows > 0) {
                    while ($user = $users_result->fetch_assoc()) {
                        echo "<option value='{$user['name']}'>{$user['name']}</option>";
                    }
                } else {
                    echo "<option value=''>No customers found</option>";
                }
                ?>
            </select>

            <label for="doctor_name">Select Doctor</label>
            <select id="doctor_name" name="doctor_name" required>
                <?php
                if ($doctors_result->num_rows > 0) {
                    while ($doctor = $doctors_result->fetch_assoc()) {
                        echo "<option value='{$doctor['name']}'>{$doctor['name']}</option>";
                    }
                } else {
                    echo "<option value=''>No doctors found</option>";
                }
                ?>
            </select>

            <label for="appointment_date">Appointment Date</label>
            <input type="datetime-local" id="appointment_date" name="appointment_date" required>

            <button type="submit">Schedule Appointment</button>
        </form>
    </div>
</body>

</html>