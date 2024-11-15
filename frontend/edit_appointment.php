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

// Kiểm tra nếu có ID của lịch hẹn
if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    
    // Lấy chi tiết lịch hẹn từ cơ sở dữ liệu
    $sql = "SELECT * FROM appointments WHERE id = $appointment_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $appointment = $result->fetch_assoc();
    } else {
        echo "Appointment not found.";
        exit();
    }
} else {
    echo "No appointment ID provided.";
    exit();
}

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_date = $_POST['appointment_date'];
    
    // Cập nhật lịch hẹn trong cơ sở dữ liệu
    $update_sql = "UPDATE appointments SET user_name='$user_name', doctor_name='$doctor_name', date='$appointment_date' WHERE id=$appointment_id";
    
    if ($conn->query($update_sql) === TRUE) {
        header('Location: schedule_appointment.php');
        exit();
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
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

        /* Table Layout for Form */
        .form-table {
            width: 100%;
        }

        .form-table td {
            padding: 10px;
            vertical-align: middle;
        }

        .form-table input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        .form-table input:focus {
            border-color: #2ca4ed;
        }

        /* Submit Button */
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

    <div class="form-container">
        <h2>Edit Appointment Details</h2>
        <form action="" method="POST">
            <table class="form-table">
                <tr>
                    <td><label for="user_name">Customer Name:</label></td>
                    <td><input type="text" id="user_name" name="user_name" value="<?php echo $appointment['user_name']; ?>" required></td>
                </tr>
                <tr>
                    <td><label for="doctor_name">Doctor Name:</label></td>
                    <td><input type="text" id="doctor_name" name="doctor_name" value="<?php echo $appointment['doctor_name']; ?>" required></td>
                </tr>
                <tr>
                    <td><label for="appointment_date">Appointment Date:</label></td>
                    <td><input type="date" id="appointment_date" name="appointment_date" value="<?php echo $appointment['date']; ?>" required></td>
                </tr>
            </table>
            <button type="submit">Save Changes</button>
            <a href="schedule_appointment.php">Back</a>
        </form>
    </div>
</body>
</html>
