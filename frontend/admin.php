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

// Retrieve customer data
$sql = "SELECT id, name, email, contact, gender FROM users";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTrackAI - Customer Information</title>
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

        /* Table Container */
        .table-container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Table Title */
        .table-container h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #11c0f1;
            color: #ffffff;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
            color: #333;
        }

        .delete-btn {
            color: #ffffff;
            background-color: #e74c3c;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 5px; /* Space between buttons */
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .edit-btn {
            color: #ffffff;
            background-color: #f39c12;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .edit-btn:hover {
            background-color: #e67e22;
        }

        .add-btn {
            color: #ffffff;
            background-color: #28a745; /* Green background */
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-left: 10px; /* Space between title and button */
            float: right; /* Align button to the right */
        }

        .add-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .section-btn {
            margin: 10px 0;
            color: #ffffff;
            background-color: #2ca4ed;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .section-btn:hover {
            background-color: #1c80b8;
        }

        .message {
            padding: 10px;
            background-color: #ffcc00;
            color: #333;
            border-radius: 5px;
            margin-bottom: 20px;
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

<div class="table-container">
    <h2>Customer List</h2>
    <a href="add.php" class="add-btn">Add Customer</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Hotline</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Reconnect to the database and fetch results again for displaying customer data
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['contact']}</td>
                            <td>{$row['gender']}</td>
                            <td>
                                <a href='edit.php?id={$row['id']}' class='edit-btn'>Edit</a>
                                <a href='delete.php?id={$row['id']}' class='delete-btn'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No customers found.</td></tr>";
            }
            // Close the connection again after use
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
