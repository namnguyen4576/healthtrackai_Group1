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

// Lấy ID lịch hẹn từ URL
if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Lấy thông tin lịch hẹn từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if (!$appointment) {
        echo "Appointment not found.";
        exit;
    }
    $stmt->close();
} else {
    echo "No appointment ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $doctor_name = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : '';
    $appointment_date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $note = isset($_POST['note']) ? $_POST['note'] : '';

    // Kiểm tra giá trị trước khi cập nhật
    if (!empty($user_name) && !empty($doctor_name) && !empty($appointment_date)) {
        $stmt = $conn->prepare("UPDATE appointments SET user_name = ?, doctor_name = ?, appointment_date = ?, phone_number = ?, note = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $user_name, $doctor_name, $appointment_date, $phone_number, $note, $appointment_id);

        if ($stmt->execute()) {
            header("Location: schedule_appointment.php"); // Điều hướng lại trang lịch hẹn sau khi cập nhật
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
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
            font-size: 16px;
        }

        /* Header */
        header {
            background-color: #007bff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: #fff;
            margin-bottom: 30px;
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
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: 0 auto;
            max-width: 800px;
        }

        .form-container h2 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 25px;
            color: #007bff;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #555;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background: #f9f9f9;
            transition: border 0.3s ease, background 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="datetime-local"]:focus,
        input[type="tel"]:focus,
        textarea:focus {
            border-color: #007bff;
            background: #eef7ff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"],
        a.btn {
            display: inline-block;
            padding: 12px 20px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover,
        a.btn:hover {
            background: #0056b3;
        }

        .cancel-btn {
            background: #dc3545;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background: #c82333;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }

            header h1 {
                font-size: 24px;
            }

            .form-container h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>HealthTrackAI - Edit Schedule Appointment</h1>
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
        <h2>Edit Appointment</h2>
        <form action="edit_appointment.php?id=<?php echo $appointment['id']; ?>" method="POST">
            <label for="user_name">Customer Name</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($appointment['user_name']); ?>" required>

            <label for="doctor_name">Doctor Name</label>
            <input type="text" id="doctor_name" name="doctor_name" value="<?php echo htmlspecialchars($appointment['doctor_name']); ?>" required>

            <label for="appointment_date">Appointment Date</label>
            <input type="datetime-local" id="appointment_date" name="appointment_date" value="<?php echo date("Y-m-d\TH:i", strtotime($appointment['appointment_date'])); ?>" required>

            <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($appointment['phone_number']); ?>" required>

            <label for="note">Note</label>
            <textarea id="note" name="note" rows="4"><?php echo htmlspecialchars($appointment['note']); ?></textarea>

            <div style="display: flex; justify-content: space-between;">
                <button type="submit" class="btn">Update Appointment</button>
                <a href="schedule_appointment.php" class="btn cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

</body>

</html>