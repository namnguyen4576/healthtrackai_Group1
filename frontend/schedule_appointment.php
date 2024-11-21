<?php
session_start();

// Kết nối với cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_date = $_POST['appointment_date'];

    // Thêm lịch hẹn vào cơ sở dữ liệu
    $sql = "INSERT INTO appointments (user_name, doctor_name, date) 
            VALUES ('$user_name', '$doctor_name', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng về trang danh sách lịch hẹn sau khi thêm thành công
        header('Location: schedule_appointment.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Lấy danh sách các lịch hẹn từ cơ sở dữ liệu
$appointments_result = $conn->query("SELECT id, user_name, doctor_name, date FROM appointments");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment List</title>
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

        .btn {
            padding: 10px 15px;
            font-size: 14px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            transition: background 0.3s ease;
            display: inline-block;
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
    </style>
</head>
<body>
    <header>
        <h1>HealthTrackAI - Schedule Appointment</h1>
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
        <h2>Scheduled Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($appointments_result->num_rows > 0) {
                    while ($appointment = $appointments_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$appointment['id']}</td>";
                        echo "<td>{$appointment['user_name']}</td>";
                        echo "<td>{$appointment['doctor_name']}</td>";
                        echo "<td>{$appointment['date']}</td>";
                        echo "<td>
                                <a href='edit_appointment.php?id={$appointment['id']}' class='btn edit-btn'>Edit</a>
                                <a href='delete_appointment.php?id={$appointment['id']}' class='btn delete-btn'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No appointments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>