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
    background-color: #e9ecef;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    padding-top: 70px;
    color: #333;
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
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
}

header h1 {
    font-size: 24px;
}

/* Navigation */
nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

nav ul li {
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

nav ul li a:hover {
    background-color: #14699d;
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
}

.form-container button:hover {
    background-color: #218838;
}

/* Table Container */
.table-container {
    margin: 40px 0;
    width: 90%;
    max-width: 800px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.table-container h2 {
    color: #2ca4ed;
    text-align: center;
    margin-bottom: 20px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: center;
}

table th {
    background-color: #2ca4ed;
    color: #ffffff;
}

table tr:nth-child(even) {
    background-color: #f8f9fa;
}

/* Button Styles */
.edit-btn,
.delete-btn,
.add-btn,
.section-btn {
    padding: 8px 12px;
    font-size: 14px;
    color: #ffffff;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.edit-btn {
    background-color: #ffc107;
}

.edit-btn:hover {
    background-color: #e0a800;
}

.delete-btn {
    background-color: #dc3545;
}

.delete-btn:hover {
    background-color: #c82333;
}

.add-btn {
    background-color: #28a745;
    float: right;
}

.add-btn:hover {
    background-color: #218838;
}

.section-btn {
    background-color: #2ca4ed;
}

.section-btn:hover {
    background-color: #1c80b8;
}
    </style>
</head>
<body>
    <header>
        <h1>HealthTrackAI</h1>
        <nav>
            <ul>
                <li><a href="admin.php"><i class="fas fa-key"></i>Account User List</a></li>
                <li><a href="admin_doctor.php" class="section-btn">Doctor List</a></li>
                <li><a href="schedule_appointment.php" class="section-btn">Schedule Appointment List</a></li>
                <li><a href="add_doctor.php" class="section-btn">Add Doctor</a></li>
                <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
                <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="table-container">
        <h2>Scheduled Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($appointments_result->num_rows > 0) {
                    while ($appointment = $appointments_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$appointment['user_name']}</td>";
                        echo "<td>{$appointment['doctor_name']}</td>";
                        echo "<td>{$appointment['date']}</td>";
                        echo "<td>
                                <a href='edit_appointment.php?id={$appointment['id']}' class='edit-btn'>Edit</a>
                                <a href='delete_appointment.php?id={$appointment['id']}' class='delete-btn'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No appointments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
