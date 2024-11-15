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

// Kiểm tra nếu tham số id tồn tại trong URL
if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Xóa lịch hẹn khỏi cơ sở dữ liệu
    $sql = "DELETE FROM appointments WHERE id = $appointment_id";

    if ($conn->query($sql) === TRUE) {
        // Sau khi xóa, chuyển hướng về trang lịch hẹn
        header('Location: schedule_appointment.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
