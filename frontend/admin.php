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

        .table-container {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            width: 90%;
        }

        .table-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        table th {
            background-color: #007bff;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .delete-btn, .edit-btn {
            padding: 10px 15px;
            font-size: 14px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .edit-btn {
            background: #ffc107;
        }

        .edit-btn:hover {
            background: #e0a800;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .add-btn {
            padding: 10px 15px;
            font-size: 14px;
            background: #28a745;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            float: right;
        }

        .add-btn:hover {
            background: #218838;
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

    <div class="table-container">
        <h2>Customer List</h2>
        <a href="add_customer.php" class="add-btn">Add Customer</a>
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
                                        <a href='edit_customer.php?id={$row['id']}' class='edit-btn'>Edit</a>
                                        <a href='delete_customer.php?id={$row['id']}' class='delete-btn'>Delete</a>
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
